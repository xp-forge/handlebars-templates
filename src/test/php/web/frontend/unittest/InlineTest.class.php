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
      $this->transform($inline, 'One', 'list-item'),
    );
  }

  #[Test, Values(from: 'inline'), Expect(class: TemplateNotFoundException::class, message: '/No such fragment "non-existant"/')]
  public function non_existant($inline) {
    $this->transform($inline, null, 'non-existant');
  }
}