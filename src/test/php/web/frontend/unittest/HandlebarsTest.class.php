<?php namespace web\frontend\unittest;

use com\github\mustache\InMemory;
use io\streams\MemoryOutputStream;
use web\frontend\Handlebars;

abstract class HandlebarsTest {
  protected $templates;

  /** Initialize test fixtures */
  public function __construct() {
    $this->templates= new InMemory();
  }

  /** @return web.frontend.Extension[] */
  protected function extensions() { return []; }

  /**
   * Transforms a template and returns the result. Uses a scope (or
   * template name) of "fixture".
   *
   * @param  string $template
   * @param  [:var] $context
   * @return string
   */
  protected function transform($template, $context= []) {
    $out= new MemoryOutputStream();
    $fixture= new Handlebars($this->templates->add('fixture', $template), $this->extensions());
    $fixture->write('fixture', $context, $out);
    return $out->bytes();
  }
}