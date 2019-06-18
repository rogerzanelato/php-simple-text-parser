<?php

namespace TextParser\Layout\Writer;

use TextParser\Layout\Model\LayoutItem;

class WriteIntoString implements WriterInterface
{
    /**
     * @param array $values
     * @param array <Item> $itens
     * @return void
     */
    public function write(array $values, array $itens)
    {
        return array_reduce($itens, function ($carry, LayoutItem $item) use ($values) {
            $key = $item->getName();
            if (array_key_exists($key, $values)) {
                $value = $values[$key];
                $encoder = $item->getEncoder();
                $carry .= $encoder ? $encoder->format($value, $item->getLength()) : $value;
            }

            return $carry;
        }, '');
    }
}
