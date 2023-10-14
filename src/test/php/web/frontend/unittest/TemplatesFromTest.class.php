<?php namespace web\frontend\unittest;

use com\github\mustache\InMemory;
use test\{Assert, Expect, Test};
use util\NoSuchElementException;
use web\frontend\{Handlebars, TemplatesFrom};

class TemplatesFromTest extends HandlebarsTest {

  #[Test]
  public function can_create_with_templates() {
    new TemplatesFrom($this->templates);
  }

  #[Test]
  public function can_create_with_path() {
    new TemplatesFrom('src/main/handlebars');
  }

  #[Test, Expect(class: NoSuchElementException::class, message: 'Unknown namespace "nonexistant"')]
  public function errors_for_non_existant_namespaces() {
    (new TemplatesFrom($this->templates))->source('nonexistant:name');
  }

  #[Test]
  public function render_directly() {
    $fixture= new Handlebars(new TemplatesFrom(
      $this->templates,
      ['layout' => (new InMemory())->add('content', '<h1>{{title}}</h1>')]
    ));

    Assert::equals('<h1>Test</h1>', $fixture->render('layout:content', ['title' => 'Test']));
  }

  #[Test]
  public function referenced_as_partial() {
    $fixture= new Handlebars(new TemplatesFrom(
      $this->templates->add('fixture', '{{> layout:content}}'),
      ['layout' => (new InMemory())->add('content', '<h1>{{title}}</h1>')]
    ));

    Assert::equals('<h1>Test</h1>', $fixture->render('fixture', ['title' => 'Test']));
  }

  #[Test]
  public function passing_variables_to_partial() {
    $fixture= new Handlebars(new TemplatesFrom(
      $this->templates->add('fixture', '{{> layout:content title="Test"}}'),
      ['layout' => (new InMemory())->add('content', '<h1>{{title}}</h1>')]
    ));

    Assert::equals('<h1>Test</h1>', $fixture->render('fixture', []));
  }

  #[Test]
  public function partial_blocks() {
    $template= '{{#> layout:content}}{{#*inline "title"}}Test{{/inline}}{{/layout:content}}';
    $fixture= new Handlebars(new TemplatesFrom(
      $this->templates->add('fixture', $template),
      ['layout' => (new InMemory())->add('content', '<h1>{{> title}}</h1>')]
    ));

    Assert::equals('<h1>Test</h1>', $fixture->render('fixture', []));
  }
}