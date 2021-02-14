<?php namespace web\frontend\helpers;

class Arrays implements Extension {

  /** @return iterable */
  public function helpers() {
    yield 'max' => function($in, $context, $options) {
      switch (sizeof($options)) {
        case 0: return 0;
        case 1: return max($options[0]);
        default: return max($options);
      }
    };
    yield 'min' => function($in, $context, $options) {
      switch (sizeof($options)) {
        case 0: return 0;
        case 1: return min($options[0]);
        default: return min($options);
      }
    };
    yield 'any' => function($in, $context, $options) {
      foreach ($options as $option) {
        if ($context->isTruthy($option)) return 1;
      }
      return 0;
    };
    yield 'none' => function($in, $context, $options) {
      foreach ($options as $option) {
        if ($context->isTruthy($option)) return 0;
      }
      return 1;
    };
    yield 'all' => function($in, $context, $options) {
      foreach ($options as $option) {
        if (!$context->isTruthy($option)) return 0;
      }
      return empty($options) ? 0 : 1;
    };
  }
}