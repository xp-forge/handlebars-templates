<?php namespace web\frontend\unittest;

use test\{Assert, Test, Values};
use util\{Date, TimeZone};
use web\frontend\helpers\Dates;

class DatesTest extends HandlebarsTest {
  const FORMAT = 'd.m.Y';
  const TZ     = 'Australia/Sydney';

  /** @return web.frontend.Extension[] */
  protected function extensions() {
    return [new Dates(new TimeZone(self::TZ), [
      ''         => self::FORMAT,
      'us:short' => 'm/d/Y',
    ])];
  }

  /** @return iterable */
  private function dates() {
    yield new Date('2021-02-13 22:30:00', new TimeZone(self::TZ));
    yield new Date('13.02.2021 12:30:00+01:00');
    yield '2021-02-13T11:30:00Z';
    yield 1613215800;
  }

  /** @return iterable */
  private function durations() {
    yield ['0', '00:00:00'];
    yield ['3599', '00:59:59'];
    yield ['3600', '01:00:00'];
    yield ['4500', '01:15:00'];
    yield ['4509', '01:15:09'];
    yield ['-10', '00:00:10'];

    // Format characters %H %M %S (lowercase without leading zeroes)
    yield ['4509 format="%h:%m"', '1:15'];
    yield ['4509 format="%h:%m:%s"', '1:15:9'];
    yield ['4509 format="%H:%M:%S"', '01:15:09'];
    yield ['90000 format="%H:%M"', '25:00'];

    // Format for durations with hours
    yield ['3599 format="%M:%S" hours="%h:%M:%S"', '59:59'];
    yield ['3709 format="%M:%S" hours="%h:%M:%S"', '1:01:49'];

    // Timestamp is either s (seconds) or ms (millisecconds)
    yield ['4508 timestamp="s"', '01:15:08'];
    yield ['4508.192 timestamp="s"', '01:15:08'];
    yield ['4508192 timestamp="ms"', '01:15:08'];
  }

  #[Test, Values(from: 'dates')]
  public function dates_with_format($date) {
    Assert::equals(
      '2021-02-13',
      $this->transform('{{date tested format="Y-m-d"}}', ['tested' => $date])
    );
  }

  #[Test, Values(from: 'dates')]
  public function dates_with_named_format($date) {
    Assert::equals(
      '02/13/2021',
      $this->transform('{{date tested format="us:short"}}', ['tested' => $date])
    );
  }

  #[Test, Values(from: 'dates')]
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

  #[Test, Values(['{{date 1613215800279 timestamp="ms"}}', '{{date 1613215800 timestamp="s"}}'])]
  public function timestamp_resolution($template) {
    Assert::equals('13.02.2021', $this->transform($template));
  }

  #[Test, Values(from: 'dates')]
  public function converted_to_default_timezone($date) {
    Assert::equals(
      '13.02.2021 22:30:00',
      $this->transform('{{date tested format="d.m.Y H:i:s"}}', ['tested' => $date])
    );
  }

  #[Test, Values(from: 'dates')]
  public function converted_to_supplied_timezone($date) {
    Assert::equals(
      '13.02.2021 06:30:00',
      $this->transform('{{date tested format="d.m.Y H:i:s" timezone="America/New_York"}}', ['tested' => $date])
    );
  }

  #[Test, Values(from: 'durations')]
  public function duration($options, $expected) {
    Assert::equals($expected, $this->transform("{{duration {$options}}}"));
  }
}