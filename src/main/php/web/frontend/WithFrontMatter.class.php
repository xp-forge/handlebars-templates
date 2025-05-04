<?php namespace web\frontend;

use com\handlebarsjs\Nodes;

class WithFrontMatter extends Nodes {
  private $parent, $pairs;

  /**
   * Creates new frontmatter
   *
   * @param  com.handlebarsjs.Nodes $parent
   * @param  [:var] $pairs
   */
  public function __construct(parent $parent, $pairs) {
    parent::__construct($parent->nodes);
    $this->parent= $parent;
    $this->pairs= (array)$pairs;
  }

  /**
   * Returns partial
   *
   * @param  string $name
   * @return ?com.github.mustache.NodeList
   */
  public function partial($name) {
    return $this->parent->partial($name);
  }

  /**
   * Evaluates this node
   *
   * @param  com.github.mustache.Context $context the rendering context
   * @param  io.streams.OutputStream $out
   */
  public function write($context, $out) {
    $context->variables+= $this->pairs;
    $this->parent->write($context, $out);
  }

  /** @return string */
  public function __toString() { return (string)$this->parent; }
}