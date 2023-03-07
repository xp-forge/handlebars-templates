<?php namespace web\frontend\unittest;

use test\{Assert, Test, Values};

class EssentialsTest extends HandlebarsTest {

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

  #[Test, Values([['test', 4], ['numbers', 3], ['sizes', 2], ['empty', 0], ['count', 1], ['null', 0]])]
  public function size($expr, $expected) {
    Assert::equals((string)$expected, $this->transform('{{size '.$expr.'}}', [
      'test'    => 'Test',
      'numbers' => [1, 2, 3],
      'sizes'   => ['S' => 12.99, 'M' => 13.99],
      'count'   => new class() implements \Countable { public function count(): int { return 1; } },
      'empty'   => [],
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
}