Handlebars for XP web frontends change log
==========================================

## ?.?.? / ????-??-??

## 0.7.0 / 2021-04-11

* Added `assets` helper which logs missing assets, implementing #6
  (@thekid)

## 0.6.0 / 2021-04-10

* Changed constructor argument *extensions* from vararg to array
  (@thekid)

## 0.5.2 / 2021-04-10

* Made compatible with `xp-forge/frontend` version 3.0 - @thekid

## 0.5.1 / 2021-02-14

* Fixed timezone handling in conjunction with `timestamp` parameter
  (@thekid)

## 0.5.0 / 2021-02-14

* Implemented basic timezone handling by passing default timezone to
  the `web.frontend.helpers.Dates` helpers extension, overwriteable by
  passing e.g. `timezone="America/New_York"` in the handlebars helper.
  (@thekid)
* Merged PR #4: Make template engine extensible; and extract the hard
  wired date formatting to its own extension
  (@thekid)

## 0.4.0 / 2021-02-14

* Merged PR #2: Logging. Using the development webserver, this will show
  the debug page - for production, the content will be written to the
  server's standard output.
  (@thekid)

## 0.3.0 / 2021-02-13

* Add support for milliseconds resolution in timestamps to `date` helper,
  thus being able to use JavaScript timestamps.
  (@thekid)

## 0.2.0 / 2021-02-13

* Add `any`, `none` and `all` helpers - @thekid
* Add `min` and `max` helpers - @thekid
* Add `contains` helper - @thekid

## 0.1.0 / 2021-02-13

* First public release - @thekid
