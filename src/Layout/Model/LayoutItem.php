<?php

namespace TextParser\Layout\Model;

use TextParser\Formatter\FormatterInterface;

final class LayoutItem
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $start;

    /**
     * @var int
     */
    private $length;

    /**
     * @var string
     */
    private $description;

    /**
     * @var FormatterInterface
     */
    private $encoder;

    /**
     * @var FormatterInterface
     */
    private $decoder;

    /**
     * Get the value of name
     *
     * @return  string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     *
     * @return  self
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of start
     *
     * @return  int
     */
    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * Set the value of start
     *
     * @param  int  $start
     *
     * @return  self
     */
    public function setStart(int $start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get the value of length
     *
     * @return  int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * Set the value of length
     *
     * @param  int  $length
     *
     * @return  self
     */
    public function setLength(int $length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get the value of description
     *
     * @return  string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param  string  $description
     *
     * @return  self
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of encoder
     *
     * @return  FormatterInterface
     */
    public function getEncoder(): ?FormatterInterface
    {
        return $this->encoder;
    }

    /**
     * Set the value of encoder
     *
     * @param  FormatterInterface  $encoder
     *
     * @return  self
     */
    public function setEncoder(FormatterInterface $encoder)
    {
        $this->encoder = $encoder;

        return $this;
    }

    /**
     * Get the value of decoder
     *
     * @return  FormatterInterface
     */
    public function getDecoder(): ?FormatterInterface
    {
        return $this->decoder;
    }

    /**
     * Set the value of decoder
     *
     * @param  FormatterInterface  $decoder
     *
     * @return  self
     */
    public function setDecoder(FormatterInterface $decoder)
    {
        $this->decoder = $decoder;

        return $this;
    }
}
