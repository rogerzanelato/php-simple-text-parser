<?php

namespace TextParser\Layout\Reader;

interface ReaderInterface
{
    /**
     * @param string $value
     * @param array <Item> $itens
     * @return void
     */
    public function read(string $value, array $itens);
}
