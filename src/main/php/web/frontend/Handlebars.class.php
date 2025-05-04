<?php namespace web\frontend;

use com\github\mustache\{Template, TemplateNotFoundException};
use com\handlebarsjs\{HandlebarsEngine, FilesIn};
use util\Objects;
use web\frontend\helpers\{Extension, Essentials};

/**
 * Handlebars-based template engine for web frontends.
 *
 * @test  web.frontend.unittest.ClassTest
 * @test  web.frontend.unittest.InlineTest
 * @see   https://handlebarsjs.com/
 */
class Handlebars implements Templates {
  private static $parser;
  private $backing;

  static function __static() {
    self::$parser= new TemplateParser();
  }

  /**
   * Creates a new handlebars-based template engine. Templates can be supplied as
   * either a reference to a filesystem path, or using an in-memory loader 
   *
   * @param  string|io.Path|io.Folder|com.github.mustache.TemplateLoader $templates 
   * @param  [:var][]|web.frontend.helpers.Extension[] $extensions
   */
  public function __construct($templates, array $extensions= []) {
    $this->backing= (new HandlebarsEngine(self::$parser))
      ->withTemplates($templates)
      ->withLogger(function($args, $level= 'info') {
        echo '  ['.$level.'] ';
        foreach ($args as $arg) {
          echo is_string($arg) ? $arg : Objects::stringOf($arg, '  '), ' ';
        }
        echo "\n";
      })
    ;

    $this->using(new Essentials());
    foreach ($extensions as $extension) {
      $this->using($extension);
    }
  }

  /**
   * Fetches a template
   *
   * @param  string $name
   * @param  ?string $fragment
   * @return com.github.mustache.Template
   * @throws com.github.mustache.TemplateNotFoundException
   */
  public function template($name, $fragment= null) {
    $template= $this->backing->load($name);
    if (null === $fragment) return $template;

    $parent= $template->root();
    if ($nodes= $parent->partial($fragment)) {
      return new Template($fragment, $nodes->inheriting($parent));
    }

    throw new TemplateNotFoundException('No such fragment "'.$fragment.'" in template "'.$name.'"');
  }

  /**
   * Adds helpers from the given extension
   *
   * @param  [:var]|web.frontend.helpers.Extension $extension
   */
  public function using($extension): self {
    $it= $extension instanceof Extension ? $extension->helpers() : $extension;
    foreach ($it as $name => $function) {
      $this->backing->withHelper($name, $function);
    }
    return $this;
  }

  /**
   * Transforms a named template and returns the result as a string.
   *
   * @param  string $name Template name
   * @param  [:var] $context
   * @return string
   */
  public function render($name, $context, $fragment= null) {
    return $this->backing->evaluate(
      $this->template($name, $fragment),
      $context + ['scope' => $name]
    );
  }

  /**
   * Transforms a named template, writing the result to a given output stream.
   *
   * @param  string $name Template name
   * @param  [:var] $context
   * @param  io.streams.OutputStream $out
   * @return io.streams.OutputStream
   */
  public function write($name, $context, $out, $fragment= null) {
    $this->backing->write(
      $this->template($name, $fragment),
      $context + ['scope' => $name],
      $out
    );
    return $out;
  }
}