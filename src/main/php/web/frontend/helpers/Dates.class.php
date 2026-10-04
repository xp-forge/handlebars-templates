<?php namespace web\frontend\helpers;

use util\{Date, TimeZone};

/** Date helper */
class Dates extends Extension {
  private $timezone, $formats;

  /**
   * Creates new dates extension using the given timezone and optional
   * named formats to be used with the `format` parameter.
   *
   * @param  ?util.TimeZone $timezone Pass NULL to use local timezone
   * @param  [:string] $formats Named formats
   */
  public function __construct($timezone= null, $formats= []) {
    $this->timezone= $timezone ?? TimeZone::getLocal();
    $this->formats= $formats + ['' => 'd.m.Y H:i:s'];
  }

  /** @return iterable */
  public function helpers() {
    static $resolution= ['s' => 1, 'ms' => 1000];

    yield 'date' => function($in, $context, $options) use($resolution) {
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

      return $d->toString($this->formats[$options['format'] ?? ''] ?? $options['format']);
    };

    yield 'duration' => function($in, $context, $options) use($resolution) {
      if ($r= $options['timestamp'] ?? null) {
        $s= (int)($options[0] / $resolution[$r]);
      } else {
        $s= (int)$options[0];
      }

      $h= (int)($s / 3600); $s%= 3600;
      $m= (int)($s / 60); $s%= 60;

      return strtr($options['format'] ?? 'H:i:s', [
        'H' => $h < 10 ? "0$h" : $h,
        'i' => $m < 10 ? "0$m" : $m,
        's' => $s < 10 ? "0$s" : $s,
        'G' => $h,
        'm' => $m,
      ]);
    };
  }
}