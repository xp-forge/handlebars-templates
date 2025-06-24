<?php namespace web\frontend;

use com\github\mustache\templates\Templates;
use com\handlebarsjs\FilesIn;
use util\NoSuchElementException;

/**
 * Loads templates from a given path by default, supporting namespaced
 * templates (`namespace:name`) from a given map of namespaces and paths
 * or loaders.
 *
 * @test  web.frontend.unittest.TemplatesFromTest
 */
class TemplatesFrom extends Templates {
  private $default;
  private $namespaced= [];

  /**
   * Creates a new instance
   *
   * @param string|io.Path|io.Folder|parent $default
   * @param [:string|io.Path|io.Folder|parent] $namespaced
   */
  public function __construct($default, array $namespaced= []) {
    $this->default= $this->asTemplates($default);
    foreach ($namespaced as $ns => $t) {
      $this->namespaced[$ns]= $this->asTemplates($t);
    }
  }

  /**
   * Casts given argument to a `Templates` instance.
   *
   * @param  string|io.Path|io.Folder|parent $arg
   * @return parent
   */
  private function asTemplates($arg) {
    return $arg instanceof parent ? $arg : new FilesIn($arg);
  }

  /**
   * Load a template by a given name
   *
   * @param  string $name The template name, not including the file extension
   * @return com.github.mustache.templates.Input
   * @throws util.NoSuchElementException
   */
  public function source($name) {
    if (false === ($p= strpos($name, ':'))) return $this->default->source($name);

    $ns= substr($name, 0, $p);
    if ($t= ($this->namespaced[$ns] ?? null)) return $t->source(substr($name, $p + 1));

    throw new NoSuchElementException('Unknown namespace "'.$ns.'"');
  }

  /**
   * Returns available templates
   *
   * @return com.github.mustache.TemplateListing
   */
  public function listing() {
    return $this->default->listing(); // FIXME
  }
}