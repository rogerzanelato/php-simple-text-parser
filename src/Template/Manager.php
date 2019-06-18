<?php

namespace TextParser\Template;

use TextParser\Template\Model\Template;
use TextParser\Exception\InvalidTemplateException;
use TextParser\Layout\Reader\ReaderInterface as LayoutReaderInterface;
use TextParser\Layout\Writer\WriterInterface as LayoutWriterInterface;

/**
 * Manager
 * 
 * This class is responsible for iterating over Layouts and populate populate something from it based on a Template
 */
final class Manager
{
    /**
     * 
     * @var Writer
     */
    private $writer;

    /**
     * 
     * @var Reader
     */
    private $reader;

    /**
     * @param Template $template
     */
    public function __construct(Template $template)
    {
        $identifier = $template->getIdentifier();
        if (!is_callable($identifier)) {
            throw new InvalidTemplateException("The supplied template must have a tag Identifier with a Callable or an implementation of IdentifierInterface");
        }

        $this->writer = new Writer($template);
        $this->reader = new Reader($template);
    }

    /**
     * @param array $data
     * @param LayoutWriterInterface $LayoutWriter
     * @return void
     */
    public function write(array $data, LayoutWriterInterface $LayoutWriter = null)
    {
        $result = $this->writer->write($data, $LayoutWriter);

        return $result;
    }

    /**
     * @param string $value
     * @param LayoutReaderInterface $LayoutReader
     * @return array
     */
    public function read(string $value, LayoutReaderInterface $LayoutReader = null)
    {
        $result = $this->reader->read($value, $LayoutReader);

        return $result;
    }

    /**
     * Get the value of writer
     *
     * @return  Writer
     */
    public function getWriter()
    {
        return $this->writer;
    }

    /**
     * Get the value of reader
     *
     * @return  Reader
     */
    public function getReader()
    {
        return $this->reader;
    }
}
