<?php namespace web\frontend\unittest;

use test\{Assert, Test, Values};
use web\frontend\AssetsManifest;
use web\frontend\helpers\Assets;

class AssetsTest extends HandlebarsTest {

  /** @return web.frontend.Extension[] */
  protected function extensions() {
    return [new Assets(['vendor.css' => 'vendor.4d33b13.css'])];
  }

  #[Test]
  public function asset_replaced() {
    Assert::equals('vendor.4d33b13.css', $this->transform('{{asset "vendor.css"}}'));
  }

  #[Test]
  public function non_existant_asset_replaced() {
    ob_start();
    $result= $this->transform('{{asset "nonexistant.css"}}');
    ob_end_clean();

    Assert::equals('nonexistant.css', $result);
  }

  #[Test]
  public function non_existant_asset_logs_error() {
    ob_start();
    $this->transform('{{asset "nonexistant.css"}}');
    $log= ob_get_clean();

    Assert::equals('[error] Missing asset in `{{asset "nonexistant.css"}}`', trim(strstr($log, ',', true)));
  }
}