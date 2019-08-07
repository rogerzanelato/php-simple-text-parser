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
     * @param string $basePathLayout
     * @return Template
     */
    public function createFromFilePath(string $filePath, array $aliases = [], string $basePathLayout = null): Template
    {
        $fileLoader = $this->loaderFactory->createFileLoaderFromFilePath($filePath);

        // If a layout's path is not supplied, we consider that the layout is on a path relative to the template
        $basePathLayout = $basePathLayout ?? dirname($filePath) . DIRECTORY_SEPARATOR;
        
        $TemplateLoader = new Loader($fileLoader, $aliases, $basePathLayout);

        return $TemplateLoader->loadTemplate($filePath);
    }
    /**
     * Create a Template from a String
     *
     * @param string $content
     * @param string $format
     * @param string $aliases
     * @param string $basePathLayout
     * @return Template
     */
    public function createFromString(string $content, string $format, array $aliases = [], string $basePathLayout = null): Template
    {
        $stringLoader = $this->loaderFactory->createStringLoaderFromFormat($format);

        $TemplateLoader = new Loader($stringLoader, $aliases, $basePathLayout);

        return $TemplateLoader->loadTemplate($content);
    }
}
