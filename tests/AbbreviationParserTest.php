<?php

namespace Spatie\HtmlElement\Test;

use PHPUnit\Framework\TestCase;
use Spatie\HtmlElement\AbbreviationParser;

class AbbreviationParserTest extends TestCase
{
    /** @test */
    public function it_can_parse_a_plain_element()
    {
        $this->assertEquals(
            ['element' => 'div', 'classes' => [], 'attributes' => []],
            AbbreviationParser::parse('div')
        );
    }

    /** @test */
    public function it_can_parse_an_element_with_an_id()
    {
        $this->assertEquals(
            ['element' => 'div', 'classes' => [], 'attributes' => ['id' => 'main']],
            AbbreviationParser::parse('div#main')
        );
    }

    /** @test */
    public function it_can_parse_an_element_with_a_class()
    {
        $this->assertEquals(
            ['element' => 'div', 'classes' => ['container'], 'attributes' => []],
            AbbreviationParser::parse('div.container')
        );
    }

    /** @test */
    public function it_can_parse_an_element_with_multiple_classes()
    {
        $this->assertEquals(
            ['element' => 'div', 'classes' => ['container', 'fluid'], 'attributes' => []],
            AbbreviationParser::parse('div.container.fluid')
        );
    }

    /** @test */
    public function it_can_parse_an_element_with_an_id_and_a_class()
    {
        $this->assertEquals(
            ['element' => 'div', 'classes' => ['container'], 'attributes' => ['id' => 'main']],
            AbbreviationParser::parse('div#main.container')
        );
    }

    /** @test */
    public function it_can_parse_attributes()
    {
        $this->assertEquals(
            ['element' => 'a', 'classes' => [], 'attributes' => ['href' => '#']],
            AbbreviationParser::parse('a[href=#]')
        );
    }

    /** @test */
    public function it_can_parse_attributes_with_single_quotes()
    {
        $this->assertEquals(
            ['element' => 'a', 'classes' => [], 'attributes' => ['href' => '#']],
            AbbreviationParser::parse("a[href='#']")
        );
    }

    /** @test */
    public function it_can_parse_attributes_with_double_quotes()
    {
        $this->assertEquals(
            ['element' => 'a', 'classes' => [], 'attributes' => ['href' => '#']],
            AbbreviationParser::parse('a[href="#"]')
        );
    }

    /** @test */
    public function it_can_parse_attributes_without_values()
    {
        $this->assertEquals(
            ['element' => 'input', 'classes' => [], 'attributes' => ['required' => null]],
            AbbreviationParser::parse('input[required]')
        );
    }

    /** @test */
    public function it_can_parse_attributes_and_classes()
    {
        $this->assertEquals(
            ['element' => 'a', 'classes' => ['foo', 'bar'], 'attributes' => ['href' => '#']],
            AbbreviationParser::parse('a.foo[href="#"].bar')
        );
    }

    /** @test */
    public function it_can_parse_multiple_attributes()
    {
        $this->assertEquals(
            ['element' => 'a', 'classes' => [], 'attributes' => ['href' => '#', 'title' => 'Link']],
            AbbreviationParser::parse('a[href="#"][title="Link"]')
        );
    }

    /** @test */
    public function it_can_parse_attributes_containing_class_and_id_characters()
    {
        $this->assertEquals(
            ['element' => 'a', 'classes' => [], 'attributes' => ['href' => 'https://spatie.be/#top']],
            AbbreviationParser::parse('a[href=https://spatie.be/#top]')
        );
    }
}
