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

      $tz= isset($options['timezone']) ? TimeZone::getByName($options['timezone']) : $this->timezone;
      if (!isset($options[0])) {
        $d= Date::now($tz);
      } else if ($options[0] instanceof Date) {
        $d= $tz->translate($options[0]);
      } else if ($r= $options['timestamp'] ?? null) {
        $d= new Date((int)($options[0] / $resolution[$r]), $tz);
      } else {
        $d= $tz->translate(new Date($options[0]));
      }

      return $d->toString($this->formats[$options['format'] ?? null] ?? $options['format']);
    };
  }
}