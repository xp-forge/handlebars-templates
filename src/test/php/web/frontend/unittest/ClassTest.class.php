<?php namespace web\frontend\unittest;

use io\streams\MemoryOutputStream;
use test\{Assert, Test};
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
  public function render() {
    $fixture= new Handlebars($this->templates->add('fixture', '<h1>Hello @{{user}}!</h1>'));
    Assert::equals(
      '<h1>Hello @test!</h1>',
      $fixture->render('fixture', ['user' => 'test'])
    );
  }

  #[Test]
  public function render_fragment() {
    $fixture= new Handlebars($this->templates->add('fixture', 'Before {{#*fragment "user"}}@{{user}}{{/fragment}} After'));
    Assert::equals(
      '@test',
      $fixture->render('fixture', ['user' => 'test'], 'user')
    );
  }

  #[Test]
  public function access_frontmatter() {
    $frontmatter= "---\nuser: default\n---\n";
    $fixture= new Handlebars($this->templates->add('fixture', $frontmatter.'<h1>Hello @{{user}}!</h1>'));
    Assert::equals(
      '<h1>Hello @default!</h1>',
      $fixture->render('fixture', [])
    );
  }

  #[Test]
  public function access_frontmatter_from_fragment() {
    $frontmatter= "---\nuser: default\n---\n";
    $fixture= new Handlebars($this->templates->add('fixture', $frontmatter.'[{{#*fragment "user"}}@{{user}}{{/fragment}}]'));
    Assert::equals(
      '[@default]',
      $fixture->render('fixture', [])
    );
  }

  #[Test]
  public function write() {
    $fixture= new Handlebars($this->templates->add('fixture', '<h1>Hello @{{user}}!</h1>'));
    Assert::equals(
      '<h1>Hello @test!</h1>',
      $fixture->write('fixture', ['user' => 'test'], new MemoryOutputStream())->bytes()
    );
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
    $this->transform('{{log "User:" user}}', ['user' => ['id' => 0, 'name' => 'Test']]);
    $logged= ob_get_clean();

    Assert::equals("  [info] User: [\n    id => 0\n    name => \"Test\"\n  ] \n", $logged);
  }

  #[Test]
  public function logging_can_use_loglevels() {
    ob_start();
    $this->transform('{{log "User:" user level="warn"}}', ['user' => ['id' => 0, 'name' => 'Test']]);
    $logged= ob_get_clean();

    Assert::equals("  [warn] User: [\n    id => 0\n    name => \"Test\"\n  ] \n", $logged);
  }
}