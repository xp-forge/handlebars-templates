Handlebars for XP web frontends change log
==========================================

## ?.?.? / ????-??-??

## 2.0.0 / 2022-10-08

* Upgrade to `xp-forge/handlebars` version 8.0.0 - @thekid

## 1.2.0 / 2022-09-18

* Merged PR #10: Allow passing maps to extensions - @thekid

## 1.1.0 / 2022-04-05

* Merged PR #9: Add helper functions extension - @thekid

## 1.0.2 / 2022-02-27

* Fixed "Creation of dynamic property" warnings in PHP 8.2 - @thekid

## 1.0.1 / 2021-10-21

* Made library compatible with XP 11, `xp-forge/handlebars` version
  7.0.0
  (@thekid)

## 1.0.0 / 2021-07-17

* Merged PR #5 - Add `web.frontend.helpers.Numbers` to format numbers
  and percentages. Provides *number*, *percent* and *count* helpers.
  (@thekid)

## 0.9.0 / 2021-05-13

* Merged PR #8 - Support YAML front matter. Implements feature present
  in a broad variety of frontend templating systems, inlcuding Jekyll,
  Hugo and NuxtJS
  (@thekid)

## 0.8.0 / 2021-05-02

* Added compatibility with `xp-forge/handlebars` version 6.0:
  - Single quotes are now escaped as `&#039;`
  - Log levels supplied via `level="..."` are now shown
  - Missing assets use log level *error*
  - Now supports block params, e.g. `#{{with ... as |alias|}}`
  - Now supports `else if` syntactic sugar
  (@thekid)

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
