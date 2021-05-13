<?php namespace web\frontend;

use com\handlebarsjs\HandlebarsParser;
use org\yaml\{YamlParser, StringInput};
use text\Tokenizer;

class TemplateParser extends HandlebarsParser {
  private static $yaml;

  public function parse(Tokenizer $tokens, $start= '{{', $end= '}}', $indent= '') {

    // Check presence of YFM
    $peek= $tokens->nextToken("\n");
    if ('---' === $peek) {
      $yaml= '';
      while ($tokens->hasMoreTokens()) {
        $line= $tokens->nextToken("\n");
        if ('---' === $line) break;
        $yaml.= $line."\n";
      }

      $nodes= parent::parse($tokens, $start, $end, $indent);
      $nodes->decorate(new FrontMatter((self::$yaml ?? self::$yaml= new YamlParser())->parse(new StringInput($yaml))));
      return $nodes;
    }

    // Just a regular template, delegate to parent
    $tokens->pushBack($peek);
    return parent::parse($tokens, $start, $end, $indent);
  }
}