<?php namespace web\frontend\helpers;

use web\frontend\AssetsManifest;

/** Fingerprinted assets */
class Assets extends Extension {
  private $manifest;

  /** Creates a new assets extension from a given assets manifest */
  public function __construct(AssetsManifest $manifest) {
    $this->manifest= $manifest;
  }

  /** @return iterable */
  public function helpers() {
    yield 'asset' => function($in, $context, $options) {
      $name= (string)$options[0];

      // We can rely on a logger being present, web.frontend.Handlebars creates one
      return $this->manifest->assets[$name] ?? key([$name => $context->engine->helper('log')(
        $in,
        $context,
        ['Missing asset in `'.(string)$in.'`, manifest contains: ', $this->manifest->assets]
      )]);
    };
  }
}
