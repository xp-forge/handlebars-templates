<?php namespace web\frontend\unittest;

use com\github\mustache\TemplateFormatException;
use test\{Assert, Expect, Test};

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
  public function matter_overwritable_by_context() {
    Assert::equals('Works', $this->transform("---\nit: Defaults\n---\n{{it}}", ['it' => 'Works']));
  }

  #[Test, Expect(class: TemplateFormatException::class, message: 'Unclosed YAML front matter')]
  public function unclosed_matter() {
    $this->transform("---\n");
  }

  #[Test]
  public function used_for_navigation_setup() {
    Assert::equals('[Home](/) | [About](/about) | [Login](/login)', $this->transform(
      "---\n".
      "nav:\n".
      "  /: Home\n".
      "  /about: About\n".
      "  /login: Login\n".
      "---\n".
      "{{#each nav}}[{{.}}]({{@key}}){{#unless @last}} | {{/unless}}{{/each}}",
      []
    ));
  }
}