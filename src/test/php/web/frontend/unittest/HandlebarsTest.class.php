<?php namespace web\frontend\unittest;

use com\github\mustache\InMemory;
use io\streams\MemoryOutputStream;
use unittest\{Assert, Test};
use util\Date;
use web\frontend\Handlebars;

class HandlebarsTest {
  private $templates;

  /** Initialize test fixtures */
  public function __construct() {
    $this->templates= new InMemory();
  }

  /**
   * Transforms a template and returns the result. Uses a scope (or
   * template name) of "fixture".
   *
   * @param  string $template
   * @param  [:var] $context
   * @return string
   */
  private function transform($template, $context= []) {
    $out= new MemoryOutputStream();
    $fixture= new Handlebars($this->templates->add('fixture', $template));
    $fixture->write('fixture', $context, $out);
    return $out->bytes();
  }

  #[Test]
  public function can_create() {
    new Handlebars($this->templates);
  }

  #[Test]
  public function transformation_scope_accessible() {
    Assert::equals(
      '<h1>Hello @fixture!</h1>',
      $this->transform('<h1>Hello @{{scope}}!</h1>')
    );
  }

  #[Test]
  public function url_encode() {
    Assert::equals(
      '<a href="/user/~test%2Ffixture">...</a>',
      $this->transform('<a href="/user/{{encode id}}">...</a>', ['id' => '~test/fixture'])
    );
  }

  #[Test, Values(['{{equals "A" "A"}}', '{{equals "A" a}}', '{{equals a a}}'])]
  public function are_equal($template) {
    Assert::equals('1', $this->transform($template, ['a' => 'A']));
  }

  #[Test, Values(['{{equals "A" "B"}}', '{{equals "B" a}}', '{{equals b a}}'])]
  public function not_equal($template) {
    Assert::equals('0', $this->transform($template, ['a' => 'A']));
  }

  #[Test, Values(['{{contains test "Test"}}', '{{contains test "e"}}', '{{contains numbers 1}}'])]
  public function is_contained($template) {
    Assert::equals('1', $this->transform($template, [
      'test'    => 'Test',
      'numbers' => [1, 2, 3],
    ]));
  }

  #[Test, Values(['{{contains test "Hi"}}', '{{contains test "a"}}', '{{contains numbers 4}}'])]
  public function not_contained($template) {
    Assert::equals('0', $this->transform($template, [
      'test'    => 'Test',
      'numbers' => [1, 2, 3],
    ]));
  }

  #[Test, Values([['0 2 4', 4], ['numbers', 3]])]
  public function max($expr, $expected) {
    Assert::equals((string)$expected, $this->transform('{{max '.$expr.'}}', [
      'numbers' => [1, 2, 3],
    ]));
  }

  #[Test, Values([['0 2 4', 0], ['numbers', 1]])]
  public function min($expr, $expected) {
    Assert::equals((string)$expected, $this->transform('{{min '.$expr.'}}', [
      'numbers' => [1, 2, 3],
    ]));
  }

  #[Test, Values([['test', 4], ['numbers', 3], ['sizes', 2], ['empty', 0], ['count', 1], ['null', 0]])]
  public function size($expr, $expected) {
    Assert::equals((string)$expected, $this->transform('{{size '.$expr.'}}', [
      'test'    => 'Test',
      'numbers' => [1, 2, 3],
      'sizes'   => ['S' => 12.99, 'M' => 13.99],
      'count'   => new class() implements \Countable { public function count() { return 1; } },
      'empty'   => [],
    ]));
  }

  #[Test, Values(eval: '[new Date("2021-02-13"), "2021-02-13", 1613209181]')]
  public function dates_with_format($date) {
    Assert::equals(
      '2021-02-13',
      $this->transform('{{date tested format="Y-m-d"}}', ['tested' => $date])
    );
  }

  #[Test, Values(eval: '[new Date("2021-02-13"), "2021-02-13", 1613209181]')]
  public function dates_with_default_format($date) {
    Assert::equals(
      '13.02.2021',
      $this->transform('{{date tested}}', ['tested' => $date])
    );
  }

  #[Test, Values(['{{date}}', '{{date null}}'])]
  public function current_date($template) {
    Assert::equals(Date::now()->toString('d.m.Y'), $this->transform($template));
  }

  #[Test, Values(['{{date 1613235019279 timestamp="ms"}}', '{{date 1613235019 timestamp="s"}}'])]
  public function timestamp_resolution($template) {
    Assert::equals('13.02.2021', $this->transform($template));
  }

  #[Test, Values([['', 0], ['null', 0], ['"test"', 1], ['null "test"', 1], ['numbers', 1], ['empty', 0]])]
  public function any($expr, $expected) {
    Assert::equals((string)$expected, $this->transform('{{any '.$expr.'}}', [
      'numbers' => [1, 2, 3],
      'empty'   => [],
    ]));
  }

  #[Test, Values([['', 1], ['null', 1], ['"test"', 0], ['null "test"', 0], ['numbers', 0], ['empty', 1]])]
  public function none($expr, $expected) {
    Assert::equals((string)$expected, $this->transform('{{none '.$expr.'}}', [
      'numbers' => [1, 2, 3],
      'empty'   => [],
    ]));
  }

  #[Test, Values([['', 0], ['null', 0], ['"test"', 1], ['null "test"', 0], ['numbers', 1], ['empty', 0]])]
  public function all($expr, $expected) {
    Assert::equals((string)$expected, $this->transform('{{all '.$expr.'}}', [
      'numbers' => [1, 2, 3],
      'empty'   => [],
    ]));
  }

  #[Test]
  public function logging_echoes_content() {
    ob_start();
    $this->transform('{{log "Hello" user}}', ['user' => 'test']);
    $logged= ob_get_clean();

    Assert::equals("  \"Hello\"\n  \"test\"\n", $logged);
  }
}