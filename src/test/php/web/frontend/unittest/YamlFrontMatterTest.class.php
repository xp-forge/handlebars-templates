<?php namespace web\frontend\unittest;

use unittest\{Assert, Test};

class YamlFrontMatterTest extends HandlebarsTest {

  #[Test]
  public function no_matter() {
    Assert::equals('Works', $this->transform("{{it}}", ['it' => 'Works']));
  }

  #[Test]
  public function empty_matter() {
    Assert::equals('Works', $this->transform("---\n---\n{{it}}", ['it' => 'Works']));
  }

  #[Test]
  public function nav_array() {
    Assert::equals('Home | About | Login', $this->transform(
      "---\n".
      "nav:\n".
      "- Home\n".
      "- About\n".
      "- Login\n".
      "---\n".
      "{{#each nav}}{{.}}{{#unless @last}} | {{/unless}}{{/each}}",
      []
    ));
  }
}