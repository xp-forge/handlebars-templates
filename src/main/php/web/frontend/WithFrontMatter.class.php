<?php namespace web\frontend;

use com\github\mustache\Node;

class WithFrontMatter extends Node {
  private $nodes, $pairs;

  /**
   * Creates new frontmatter
   *
   * @param  com.handlebarsjs.Nodes $nodes
   * @param  [:var] $pairs
   */
  public function __construct($nodes, $pairs) {
    $this->nodes= $nodes;
    $this->pairs= (array)$pairs;
  }

  /**
   * Returns partial
   *
   * @param  string $name
   * @return ?com.github.mustache.NodeList
   */
  public function partial($name) {
    return $this->nodes->partial($name);
  }

  /**
   * Evaluates this node
   *
   * @param  com.github.mustache.Context $context the rendering context
   * @param  io.streams.OutputStream $out
   */
  public function write($context, $out) {
    $context->variables+= $this->pairs;
    $this->nodes->write($context, $out);
  }

  /** @return string */
  public function __toString() { return (string)$this->nodes; }
}