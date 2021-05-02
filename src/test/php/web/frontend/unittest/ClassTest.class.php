<?php namespace web\frontend\unittest;

use unittest\{Assert, Test};
use web\frontend\Handlebars;

class ClassTest extends HandlebarsTest {

  #[Test]
  public function can_create_with_loader() {
    new Handlebars($this->templates);
  }

  #[Test]
  public function can_create_with_path() {
    new Handlebars('src/main/handlebars');
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

    Assert::equals("  [info] User: [\n    id => \"test\"\n  ] \n", $logged);
  }

  #[Test]
  public function logging_can_use_loglevels() {
    ob_start();
    $this->transform('{{log "User:" user level="warn"}}', ['user' => ['id' => 'test']]);
    $logged= ob_get_clean();

    Assert::equals("  [warn] User: [\n    id => \"test\"\n  ] \n", $logged);
  }
}