<?php

namespace TextParser\Layout;

use TextParser\Layout\Reader\ReaderInterface;
use TextParser\Layout\Writer\WriterInterface;
use TextParser\Layout\Writer\WriteIntoString;
use TextParser\Layout\Model\Layout;
use TextParser\Layout\Reader\ReadIntoArray;

/**
 * Manager
 * 
 * This class is responsible for iterating over Layout itens and write or populate something from it
 */
final class Manager
{
    /**
     * 
     * @var Layout
     */
    private $layout;

    /**
     * 
     * @var WriterInterface
     */
    private $writer;

    /**
     * 
     * @var ReaderInterface
     */
    private $reader;

    /**
     * @param Layout $layout
     */
    public function __construct(Layout $layout)
    {
        $this->layout = $layout;

        $this->setupDefaults();
    }

    /**
     * @return void
     */
    private function setupDefaults()
    {
        $this->writer = new WriteIntoString;
        $this->reader = new ReadIntoArray;
    }

    /**
     * @param  WriterInterface  $writer
     * @return  self
     */
    public function setWriter(WriterInterface $writer)
    {
        $this->writer = $writer;

        return $this;
    }

    /**
     * @param  ReaderInterface  $reader
     * @return  self
     */
    public function setReader(ReaderInterface $reader)
    {
        $this->reader = $reader;

        return $this;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function write(array $data)
    {
        return $this->writer->write($data, $this->layout->getItens());
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function read(string $value)
    {
        return $this->reader->read($value, $this->layout->getItens());
    }
}
