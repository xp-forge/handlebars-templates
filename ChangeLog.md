Handlebars for XP web frontends change log
==========================================

## ?.?.? / ????-??-??

* **Heads up:** Dropped support for PHP < 7.4, see xp-framework/rfc#343
  (@thekid)
* Added PHP 8.5 to test matrix - @thekid
* Refactored template loading to no longer use deprecated functionality
  from the `xp-forge/mustache` library, making it compatible with its
  newest major release
  (@thekid)

## 3.5.1 / 2024-04-12

* Fixed issue #21: WithFrontMatter incompatible with `Nodes::inheriting()`
  (@thekid)

## 3.5.0 / 2024-03-24

* Made compatible with XP 12 - @thekid

## 3.4.0 / 2024-02-04

* Made compatible with https://github.com/xp-forge/yaml 7.0 and 8.0
  (@thekid)

## 3.3.0 / 2024-01-14

* Merged PR #20: Add support for fragment parameters - @thekid

## 3.2.0 / 2023-12-25

* Made compatible with https://github.com/xp-forge/frontend version 6.0
  (@thekid)

## 3.1.0 / 2023-10-29

* Merged PR #19: Support nested fragments - @thekid
* Added PHP 8.4 to test matrix - @thekid

## 3.0.0 / 2023-07-29

* **Heads up:** Dropped compatibility with `xp-forge/handlebars` versions
  lower than 9.1.0
  (@thekid)
* Merged PR #15: Implement fragments, which can thought of as "instantly-
  invoked inline partials".
  (@thekid)
* Merged PR #14: Make it possible to pass fragments to the `render()` and
  `write()` methods. This will select an inline partial and render that
  instead of the whole template.
  (@thekid)

## 2.5.0 / 2023-07-23

* Made this library compatible with `xp-forge/handlebars` version 9.0,
  see https://github.com/xp-forge/handlebars/pull/27
  (@thekid)
* Merged PR #13: Refactor frontmatter to no longer use decorations API
  (@thekid)

## 2.4.0 / 2023-07-22

* Fixed PHP 8.3 compatibility in `number` helper. This is due to the
  change how negative decimals were handled in *number_format()*. Before,
  they were simply ignored (*which is what we relied on*), now they're
  used for rounding, see https://github.com/php/php-src/pull/11487
  (@thekid)
* Added forward compatibility with `xp-forge/frontend` version 5.0, see
  https://github.com/xp-forge/frontend/pull/37
  (@thekid)

## 2.3.0 / 2023-03-18

* Merged PR #12: Add render() method which returns the result as a string
  (@thekid)
* Merged PR #11: Migrate to new testing library - @thekid

## 2.2.0 / 2022-11-13

* Cast input argument to integer in `count` helper - @thekid

## 2.1.0 / 2022-10-29

* Made compatible with `xp-forge/frontend` version 4.0.0 - @thekid

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
