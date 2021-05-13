<?php namespace web\frontend;

use com\handlebarsjs\Decoration;

class FrontMatter extends Decoration {

  /** @param [:var] $pairs */
  public function __construct($pairs) {
    parent::__construct('*yfm', []);
    $this->pairs= (array)$pairs;
  }

  /**
   * Evaluates this decoration
   *
   * @param  com.github.mustache.Context $context the rendering context
   * @return void
   */
  public function enter($context) {
    $context->variables+= $this->pairs;
  }
}