<?php namespace web\frontend\helpers;

use util\Date;

class Dates implements Extension {

  /** @return iterable */
  public function helpers() {
    yield 'date' => function($in, $context, $options) {
      static $resolution= ['s' => 1, 'ms' => 1000];

      if (!isset($options[0])) {
        $d= Date::now();
      } else if ($options[0] instanceof Date) {
        $d= $options[0];
      } else if ($r= $options['timestamp'] ?? null) {
        $d= new Date('@'.(int)($options[0] / $resolution[$r]));
      } else {
        $d= new Date($options[0]);
      }
      return $d->toString($options['format'] ?? 'd.m.Y');
    };
  }
}