<?php

namespace TextParser\Template;

use TextParser\Template\Loader;
use TextParser\Template\Model\Template;
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
     * Create a Template from a FilePath
     *
     * @param string $filePath
     * @param array $aliases
     * @return Template
     */
    public function createFromFilePath(string $filePath, array $aliases = []): Template
    {
        $fileLoader = $this->loaderFactory->createFileLoaderFromFilePath($filePath);

        $TemplateLoader = new Loader($fileLoader, $aliases);

        return $TemplateLoader->loadTemplate($filePath);
    }

    /**
     * Create a Template from a String
     *
     * @param string $content
     * @param string $format
     * @param string $aliases
     * @return Template
     */
    public function createFromString(string $content, string $format, array $aliases = []): Template
    {
        $stringLoader = $this->loaderFactory->createStringLoaderFromFormat($format);

        $TemplateLoader = new Loader($stringLoader, $aliases);

        return $TemplateLoader->loadTemplate($content);
    }
}
