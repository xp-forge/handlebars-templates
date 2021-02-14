<?php namespace web\frontend\helpers;

use util\{Date, TimeZone};

/** Date helper */
class Dates extends Extension {
  private $timezone, $formats;

  /**
   * Creates new dates extension using the given timezone and optional
   * named formats to be used with the `format` parameter.
   *
   * @param  util.TimeZone $timezone Pass NULL to use local timezone
   * @param  [:string] $formats Named formats
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
        $d= Date::now($this->timezone);
      } else if ($options[0] instanceof Date) {
        $d= $this->timezone->translate($options[0]);
      } else if ($r= $options['timestamp'] ?? null) {
        $d= new Date('@'.(int)($options[0] / $resolution[$r]), $this->timezone);
      } else {
        $d= $this->timezone->translate(new Date($options[0]));
      }

      return $d->toString($this->formats[$options['format'] ?? null] ?? $options['format']);
    };
  }
}