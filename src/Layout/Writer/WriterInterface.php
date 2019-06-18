<?php

namespace TextParser\Layout\Writer;

interface WriterInterface
{
    /**
     * @param array $values
     * @param array <Item> $itens
     * @return void
     */
    public function write(array $values, array $itens);
}
