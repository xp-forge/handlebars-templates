<?php namespace web\frontend\unittest;

use test\{Assert, Test, Values};
use web\frontend\helpers\Functions;

class FunctionsTest extends HandlebarsTest {

  /** @return web.frontend.Extension[] */
  protected function extensions() {
    return [new Functions([
      'top' => function($node, $context, $options) {
        return array_slice($options[1], 0, $options[0]);
      },
      'and' => function($node, $context, $options) {
        $list= $options[0];
        switch (sizeof($list)) {
          case 0: return '';
          case 1: return $list[0];
          case 2: return $list[0].' and '.$list[1];
          default: $last= array_pop($list); return implode(', ', $list).' and '.$last;
        }
      }
    ])];
  }

  /** @return iterable */
  private function lists() {
    yield [[], ''];
    yield [['A'], 'A'];
    yield [['A', 'B'], 'A and B'];
    yield [['A', 'B', 'C'], 'A, B and C'];
    yield [['A', 'B', 'C', 'D'], 'A, B, C and D'];
  }

  #[Test]
  public function top_three() {
    Assert::equals('ABC', $this->transform('{{#each (top 3 people)}}{{.}}{{/each}}', [
      'people' => ['A', 'B', 'C', 'D']
    ]));
  }

  #[Test, Values(from: 'lists')]
  public function and($list, $result) {
    Assert::equals($result, $this->transform('{{and people}}', ['people' => $list]));
  }
}