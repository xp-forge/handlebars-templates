<?php namespace web\frontend\unittest;

use unittest\{Assert, Test, Values};
use util\Date;
use web\frontend\helpers\Dates;

class DatesTest extends HandlebarsTest {
  const FORMAT = 'd.m.Y';

  /** @return web.frontend.Extension[] */
  protected function extensions() {
    return [new Dates(null, [
      null       => self::FORMAT,
      'us:short' => 'Y-m-d',
    ])];
  }

  /** @return iterable */
  private function dates() {
    yield new Date('2021-02-13');
    yield '13.02.2021';
    yield 1613209181;
  }

  #[Test, Values('dates')]
  public function dates_with_format($date) {
    Assert::equals(
      '2021-02-13',
      $this->transform('{{date tested format="Y-m-d"}}', ['tested' => $date])
    );
  }

  #[Test, Values('dates')]
  public function dates_with_named_format($date) {
    Assert::equals(
      '2021-02-13',
      $this->transform('{{date tested format="us:short"}}', ['tested' => $date])
    );
  }

  #[Test, Values('dates')]
  public function dates_with_default_format($date) {
    Assert::equals(
      '13.02.2021',
      $this->transform('{{date tested}}', ['tested' => $date])
    );
  }

  #[Test, Values(['{{date}}', '{{date null}}'])]
  public function current_date($template) {
    Assert::equals(Date::now()->toString(self::FORMAT), $this->transform($template));
  }

  #[Test, Values(['{{date 1613235019279 timestamp="ms"}}', '{{date 1613235019 timestamp="s"}}'])]
  public function timestamp_resolution($template) {
    Assert::equals('13.02.2021', $this->transform($template));
  }
}