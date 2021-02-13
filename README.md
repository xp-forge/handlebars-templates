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
* `date`: Transforms dates and timestamps
