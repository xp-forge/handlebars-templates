<?php namespace web\frontend\helpers;

class Essentials implements Extension {

  /** @return iterable */
  public function helpers() {
    yield 'encode' => function($in, $context, $options) {
      return rawurlencode($options[0] ?? '');
    };
    yield 'equals' => function($in, $context, $options) {
      return (int)(($options[0] ?? null) === ($options[1] ?? null));
    };
    yield 'contains' => function($in, $context, $options) {
      if (!isset($options[0])) {
        return 0;
      } else if (is_array($options[0])) {
        return (int)in_array($options[1] ?? null, $options[0]);
      } else {
        return false === strpos($options[0], $options[1] ?? null) ? 0 : 1;
      }
    };
    yield 'size' => function($in, $context, $options) {
      if (!isset($options[0])) {
        return 0;
      } else if ($options[0] instanceof \Countable || is_array($options[0])) {
        return sizeof($options[0]);
      } else {
        return strlen($options[0]);
      }
    };
  }
}