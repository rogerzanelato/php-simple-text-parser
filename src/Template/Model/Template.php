<?php

namespace TextParser\Template\Model;

final class Template
{
    /**
     * Template Itens
     *
     * @var array <TemplateItem>
     */
    private $itens = [];

    /**
     * @var callable
     */
    private $identifier;

    /**
     * @var callable|string
     */
    private $delimiter;

    /**
     * @return void
     */
    public function addItem(TemplateItem $item)
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

    /**
     * Get the value of identifier
     *
     * @return  mixed
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set the value of identifier
     *
     * @param  mixed  $identifier
     *
     * @return  self
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get the value of delimiter
     *
     * @return  mixed
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * Set the value of delimiter
     *
     * @param  mixed  $delimiter
     *
     * @return  self
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;

        return $this;
    }
}
