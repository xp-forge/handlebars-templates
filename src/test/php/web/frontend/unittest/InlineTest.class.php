<?php namespace web\frontend\unittest;

use com\github\mustache\TemplateNotFoundException;
use test\{Assert, Expect, Test, Values};

class InlineTest extends HandlebarsTest {

  /** @return iterable */
  private function inline() {
    yield ['{{#*inline "list-item"}}* {{.}} {{/inline}}{{#each items}}{{> list-item}}{{/each}}'];
    yield ['{{#> layout}}{{#*inline "list-item"}}* {{.}} {{/inline}}{{#each items}}{{> list-item}}{{/each}}{{/layout}}'];
  }

  #[Test, Values(from: 'inline')]
  public function apply($inline) {
    Assert::equals(
      '* One * Two ',
      $this->transform($inline, ['items' => ['One', 'Two']])
    );
  }

  #[Test, Values(from: 'inline')]
  public function render_directly($inline) {
    Assert::equals(
      '* One ',
      $this->transform($inline, ['One'], 'list-item')
    );
  }

  #[Test, Values(from: 'inline'), Expect(class: TemplateNotFoundException::class, message: '/No such fragment "non-existant"/')]
  public function non_existant($inline) {
    $this->transform($inline, null, 'non-existant');
  }

  #[Test]
  public function fragment() {
    $template= 'Test: {{#*fragment "item"}}{{key}}{{/fragment}}';
    Assert::equals(
      'Test: value',
      $this->transform($template, ['key' => 'value'])
    );
  }

  #[Test]
  public function fragment_around_each() {
    $template= 'Test: {{#*fragment "items"}}{{#each items}}* {{.}} {{/each}}{{/fragment}}';
    Assert::equals(
      'Test: * One * Two ',
      $this->transform($template, ['items' => ['One', 'Two']])
    );
  }

  #[Test]
  public function fragment_inside_each() {
    $template= 'Test: {{#each items}}{{#*fragment "item"}}* {{.}} {{/fragment}}{{/each}}';
    Assert::equals(
      'Test: * One * Two ',
      $this->transform($template, ['items' => ['One', 'Two']])
    );
  }

  #[Test]
  public function nested_fragment() {
    $template=
      'Test: {{#*fragment "items"}}'.
      '{{#each items}}{{#*fragment "item"}}* {{.}}{{/fragment}} {{/each}}'.
      '{{/fragment}}'
    ;
    Assert::equals(
      '* One * Two ',
      $this->transform($template, ['items' => ['One', 'Two']], 'items')
    );
  }

  #[Test]
  public function fragment_parameters() {
    $template=
      'Test: {{#*fragment "items" select=items separator=", "}}'.
      '{{#each select}}{{.}}{{#unless @last}}{{separator}}{{/unless}}{{/each}}'.
      '{{/fragment}}'
    ;
    Assert::equals(
      'Test: One, Two',
      $this->transform($template, ['items' => ['One', 'Two']])
    );
  }
}