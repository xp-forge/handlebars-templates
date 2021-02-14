<?php namespace web\frontend\helpers;

/** Base class for all extensions */
abstract class Extension {

  /** @return iterable */
  public abstract function helpers();
}