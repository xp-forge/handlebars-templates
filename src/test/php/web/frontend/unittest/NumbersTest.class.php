<?php namespace web\frontend\unittest;

use test\{Assert, Test, Values};
use web\frontend\helpers\Numbers;

class NumbersTest extends HandlebarsTest {

  /** @return web.frontend.Extension[] */
  protected function extensions() {
    return [new Numbers('.', ',', '#%')];
  }

  #[Test, Values([[1, '1'], [1000, '1,000'], [-1000, '-1,000'], [1000000, '1,000,000'], [1234.56, '1,234.56']])]
  public function thousands_separator($number, $expected) {
    Assert::equals($expected, $this->transform('{{number fixture}}', ['fixture' => $number]));
  }

  #[Test, Values([[1, '1'], [0.5, '0.5'], [-0.5, '-0.5'], [0.123456789, '0.123456789']])]
  public function decimals_separator($number, $expected) {
    Assert::equals($expected, $this->transform('{{number fixture}}', ['fixture' => $number]));
  }

  #[Test, Values([[1, '1.00'], [0.5, '0.50'], [-0.5, '-0.50'], [0.123456789, '0.12'], [0.129, '0.13']])]
  public function two_decimals($number, $expected) {
    Assert::equals($expected, $this->transform('{{number fixture decimals=2}}', ['fixture' => $number]));
  }

  #[Test, Values([[1, '1'], [0.5, '1'], [-0.5, '-1'], [0.123456789, '0']])]
  public function no_decimals($number, $expected) {
    Assert::equals($expected, $this->transform('{{number fixture decimals=0}}', ['fixture' => $number]));
  }

  #[Test, Values([[1, '100%'], [0.5, '50%'], [0.125, '12.5%']])]
  public function percentages($number, $expected) {
    Assert::equals($expected, $this->transform('{{percent fixture}}', ['fixture' => $number]));
  }

  #[Test, Values([[1, '100%'], [0.5, '50%'], [0.125, '13%']])]
  public function percentages_without_decimals($number, $expected) {
    Assert::equals($expected, $this->transform('{{percent fixture decimals=0}}', ['fixture' => $number]));
  }

  #[Test, Values([[1, '100.0%'], [0.5, '50.0%'], [0.125, '12.5%']])]
  public function percentages_with_decimals($number, $expected) {
    Assert::equals($expected, $this->transform('{{percent fixture decimals=1}}', ['fixture' => $number]));
  }

  #[Test, Values([[0, 'no items'], [1, 'one item'], [2, '2 items'], [1000, '1,000 items']])]
  public function count($number, $expected) {
    Assert::equals($expected, $this->transform('{{count fixture "no items" "one item" "# items"}}', ['fixture' => $number]));
  }

  #[Test, Values([['0', 'no items'], [null, 'no items'], [false, 'no items'], ['1', 'one item'], ['2', '2 items']])]
  public function count_casts_to_integer($number, $expected) {
    Assert::equals($expected, $this->transform('{{count fixture "no items" "one item" "# items"}}', ['fixture' => $number]));
  }
}