Handlebars for XP web frontends change log
==========================================

## ?.?.? / ????-??-??

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
