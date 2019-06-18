<?php

namespace TextParser\Loader;

use TextParser\Exception\JsonDecodeException;
use TextParser\Exception\OpenFileException;

class PhpFileLoader implements LoaderInterface
{
    /**
     * Load a config from an PHP file
     *
     * @throws JsonDecodeException
     * @throws OpenFileException
     * @param string $filePath
     * @return array
     */
    public function load(string $filePath): array
    {
        if (!is_file($filePath)) {
            throw new OpenFileException("The filePath $filePath provided doesn't exists.");
        }

        $content = include $filePath;

        if (!is_array($content)) {
            throw new OpenFileException("The $filePath must be returning an array.");
        }

        return $content;
    }
}
