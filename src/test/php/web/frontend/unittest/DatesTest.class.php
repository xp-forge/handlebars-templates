<?php namespace web\frontend\unittest;

use unittest\{Assert, Test, Values};
use util\{Date, TimeZone};
use web\frontend\helpers\Dates;

class DatesTest extends HandlebarsTest {
  const FORMAT = 'd.m.Y';
  const TZ     = 'Australia/Sydney';

  /** @return web.frontend.Extension[] */
  protected function extensions() {
    return [new Dates(new TimeZone(self::TZ), [
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
    Assert::equals(Date::now(new TimeZone(self::TZ))->toString(self::FORMAT), $this->transform($template));
  }

  #[Test, Values(['{{date 1613235019279 timestamp="ms"}}', '{{date 1613235019 timestamp="s"}}'])]
  public function timestamp_resolution($template) {
    Assert::equals('13.02.2021', $this->transform($template));
  }

  #[Test, Values(eval: '[new Date("13.02.2021 11:30:00", new TimeZone("UTC")), "13.02.2021 11:30:00 UTC", 1613215800]')]
  public function converted_to_supplied_timezone($date) {
    Assert::equals(
      '13.02.2021 22:30:00',
      $this->transform('{{date tested format="d.m.Y H:i:s"}}', ['tested' => $date])
    );
  }
}