<?php namespace web\frontend;

use com\github\mustache\templates\Templates;
use util\NoSuchElementException;

/**
 * Adds support for loading namespaced templates (`namespace:name`) from
 * a given map of namespaces and template loaders.
 *
 * @test  web.frontend.unittest.TemplatesFromTest
 */
class TemplatesFrom extends Templates {
  private $default, $namespaced;

  /**
   * Creates a new instance
   *
   * @param parent $default
   * @param [:parent] $namespaced
   */
  public function __construct(parent $default, array $namespaced= []) {
    $this->default= $default;
    $this->namespaced= $namespaced;
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