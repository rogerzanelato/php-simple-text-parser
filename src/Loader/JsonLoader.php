<?php

namespace TextParser\Loader;

use TextParser\Exception\JsonDecodeException;

class JsonLoader implements LoaderInterface
{
    /**
     * Load a json from an unparsed string
     *
     * @throws JsonDecodeException
     * @param string $content
     * @return array
     */
    public function load(string $content): array
    {
        $decodedContent = @json_decode($content, true);

        if ($decodedContent === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new JsonDecodeException(json_last_error_msg());
        }

        return $decodedContent;
    }
}
