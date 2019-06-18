<?php

namespace TextParser\Loader;

/**
 * Loader Interface
 */
interface LoaderInterface
{
    /**
     * @param string $content
     * @return array
     */
    public function load(string $content): array;
}
