<?php

namespace TextParser\Layout\Model;

final class Layout
{
    /**
     * Layout Items
     *
     * @var array <Item>
     */
    private $itens = [];

    /**
     * @return void
     */
    public function addItem(Item $item)
    {
        $this->itens[] = $item;
    }

    /**
     * Undocumented function
     *
     * @param array $itens
     * @return void
     */
    public function setItens(array $itens)
    {
        $this->itens = $itens;
    }

    /**
     * Return the ordened itens
     * 
     * @return array
     */
    public function getItens(): array
    {
        return $this->itens;
    }
}
