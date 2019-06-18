<?php

namespace TextParser\Loader;

use TextParser\Exception\JsonDecodeException;
use TextParser\Traits\FileLoader;
use TextParser\Exception\OpenFileException;

class JsonFileLoader extends JsonLoader
{
    use FileLoader;

    /**
     * Load a json from an unparsed string
     *
     * @throws JsonDecodeException
     * @throws OpenFileException
     * @param string $filePath
     * @return array
     */
    public function load(string $filePath): array
    {
        $content = $this->loadFile($filePath);

        return parent::load($content);
    }
}
