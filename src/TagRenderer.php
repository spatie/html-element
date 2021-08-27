<?php

namespace Spatie\HtmlElement;

class TagRenderer
{
    /** @var string */
    protected $element;

    /** @var \Spatie\HtmlElement\Attributes */
    protected $attributes;

    /** @var string */
    protected $contents;

    public static function render(string $element, Attributes $attributes, string $contents): string
    {
        return (new static($element, $attributes, $contents))->renderTag();
    }

    protected function __construct(string $element, Attributes $attributes, string $contents)
    {
        $this->element = $element;
        $this->attributes = $attributes;
        $this->contents = $contents;
    }

    protected function renderTag(): string
    {
        if ($this->isSelfClosingTag()) {
            return $this->renderOpeningTag();
        }

        return "{$this->renderOpeningTag()}{$this->contents}{$this->renderClosingTag()}";
    }

    protected function renderOpeningTag(): string
    {
        return $this->attributes->isEmpty() ?
            "<{$this->element}>" :
            "<{$this->element} {$this->attributes}>";
    }

    protected function renderClosingTag(): string
    {
        return "</{$this->element}>";
    }

    protected function isSelfClosingTag(): bool
    {
        return in_array(strtolower($this->element), [
            'area', 'base', 'br', 'col', 'embed', 'hr',
            'img', 'input', 'keygen', 'link', 'menuitem',
            'meta', 'param', 'source', 'track', 'wbr',
        ]);
    }
}
