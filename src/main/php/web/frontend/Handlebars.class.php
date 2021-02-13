<?php namespace web\frontend;

use com\github\mustache\TemplateLoader;
use com\handlebarsjs\{HandlebarsEngine, FilesIn};
use util\Date;

/**
 * Handlebars-based template engine for web frontends.
 *
 * @test  web.frontend.unittest.HandlebarsTest
 * @see   https://handlebarsjs.com/
 */
class Handlebars implements Templates {
  private $backing;

  /**
   * Creates a new handlebars-based template engine. Templates can be supplied as
   * either a reference to a filesystem path, or using an in-memory loader 
   *
   * @param  string|io.Path|io.Folder|com.github.mustache.TemplateLoader $templates 
   */
  public function __construct($templates) {
    $this->backing= (new HandlebarsEngine())
      ->withTemplates($templates instanceof TemplateLoader ? $templates : new FilesIn($templates))
      ->withHelper('encode', function($in, $context, $options) {
        return rawurlencode($options[0] ?? '');
      })
      ->withHelper('equals', function($in, $context, $options) {
        return (int)(($options[0] ?? null) === ($options[1] ?? null));
      })
      ->withHelper('contains', function($in, $context, $options) {
        if (!isset($options[0])) {
          return 0;
        } else if (is_array($options[0])) {
          return (int)in_array($options[1] ?? null, $options[0]);
        } else {
          return false === strpos($options[0], $options[1] ?? null) ? 0 : 1;
        }
      })
      ->withHelper('size', function($in, $context, $options) {
        if (!isset($options[0])) {
          return 0;
        } else if ($options[0] instanceof \Countable || is_array($options[0])) {
          return sizeof($options[0]);
        } else {
          return strlen($options[0]);
        }
      })
      ->withHelper('date', function($in, $context, $options) {
        if (!isset($options[0])) {
          $d= Date::now();
        } else if ($options[0] instanceof Date) {
          $d= $options[0];
        } else {
          $d= new Date($options[0]);
        }
        return $d->toString($options[1] ?? 'd.m.Y');
      })
    ;
  }

  /**
   * Transforms a named template
   *
   * @param  string $name Template name
   * @param  [:var] $context
   * @param  io.streams.OutputStream $out
   * @return void
   */
  public function write($name, $context, $out) {
    $this->backing->write($this->backing->load($name), $context + ['scope' => $name], $out);
  }
}