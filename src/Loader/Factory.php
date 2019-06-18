<?php

namespace TextParser\Loader;

use TextParser\Exception\UnsuporttedFormatException;
use TextParser\Exception\OpenFileException;
use TextParser\Loader\LoaderInterface;

final class Factory
{
    private $fileLoader = [
        "json" => "TextParser\Loader\JsonFileLoader",
        "php" => "TextParser\Loader\PhpFileLoader"
    ];

    private $stringLoader = [
        "json" => "TextParser\Loader\JsonLoader"
    ];

    public function registerFileLoader($key, LoaderInterface $loader)
    {
        $this->fileLoader[$key] = $loader;
    }

    public function registerStringLoader($key, LoaderInterface $loader)
    {
        $this->stringLoader[$key] = $loader;
    }

    /**
     * Create a Loader from a FilePath
     *
     * @param string $filePath
     * @return LoaderInterface
     */
    public function createFileLoaderFromFilePath(string $filePath): LoaderInterface
    {
        if (!is_file($filePath)) {
            throw new OpenFileException("The filepath supplied doesn't exists or isn't a file.");
        }

        $fileExt = explode(".", $filePath);
        $fileExt = end($fileExt);
        $availableFormats = array_keys($this->fileLoader);

        if (!in_array($fileExt, $availableFormats)) {
            throw new UnsuporttedFormatException(
                sprintf(
                    "The format %s isn't supported yet. Please, choose one of the follow to configure your files: %s",
                    $fileExt,
                    implode(', ', $availableFormats)
                )
            );
        }

        $LoaderCls = $this->fileLoader[$fileExt];

        return new $LoaderCls;
    }

    /**
     * Create a String Loader from a String
     *
     * @param string $format
     * @return LoaderInterface
     */
    public function createStringLoaderFromFormat(string $format): LoaderInterface
    {
        $availableFormats = array_keys($this->stringLoader);
        if (!in_array($format, $availableFormats)) {
            throw new UnsuporttedFormatException(
                sprintf(
                    "The format %s isn't supported yet. Please, choose one of the follow to configure your layout: %s",
                    $format,
                    implode(', ', $availableFormats)
                )
            );
        }

        $LoaderCls = $this->stringLoader($format);

        return new $LoaderCls;
    }
}
