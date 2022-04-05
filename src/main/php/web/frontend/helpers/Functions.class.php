<?php namespace web\frontend\helpers;

/** Helper functions */
class Functions extends Extension {
  private $named;

  /**
   * Creates new functions extension
   *
   * @param  [:function(com.github.mustache.Node, com.github.mustache.Context, mixed[]): mixed] $named
   */
  public function __construct(array $named) {
    $this->named= $named;
  }

  /** @return iterable */
  public function helpers() {
    return $this->named;
  }
}