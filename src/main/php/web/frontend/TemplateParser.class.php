<?php namespace web\frontend;

use com\github\mustache\TemplateFormatException;
use com\handlebarsjs\{HandlebarsParser, BlockNode, Quoted, PartialBlockHelper};
use org\yaml\{YamlParser, StringInput};
use text\Tokenizer;

/**
 * Handlebars templates parser including support for YAML front matter
 *
 * @see  https://github.com/xp-forge/handlebars-templates/pull/8
 * @test web.frontend.unittest.YamlFrontMatterTest
 */
class TemplateParser extends HandlebarsParser {
  private static $yaml;

  /**
   * Initialize this parser, adding support for fragments.
   *
   * @return void
   */
  protected function initialize() {
    parent::initialize();
    $this->blocks->register('*fragment', function($options, $state) {
      $name= $options[0] instanceof Quoted ? $options[0]->chars : $options[0];
      $state->target->add(new PartialBlockHelper([$name]));
      return new BlockNode('fragment', [], $state->parents[0]->declare($name));
    });
  }

  /**
   * Parse a template
   *
   * @param  text.Tokenizer $tokens
   * @param  string $start Initial start tag, defaults to "{{"
   * @param  string $end Initial end tag, defaults to "}}"
   * @param  string $indent What to prefix before each line
   * @return com.github.mustache.Node The parsed template
   * @throws com.github.mustache.TemplateFormatException
   */
  public function parse(Tokenizer $tokens, $start= '{{', $end= '}}', $indent= '') {
    $tokens->returnDelims= true;

    // Check presence of YFM
    $peek= $tokens->nextToken("\n");
    if ('---' === $peek) {
      $yaml= '';
      while ($more= $tokens->hasMoreTokens()) {
        $t= $tokens->nextToken("\n");
        if ('---' === $t) break;
        $yaml.= $t;
      }

      if (!$more) {
        throw new TemplateFormatException('Unclosed YAML front matter');
      }

      $tokens->nextToken("\n");
      return new WithFrontMatter(
        parent::parse($tokens, $start, $end, $indent),
        (self::$yaml ?? self::$yaml= new YamlParser())->parse(new StringInput($yaml))
      );
    }

    // Just a regular template, delegate to parent
    $tokens->pushBack($peek);
    return parent::parse($tokens, $start, $end, $indent);
  }
}