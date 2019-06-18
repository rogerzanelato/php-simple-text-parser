<?php

namespace TextParser\Layout\Model;

use TextParser\Formatter\FormatterInterface;

interface ItemInterface
{
    public function getName(): string;
    public function getStart(): int;
    public function getLength(): int;
    public function getDescription(): string;
    public function getEncoder(): ?FormatterInterface;
    public function getDecoder(): ?FormatterInterface;

    public function setName(string $name);
    public function setStart(int $start);
    public function setLength(int $length);
    public function setDescription(string $description);
    public function setEncoder(FormatterInterface $Formatter);
    public function setDecoder(FormatterInterface $Formatter);
}
