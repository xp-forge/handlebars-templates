<?php namespace web\frontend\helpers;

/** Number formatting helper */
class Numbers extends Extension {
  private $decimals, $thousands, $percent;

  /**
   * Creates new numbers formatting helper with given decimals and
   * thousands separators.
   *
   * @see    https://www.php.net/number_format
   * @see    https://docs.microsoft.com/en-us/globalization/locale/number-formatting
   * @param  string $decimals
   * @param  string $thousands
   * @param  string $percent
   */
  public function __construct($decimals= '.', $thousands= '', $percent= '#%') {
    $this->decimals= $decimals;
    $this->thousands= $thousands;
    $this->percent= $percent;
  }

  /** @return iterable */
  public function helpers() {
    yield 'number' => function($in, $context, $options) {
      $n= $options[0];
      return number_format(
        $n,
        $options['decimals'] ?? (false === ($p= strpos($n, '.')) ? 0 : strlen($n) - $p - 1),
        $this->decimals,
        $this->thousands
      );
    };
    yield 'percent'  => function($in, $context, $options) {
      $n= $options[0] * 100;
      return strtr($this->percent, ['#' => number_format(
        $n,
        $options['decimals'] ?? (false === ($p= strpos($n, '.')) ? 0 : strlen($n) - $p - 1),
        $this->decimals,
        $this->thousands
      )]);
    };
    yield 'count' => function($in, $context, $options) {
      $n= (int)$options[0];
      if (0 === $n) {
        return $options[1];
      } else if (1 === $n) {
        return $options[2];
      } else {
        return strtr($options[3], ['#' => number_format(
          $n,
          $options['decimals'] ?? (false === ($p= strpos($n, '.')) ? 0 : strlen($n) - $p - 1),
          $this->decimals,
          $this->thousands
        )]);
      }
    };
  }
}