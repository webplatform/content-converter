<?php

/**
 * WebPlatform Content Converter.
 */
namespace WebPlatform\ContentConverter\Filter;

use Exception;
use RuntimeException;

/**
 * Abstract Filter.
 *
 * A set of filtering rules to apply.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
abstract class AbstractFilter
{
    /** @var array of ordered Regular Expressions to use as matchers */
    protected $patterns = array();

    /** @var array of ordered Strings as replaement string to patterns  */
    protected $replacements = array();

    /**
     * Apply filters configured for this instance.
     *
     * @param string $input The input text content
     *
     * @return string The filtered text content
     */
    public function filter($input)
    {
        if (count($this->patterns) < 1) {
            throw new Exception('No passes are configured for this filter');
        }
        for ($pass = 0; $pass < count($this->patterns); ++$pass) {
            $content = preg_replace($this->patterns[$pass], $this->replacements[$pass], $input);
        }

        return $content;
    }

    public function addPass($pattern, $replacement)
    {
        if (!is_array($pattern) || !is_array($replacement)) {
            throw new Exception('Must be two arrays of matching size');
        }

        $patternCount = count($pattern);
        $replacementCount = count($replacement);
        if ($patternCount !== $replacementCount) {
            $message = 'The number of pattern matchers (%d) isn’t equal to the number of replacements (%d)!';
            throw new RuntimeException(sprintf($message, $patternCount, $replacementCount));
        }

        $this->patterns[] = $pattern;
        $this->replacements[] = $replacement;

        return $this;
    }
}
