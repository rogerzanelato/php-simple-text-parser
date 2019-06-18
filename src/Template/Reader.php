<?php

namespace TextParser\Template;

use TextParser\Template\Model\Template;
use TextParser\Layout\Reader\ReaderInterface as LayoutReaderInterface;
use TextParser\Template\Model\TemplateItem;
use TextParser\Layout\Manager as LayoutManager;

/**
 * Reader
 * 
 * This class is responsible for iterating over Layouts and populate something from it
 */
final class Reader
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
     * Receive a Content and return the data structred in an array by the aliases or identification
     * defined at each Item on the Template Config
     *
     * @param string $content
     * @param LayoutReaderInterface $layoutReader
     * @return array
     */
    public function read(string $content, LayoutReaderInterface $layoutReader = null): array
    {
        $this->errors = [];
        $explodedContent = explode($this->template->getDelimiter(), $content);

        $result = [];
        foreach ($explodedContent as $key => $value) {
            if ($TemplateItem = $this->findSpecificLayout($value, $key)) {
                $manager = new LayoutManager($TemplateItem->getLayout());

                $resultKeyName = $TemplateItem->getAlias() ?? $TemplateItem->getIdentification();

                if (!isset($result[$resultKeyName])) {
                    $result[$resultKeyName] = [];
                }

                if ($layoutReader) {
                    $manager->setReader($layoutReader);
                }

                $result[$resultKeyName][] = $manager->read($value);
            }
        }

        return $result;
    }

    /**
     * @param string $value
     * @param integer $line
     * @return TemplateItem|null
     */
    private function findSpecificLayout(string $value, int $line): ?TemplateItem
    {
        $filtered = array_filter($this->template->getItens(), function (TemplateItem $item) use ($value, $line) {
            $identifierCallback = $this->template->getIdentifier();

            if (is_array($item->getIdentification())) {
                return in_array($identifierCallback($value, $line), $item->getIdentification());
            }

            return $identifierCallback($value, $line) === $item->getIdentification();
        });

        if (empty($filtered)) {
            $this->errors[] = "Can't find a layout model for the line $line";
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
