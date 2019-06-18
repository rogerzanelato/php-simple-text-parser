<?php

namespace TextParser\Layout\Reader;

use TextParser\Layout\Reader\ReaderInterface;
use TextParser\Layout\Model\LayoutItem;

class ReadIntoArray implements ReaderInterface
{
    /**
     * @param string $value
     * @param array $itens
     * @return array
     */
    public function read(string $value, array $itens)
    {
        return array_reduce($itens, function ($carry, LayoutItem $item) use ($value) {
            $decoder = $item->getDecoder();
            $extractedValue = substr($value, $item->getStart(), $item->getLength());
            $carry[$item->getName()] = $decoder ? $decoder->format($extractedValue, $item->getLength()) : $extractedValue;

            return $carry;
        }, []);
    }
}
