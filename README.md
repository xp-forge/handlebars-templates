Handlebars for XP web frontends
===============================

[![Build status on GitHub](https://github.com/xp-forge/handlebars-templates/workflows/Tests/badge.svg)](https://github.com/xp-forge/handlebars-templates/actions)
[![XP Framework Module](https://raw.githubusercontent.com/xp-framework/web/master/static/xp-framework-badge.png)](https://github.com/xp-framework/core)
[![BSD Licence](https://raw.githubusercontent.com/xp-framework/web/master/static/licence-bsd.png)](https://github.com/xp-framework/core/blob/master/LICENCE.md)
[![Requires PHP 7.0+](https://raw.githubusercontent.com/xp-framework/web/master/static/php-7_0plus.svg)](http://php.net/)
[![Supports PHP 8.0+](https://raw.githubusercontent.com/xp-framework/web/master/static/php-8_0plus.svg)](http://php.net/)
[![Latest Stable Version](https://poser.pugx.org/xp-forge/handlebars-templates/version.png)](https://packagist.org/packages/xp-forge/handlebars-templates)

Handlebars template engine implementation to be used in conjunction with [XP web frontends](https://github.com/xp-forge/frontend).

Example
-------
Wiring happens inside your web application:

```php
use web\frontend\{Frontend, HandlersIn, Handlebars};
use web\handler\FilesFrom;
use web\Application;
use io\Path;

class App extends Application {

  /** Returns routing for this web application */
  public function routes() {
    return [
      '/static' => new FilesFrom($this->environment->path('src/main/webapp')),
      '/'       => new Frontend(
        new HandlersIn('com.example.app.web'),
        new Handlebars($this->environment->path('src/main/handlebars')),
        '/'
      )
    ];
  }
}
```

The templates live in `src/main/handlebars`, their names corresponding to lowercased version of the handlers' names (`Home::class` => `home.handlebars`).

Helpers
-------
On top of the [built-in functionality in Handlebars](https://github.com/xp-forge/handlebars), this library includes the following essential helpers:

* `encode`: Performs URL-encoding 
* `equals`: Tests arguments for equality
* `contains`: Tests whether a string or array contains a certain value
* `size`: Returns string length or array size
* `min`: Returns smallest element
* `max`: Returns largest element
* `any`: Test whether any of the given arguments is truthy
* `none`: Test whether none of the given arguments is truthy
* `all`: Test whether all of the given arguments is truthy
* `date`: Transforms dates and timestamps

### Date handling

The `date` helper accepts anything the `util.Date` class accepts as constructor argument, or a `util.Date` instance itself. To format the date, the `format` argument can be used with anything the `util.Date::toString()` method accepts. Here are some examples:

```handlebars
{{date "2021-02-13"}}
{{date "13.02.2021 17:56:00"}}
{{date 1613209181}}
{{date 1613209181279 timestamp="ms"}}
{{date created}}
{{date created format="d.m.Y"}}
```

### Logging

The `log` helper will echo the arguments passed to it:

```handlebars
{{log user}}
{{log "User profile:" user}}
```

When using the development webserver, this shows the debug page:

![Debug page](https://user-images.githubusercontent.com/696742/107873960-89cdc800-6eb6-11eb-954b-8b00324cce74.png)

In production environments, logs will end up on the server's standard output:

![Console outpit](https://user-images.githubusercontent.com/696742/107874105-838c1b80-6eb7-11eb-8c7e-ee257ef1d92d.png)
