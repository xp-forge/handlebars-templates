<?php namespace web\frontend\unittest;

use com\github\mustache\InMemory;
use test\{Assert, Expect, Test};
use util\NoSuchElementException;
use web\frontend\{Handlebars, WithNamespaces};

class WithNamespacesTest extends HandlebarsTest {

  #[Test]
  public function can_create() {
    new WithNamespaces($this->templates, []);
  }

  #[Test, Expect(class: NoSuchElementException::class, message: 'Unknown namespace "nonexistant"')]
  public function errors_for_non_existant_namespaces() {
    (new WithNamespaces($this->templates, []))->source('nonexistant:name');
  }

  #[Test]
  public function render_directly() {
    $fixture= new Handlebars(new WithNamespaces(
      $this->templates,
      ['layout' => (new InMemory())->add('content', '<h1>{{title}}</h1>')]
    ));

    Assert::equals('<h1>Test</h1>', $fixture->render('layout:content', ['title' => 'Test']));
  }

  #[Test]
  public function referenced_as_partial() {
    $fixture= new Handlebars(new WithNamespaces(
      $this->templates->add('fixture', '{{> layout:content}}'),
      ['layout' => (new InMemory())->add('content', '<h1>{{title}}</h1>')]
    ));

    Assert::equals('<h1>Test</h1>', $fixture->render('fixture', ['title' => 'Test']));
  }

  #[Test]
  public function passing_variables_to_partial() {
    $fixture= new Handlebars(new WithNamespaces(
      $this->templates->add('fixture', '{{> layout:content title="Test"}}'),
      ['layout' => (new InMemory())->add('content', '<h1>{{title}}</h1>')]
    ));

    Assert::equals('<h1>Test</h1>', $fixture->render('fixture', []));
  }
}