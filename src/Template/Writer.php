<?php

namespace TextParser\Template;

use TextParser\Template\Model\Template;
use TextParser\Layout\Writer\WriterInterface as LayoutWriterInterface;
use TextParser\Template\Model\TemplateItem;
use TextParser\Layout\Manager as LayoutManager;

/**
 * Writer
 * 
 * This class is responsible for iterating over Layouts and writing something from it
 */
final class Writer
{
    /**
     * @var Template
     */
    private $template;

    /**
     * @var array
     */
    private $errors;

    /**
     * @param Template $template
     */
    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    /**
     * Receive a structured data and try to parse a content from it. Each key must be an alias or an identification
     * at the Config Template Item
     *
     * @param array $data
     * @param LayoutWriterInterface $layoutWriter
     * @return string
     */
    public function write(array $data, LayoutWriterInterface $layoutWriter = null): string
    {
        $this->errors = [];

        $sequence = [];
        foreach ($data as $templateAliasOrIdentification => $dataToWrite) {
            if ($TemplateItem = $this->findSpecificTemplateItem($templateAliasOrIdentification)) {

                $order = $TemplateItem->getOrder();
                if (!isset($sequence[$order])) {
                    $sequence[$order] = [];
                }

                $manager = new LayoutManager($TemplateItem->getLayout());
                if ($layoutWriter) {
                    $manager->setWriter($layoutWriter);
                }

                if (!is_array($dataToWrite)) {
                    $dataToWrite = [$dataToWrite];
                }

                array_walk($dataToWrite, function ($value) use ($manager, &$sequence, $order) {
                    $sequence[$order][] = $manager->write($value);
                });
            }
        }

        ksort($sequence, SORT_NUMERIC);

        $flattendArray = array_reduce($sequence, function ($carry, $sequenceItem) {
            return array_merge($carry, $sequenceItem);
        }, []);

        return implode($this->template->getDelimiter(), $flattendArray);
    }

    /**
     * @param mixed $key
     * @return TemplateItem|null
     */
    private function findSpecificTemplateItem($key): ?TemplateItem
    {
        $filtered = array_filter($this->template->getItens(), function (TemplateItem $item) use ($key) {
            $identifications = [$item->getIdentification(), $item->getAlias()];
            return in_array($key, $identifications);
        });

        if (empty($filtered)) {
            $this->errors[] = "Can't find a layout config for the key $key";
            return null;
        }

        return array_shift($filtered);
    }

    /**
     * Get the value of errors
     *
     * @return  array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Get the value of errors
     *
     * @return  array
     */
    public function hasError()
    {
        return !empty($this->errors);
    }
}
