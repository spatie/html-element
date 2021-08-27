<?php

namespace Spatie\HtmlElement;

use Spatie\HtmlElement\Helpers\Arr;

class AbbreviationParser
{
    /** @var string */
    protected $element = 'div';

    /** @var array */
    protected $classes = [];

    /** @var array */
    protected $attributes = [];

    public static function parse(string $tag): array
    {
        $parsed = (new static($tag));

        return [
            'element' => $parsed->element,
            'classes' => $parsed->classes,
            'attributes' => $parsed->attributes,
        ];
    }

    protected function __construct(string $tag)
    {
        $this->parseTag($tag);
    }

    protected function parseTag(string $tag)
    {
        foreach ($this->explodeTag($tag) as $part) {
            switch ($part[0] ?? '') {
                case '.':
                    $this->parseClass($part);

                    break;
                case '#':
                    $this->parseId($part);

                    break;
                case '[':
                    $this->parseAttribute($part);

                    break;
                default:
                    $this->parseElement($part);

                    break;
            }
        }
    }

    protected function parseClass(string $class)
    {
        $this->classes[] = ltrim($class, '.');
    }

    protected function parseId(string $id)
    {
        $this->attributes['id'] = ltrim($id, '#');
    }

    protected function parseAttribute(string $attribute)
    {
        $keyValueSet = explode('=', trim($attribute, '[]'), 2);

        $key = $keyValueSet[0];
        $value = $keyValueSet[1] ?? null;

        $this->attributes[$key] = trim($value, '\'"');
    }

    protected function parseElement(string $element)
    {
        $this->element = $element;
    }

    protected function explodeTag(string $tag): array
    {
        // First split out the attributes set with `[...=...]`
        $parts = preg_split('/(?=( \[[^]]+] ))/x', $tag);

        // Afterwards we can extract the rest of the attributes
        return Arr::flatMap($parts, function ($part) {
            if (strpos($part, '[') === 0) {
                list($attributeValue, $rest) = explode(']', $part, 2);

                return [$attributeValue] + $this->explodeTag($rest);
            }

            return preg_split('/(?=( (\.) | (\#) ))/x', $part);
        });
    }
}
