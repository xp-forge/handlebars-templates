<?php namespace web\frontend\helpers;

/** Built-in and automatically loaded essentials */
class Essentials extends Extension {

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