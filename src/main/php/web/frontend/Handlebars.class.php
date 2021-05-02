<?php namespace web\frontend;

use com\github\mustache\TemplateLoader;
use com\handlebarsjs\{HandlebarsEngine, FilesIn};
use util\Objects;
use web\frontend\helpers\{Extension, Essentials};

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
   * @param  web.frontend.helpers.Extension[] $extensions
   */
  public function __construct($templates, array $extensions= []) {
    $this->backing= (new HandlebarsEngine())
      ->withTemplates($templates instanceof TemplateLoader ? $templates : new FilesIn($templates))
      ->withLogger(function($args, $level= 'info') {
        echo '  ['.$level.'] ';
        foreach ($args as $arg) {
          echo is_string($arg) ? $arg : Objects::stringOf($arg, '  '), ' ';
        }
        echo "\n";
      })
    ;

    $this->using(new Essentials());
    foreach ($extensions as $extension) {
      $this->using($extension);
    }
  }

  /** Adds helpers from the given extension */
  public function using(Extension $extension): self {
    foreach ($extension->helpers() as $name => $function) {
      $this->backing->withHelper($name, $function);
    }
    return $this;
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