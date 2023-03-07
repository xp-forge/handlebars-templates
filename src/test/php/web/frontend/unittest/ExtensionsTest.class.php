<?php namespace web\frontend\unittest;

use test\{Assert, Test, Values};

class ExtensionsTest extends HandlebarsTest {

  /** @return web.frontend.Extension[] */
  protected function extensions() {
    return [[
      'scalar'   => 'test',
      'map'      => ['test' => 'works'],
      'function' => function($in, $context, $options) {
        return strtoupper($options[0]);
      }
    ]];
  }

  #[Test]
  public function bound_scalar() {
    Assert::equals('test', $this->transform('{{scalar}}'));
  }

  #[Test]
  public function bound_map() {
    Assert::equals('works', $this->transform('{{map.test}}'));
  }

  #[Test]
  public function bound_function() {
    Assert::equals('TEST', $this->transform('{{function "test"}}'));
  }
}