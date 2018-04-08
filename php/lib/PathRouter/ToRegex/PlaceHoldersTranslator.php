<?php

namespace pedroac\routing\PathRouter\ToRegex;
use pedroac\routing\PathRouter\CanToRegex;

/**
 * Pattern with place holders to regex translator.
 * 
 * @author Pedro Amaral Couto
 * @license MIT
 */
class PlaceHoldersTranslator implements CanToRegex
{
    /**
     * Regex taht should be used to find tokens and replace them.
     *
     * @var string
     */
    private $regex;

    /**
     * Create a pattern with place holders to regex translator.
     *
     * The place holders should start and end with the specified or default delimiters
     * and have a name between them.
     * For example, assuming "<" and ">" are the open and close delimiters (default):
     * "<user_id>".
     * 
     * When the pattern is translated to regex, the place holders should be replaced 
     * with a regex sub-pattern that should match any character until the character next
     * to the place holder is found.
     * For example , the pattern "<user_id>/" should be replaced with something like:
     * "~^(P<user_id>[^/])/$~", ie: match all charactes until "/" is found.
     * 
     * The close delimiter is an empty string, "/" and end of of line, or pattern, should
     * behave as close separators.
     * The open delimiter should not be an empty string.
     * 
     * @param string $openDelimiter The open delimiter.
     * @param string $closeDelimiter The close delimiter.
     */
    public function __construct(
        string $openDelimiter = '<',
        string $closeDelimiter = '>'
    ) {
        $open = preg_quote($openDelimiter, '~');
        $close = preg_quote($closeDelimiter, '~');
        $notPlaceHolderRegex = "([^$open]*)";
        $placeHolderRegex = "($open([^$close]*)$close(.?))?";
        if (isset($openDelimiter[1])) {
            $notPlaceHolderRegex = "(.?(?=$open+))";
        }
        if (!isset($closeDelimiter[0])) {
            $placeHolderRegex = "($open([^/]*)(/?))?";
        } elseif (isset($closeDelimiter[1])) {
            $placeHolderRegex = "($open(.*?)$close(.?))?";
        }
        $this->regex = '~' . $notPlaceHolderRegex . $placeHolderRegex . '~';
    }

    /**
     * {@inheritdoc}
     * 
     * The place holders should be replaced with regex sub-patterns that match 
     * all characters except any character until the character next to the place holder 
     * is found.
     * 
     * Those regex sub-patterns should be named capturing groups. The names should be
     * the same names of the replaced placed holder, ie: the string between the
     * place holders delimiters.
     */
    public function toRegex(string $pattern): string
    {
        return
            '~^'
            . preg_replace_callback(
                $this->regex,
                function ($matches) {
                    if (!isset($matches[2][0])) {
                        return preg_quote($matches[1], '~');
                    }
                    $quotedLastMatch = preg_quote($matches[4]);
                    return
                        preg_quote($matches[1], '~')
                        . '(?P<' . preg_quote($matches[3], '~') . '>'
                        . (
                            isset($quotedLastMatch[0])
                                ? '[^' . $quotedLastMatch . ']*'
                                : '.*'
                          )
                        . ')'
                        . $quotedLastMatch;
                },
                $pattern
            )
            . '$~';
    }
}