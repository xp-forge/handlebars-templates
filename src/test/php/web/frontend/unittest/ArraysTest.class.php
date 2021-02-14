<?php namespace web\frontend\unittest;

use unittest\{Assert, Test, Values};

class ArraysTest extends HandlebarsTest {

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