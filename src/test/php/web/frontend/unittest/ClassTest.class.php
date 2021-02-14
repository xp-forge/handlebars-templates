<?php namespace web\frontend\unittest;

use unittest\{Assert, Test};
use web\frontend\Handlebars;

class ClassTest extends HandlebarsTest {

  #[Test]
  public function can_create() {
    new Handlebars($this->templates);
  }

  #[Test]
  public function transformation_scope_accessible() {
    Assert::equals(
      '<h1>Hello @fixture!</h1>',
      $this->transform('<h1>Hello @{{scope}}!</h1>')
    );
  }

  #[Test]
  public function logging_echoes_content() {
    ob_start();
    $this->transform('{{log "User:" user}}', ['user' => ['id' => 'test']]);
    $logged= ob_get_clean();

    Assert::equals("  User: [\n    id => \"test\"\n  ] \n", $logged);
  }
}