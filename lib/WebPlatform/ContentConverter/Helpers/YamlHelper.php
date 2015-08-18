<?php

/**
 * WebPlatform Content Converter.
 */
namespace WebPlatform\ContentConverter\Helpers;

/**
 * Help read and write YAML in PHP.
 *
 * Loads Symfony component ONLY WHEN local PHP
 * runtime doesn’t have the extension active.
 *
 * Expose a YAML <> PHP Array serializer and unserializer.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class YamlHelper
{
    protected $isSupported = false;

    /** @var Symfony\Component\Yaml\Parser Yaml parser instance */
    protected $reader;

    /** @var Symfony\Component\Yaml\Dumper Yaml writer instance */
    protected $writer;

    public function __construct()
    {
        if (function_exists('yaml_emit') === true) {
            $this->isSupported = true;
        }

        return $this;
    }

    /**
     * Creates a YAML string out of a PHP array
     *
     * @param Array $array An array to serialize
     *
     * @return String The resulting YAML representation
     */
    public function serialize($array)
    {
        if ($this->isSupported === true) {
            return yaml_emit($array, YAML_UTF8_ENCODING);
        }

        if (!($this->writer instanceof Symfony\Component\Yaml\Dumper)) {
            $this->writer = new Symfony\Component\Yaml\Dumper();
            $this->writer->setIndentation(2);
        }

        return $this->writer->dump($array, 3, 0, false, false);
    }

    /**
     * Creates a PHP array based on a YAML string.
     *
     * @param String $string A string to convert into an array
     *
     * @return Array
     */
    public function unserialize($string)
    {
        if ($this->isSupported === true) {
            return yaml_parse($string);
        }

        if (!($this->reader instanceof Yaml\Parser)) {
            $this->reader = new Symfony\Component\Yaml\Parser();
        }

        return $this->reader->parse($string);
    }

}
