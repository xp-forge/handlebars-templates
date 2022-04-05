<?php namespace web\frontend\unittest;

use unittest\{Assert, Test};
use web\frontend\helpers\Functions;

class FunctionsTest extends HandlebarsTest {

  /** @return web.frontend.Extension[] */
  protected function extensions() {
    return [new Functions([
      'top' => function($node, $context, $args) {
        return array_slice($args[1], 0, $args[0]);
      }
    ])];
  }

  #[Test]
  public function top_three() {
    Assert::equals(
      'ABC',
      $this->transform('{{#each (top 3 people)}}{{.}}{{/each}}', ['people' => ['A', 'B', 'C', 'D']])
    );
  }
}