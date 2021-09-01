<?php

namespace Spatie\HtmlElement\Test;

use PHPUnit\Framework\TestCase;
use Spatie\HtmlElement\HtmlElement;

class HtmlElementTest extends TestCase
{
    /** @test */
    public function it_parses_a_tag()
    {
        $this->assertEquals(
            '<div></div>',
            HtmlElement::render('div')
        );
    }

    /** @test */
    public function it_parses_a_tag_with_text_contents()
    {
        $this->assertEquals(
            '<div>Hello world</div>',
            HtmlElement::render('div', 'Hello world')
        );
    }

    /** @test */
    public function it_parses_a_tag_with_empty_arguments_and_text_contents()
    {
        $this->assertEquals(
            '<div>Hello world</div>',
            HtmlElement::render('div', [], 'Hello world')
        );
    }

    /** @test */
    public function it_parses_a_tag_with_a_plain_argument()
    {
        $this->assertEquals(
            '<div class="intro">Hello world</div>',
            HtmlElement::render('div', ['class' => 'intro'], 'Hello world')
        );
    }

    /** @test */
    public function it_parses_a_tag_with_an_argument_without_a_value()
    {
        $this->assertEquals(
            '<div contenteditable>Hello world</div>',
            HtmlElement::render('div', ['contenteditable'], 'Hello world')
        );
    }

    /** @test */
    public function it_parses_a_tag_with_an_argument_containing_zero()
    {
        $this->assertEquals(
            '<option value="0">Choose one...</option>',
            HtmlElement::render('option', ['value' => 0], 'Choose one...')
        );
    }

    /** @test */
    public function it_parses_an_array_of_content_items()
    {
        $this->assertEquals(
            '<ul><li>Cookies</li><li>Cream</li></ul>',
            HtmlElement::render('ul', ['<li>Cookies</li>', '<li>Cream</li>'])
        );
    }

    /** @test */
    public function it_parses_an_id_passed_in_through_the_tag_name()
    {
        $this->assertEquals(
            '<div id="container"></div>',
            HtmlElement::render('div#container')
        );
    }

    /** @test */
    public function it_parses_an_attribute_passed_in_through_the_tag_name()
    {
        $this->assertEquals(
            '<a href="#">Hello world</a>',
            HtmlElement::render('a[href=#]', 'Hello world')
        );
    }

    /** @test */
    public function it_parses_an_attribute_without_value_passed_in_through_the_tag_name()
    {
        $this->assertEquals(
            '<input required>',
            HtmlElement::render('input[required]')
        );
    }

    /** @test */
    public function it_only_parses_one_id_passed_in_through_the_tag_name()
    {
        $this->assertEquals(
            '<div id="container"></div>',
            HtmlElement::render('div#main#container')
        );
    }

    /** @test */
    public function it_parses_a_class_passed_in_through_the_tag_name()
    {
        $this->assertEquals(
            '<div class="container"></div>',
            HtmlElement::render('div.container')
        );
    }

    /** @test */
    public function it_parses_multiple_classes_passed_in_through_the_tag_name()
    {
        $this->assertEquals(
            '<div class="container fluid"></div>',
            HtmlElement::render('div.container.fluid')
        );
    }

    /** @test */
    public function it_merges_classes_passed_in_through_the_tag_name_and_attributes()
    {
        $this->assertEquals(
            '<div class="container fluid"></div>',
            HtmlElement::render('div.container', ['class' => ['fluid']], '')
        );
    }

    /** @test */
    public function it_renders_self_closing_tags_when_relevant()
    {
        $this->assertEquals(
            '<img src="/background.jpg">',
            HtmlElement::render('img', ['src' => '/background.jpg'], [])
        );
    }

    /** @test */
    public function it_recognizes_uppercase_self_closing_tags()
    {
        $this->assertEquals(
            '<IMG src="/background.jpg">',
            HtmlElement::render('IMG', ['src' => '/background.jpg'], [])
        );
    }

    /** @test */
    public function it_renders_emmet_style_nested_tags()
    {
        $this->assertEquals(
            '<div class="container"><div class="row"></div></div>',
            HtmlElement::render('div.container>div.row')
        );
    }

    /** @test */
    public function it_allows_spaces_around_child_separators()
    {
        $this->assertEquals(
            '<div class="container"><div class="row"></div></div>',
            HtmlElement::render('div.container > div.row')
        );
    }

    /** @test */
    public function it_expands_implicit_divs()
    {
        $this->assertEquals(
            '<div class="classname"></div>',
            HtmlElement::render('.classname')
        );
    }

    /** @test */
    public function it_supports_nesteed_implicit_divs()
    {
        $this->assertEquals(
            '<div class="container"><div class="row"></div></div>',
            HtmlElement::render('.container > .row')
        );
    }
}
