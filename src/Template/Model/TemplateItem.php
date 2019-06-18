<?php

namespace TextParser\Template\Model;

use TextParser\Layout\Model\Layout;

final class TemplateItem
{
    /**
     * @var Layout
     */
    private $layout;

    /**
     * @var string
     */
    private $layoutSource;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var string
     */
    private $identification;

    /**
     * @var int
     */
    private $order;

    /**
     * Get the value of alias
     *
     * @return  string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set the value of alias
     *
     * @param  string  $alias
     *
     * @return  self
     */
    public function setAlias(string $alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get the value of order
     *
     * @return  int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the value of order
     *
     * @param  int  $order
     *
     * @return  self
     */
    public function setOrder(int $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get the value of layoutSource
     *
     * @return  string
     */
    public function getLayoutSource()
    {
        return $this->layoutSource;
    }

    /**
     * Set the value of layoutSource
     *
     * @param  string  $layoutSource
     *
     * @return  self
     */
    public function setLayoutSource(string $layoutSource)
    {
        $this->layoutSource = $layoutSource;

        return $this;
    }

    /**
     * Get the value of Layout
     *
     * @return  Layout
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Set the value of Layout
     *
     * @param  Layout  $Layout
     *
     * @return  self
     */
    public function setLayout(Layout $layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Get the value of identification
     *
     * @return  mixed
     */
    public function getIdentification()
    {
        return $this->identification;
    }

    /**
     * Set the value of identification
     *
     * @param  mixed  $identification
     *
     * @return  self
     */
    public function setIdentification($identification)
    {
        $this->identification = $identification;

        return $this;
    }
}
