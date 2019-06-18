<?php

namespace TextParser\Layout;

use TextParser\Layout\Model\Layout;
use TextParser\Layout\Loader;
use TextParser\Loader\Factory as LoaderFactory;

final class Factory
{
    /**
     * @var LoaderFactory
     */
    private $loaderFactory;

    /**
     * @param LoaderFactory|null $loaderFactory
     */
    public function __construct(LoaderFactory $loaderFactory = null)
    {
        $this->loaderFactory = $loaderFactory ? $loaderFactory : new LoaderFactory;
    }

    /**
     * Create a Layout from a FilePath
     *
     * @param string $filePath
     * @param array $aliases
     * @return Layout
     */
    public function createFromFilePath(string $filePath, array $aliases = []): Layout
    {
        $fileLoader = $this->loaderFactory->createFileLoaderFromFilePath($filePath);

        $LayoutLoader = new Loader($fileLoader, $aliases);

        return $LayoutLoader->loadLayout($filePath);
    }

    /**
     * Create a Layout from a String
     *
     * @param string $content
     * @param string $format
     * @param string $aliases
     * @return Layout
     */
    public function createFromString(string $content, string $format, array $aliases = []): Layout
    {
        $stringLoader = $this->loaderFactory->createStringLoaderFromFormat($format);

        $LayoutLoader = new Loader($stringLoader, $aliases);

        return $LayoutLoader->loadLayout($content);
    }
}
