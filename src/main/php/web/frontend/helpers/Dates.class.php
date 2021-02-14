<?php namespace web\frontend\helpers;

use util\{Date, TimeZone};

class Dates implements Extension {
  private $timezone, $formats;

  /**
   * Creates new dates extension using the given timezone and optional
   * named formats to be used with the `format` parameter.
   */
  public function __construct(TimeZone $timezone= null, $formats= []) {
    $this->timezone= $timezone ?? TimeZone::getLocal();
    $this->formats= $formats + [null => 'd.m.Y H:i:s'];
  }

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

      return $d->toString($this->formats[$options['format'] ?? null] ?? $options['format']);
    };
  }
}