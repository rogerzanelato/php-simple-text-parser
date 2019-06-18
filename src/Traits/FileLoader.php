<?php

namespace TextParser\Traits;

trait FileLoader
{
    /**
     * If the string passed as parameter is a file, then, we'll try to load
     * and return it
     * If it isn't a file or we can't load it we are going to throw an exception
     *
     * @param string $filePath
     * @throws OpenFileException
     * @return string
     */
    public function loadFile(string $filePath): string
    {
        if (is_file($filePath)) {
            $content = @file_get_contents($filePath);

            if ($content === false) {
                throw new OpenFileException("The file exists but we couldn't load it in memory.");
            }

            return $content;
        }

        throw new OpenFileException("The file exists but we couldn't load it in memory.");
    }
}
