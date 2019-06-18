<?php

namespace TextParser\Layout;

use TextParser\Layout\Model\Layout;
use TextParser\Loader\LoaderInterface;
use TextParser\Exception\InvalidLayoutException;
use TextParser\Exception\InvalidLayoutItemException;
use TextParser\Formatter\FormatterInterface;
use TextParser\Layout\Model\LayoutItem;

/**
 * Loader
 * 
 * This class is responsible to receive a loader, load a config file and validate it
 */
final class Loader
{
    /**
     * @var string
     */
    private $filePath;

    /**
     * @var LoaderInterface
     */
    private $loader;

    /**
     * @var array
     */
    private $formattersKeyMapping;

    /**
     * @param LoaderInterface $Loader
     * @param array $formattersKeyMapping
     */
    public function __construct(LoaderInterface $Loader, array $formattersKeyMapping = [])
    {
        $this->loader = $Loader;
        $this->formattersKeyMapping = $formattersKeyMapping;
    }

    /**
     * Load, validate and returna validated Layout
     *
     * @param string $filePath
     * @return Layout
     */
    public function loadLayout(string $filePath): Layout
    {
        $content = $this->loader->load($filePath);

        $this->filePath = $filePath;

        return $this->getLayoutFromArray($content);
    }

    /**
     * Validate and return the Layout class
     *
     * @param array $dataLayoutFile
     * @throws InvalidLayoutException
     * @throws InvalidLayoutItemException
     * @return Layout
     */
    private function getLayoutFromArray(array $dataLayoutFile): Layout
    {
        $Layout = new Layout;
        $sequence = [];

        $this->validateBaseLayout($dataLayoutFile);

        foreach ($dataLayoutFile['items'] as $dataItem) {
            $this->validateDataItem($dataItem);

            $item = new LayoutItem;
            $item->setName($dataItem['name']);
            $item->setStart($dataItem['start']);
            $item->setLength($dataItem['length']);
            $item->setDescription($dataItem['description'] ?? null);

            if (isset($dataItem['encodeFormat'])) {
                $item->setEncoder($this->instanceFormatter($dataItem['encodeFormat']));
            }

            if (isset($dataItem['decodeFormat'])) {
                $item->setDecoder($this->instanceFormatter($dataItem['decodeFormat']));
            }

            $sequence[$item->getStart()] = $item;
        }

        ksort($sequence, SORT_NUMERIC);

        $this->validateSequence($sequence);

        $Layout->setItens($sequence);

        return $Layout;
    }

    private function validateBaseLayout($base)
    {
        if (empty($base)) {
            throw new InvalidLayoutException("The config must not be empty!");
        }

        if (empty($base['items'])) {
            throw new InvalidLayoutException("The config must have a tag 'items' with the config of each item!");
        }
    }

    /**
     * Validate item
     *
     * @param mixed $dataItem
     * @throws InvalidLayoutItemException
     * @return void
     */
    private function validateDataItem($dataItem)
    {
        if (!is_array($dataItem)) {
            throw new InvalidLayoutItemException("Decoded Item must be an array.");
        }

        $keys = array_keys($dataItem);
        $requiredFields = ['name', 'start', 'length'];

        $diff = array_diff($requiredFields, $keys);

        if (!empty($diff)) {
            throw new InvalidLayoutItemException("This itens is required in configuration file: " . implode(", ", $diff));
        }

        if (!is_int($dataItem['start']) || !is_int($dataItem['length'])) {
            throw new InvalidLayoutItemException("The 'start' and 'length' fields must be integers.");
        }
    }

    /**
     * Try to instanciate a Formatter. First we search in the Aliases supplied at the Constructor,
     * if we find, we'll try to instanciate it, if not, we'll treat it as class name and again
     * try to instanciate it. If nothing is found at all, we throws an Exception 
     *
     * @param string $formatter
     * @throws InvalidLayoutItemException
     * @return FormatterInterface|
     */
    private function instanceFormatter(string $formatter): FormatterInterface
    {
        if (!empty($this->formattersKeyMapping)) {
            if (array_key_exists($formatter, $this->formattersKeyMapping)) {
                $mappedClass = $this->formattersKeyMapping[$formatter];

                if (class_exists($mappedClass)) {
                    return new $mappedClass;
                }
            }
        }

        if (class_exists($formatter)) {
            return new $formatter;
        }

        throw new InvalidLayoutItemException("The encoder/decoder option '$formatter' supplied wasn't recognized. Did you supplied a valid class, or make the right aliases?");
    }

    /**
     * Iterate over an sequence of itens and check if the sequence is valid
     *
     * @param array<Item> $itens
     * @throws InvalidLayoutException
     * @return void
     */
    private function validateSequence(array $itens)
    {
        $lastPositionIndice = null;

        foreach ($itens as $position => $item) {
            if (null !== $lastPositionIndice) {
                $lastItem = $itens[$lastPositionIndice];
                $thisSupposedPosition = $lastItem->getStart() + $lastItem->getLength();

                if ($thisSupposedPosition - $position <> 0) {
                    throw new InvalidLayoutException("Sequence invalid at item {$item->getName()}. There is a conflict within the value range of this item and the {$lastItem->getName()}.");
                }
            }

            $lastPositionIndice = $position;
        }

        $names = array_map(function (LayoutItem $it) {
            return $it->getName();
        }, $itens);

        $duplicates = array_filter(array_count_values($names), function ($it) {
            return $it > 1;
        });

        if (!empty($duplicates)) {
            $duplicatesName = array_keys($duplicates);
            throw new InvalidLayoutException("The item 'name' at layout must be unique. Layout {$this->filePath} Error at: " . implode(", ", $duplicatesName));
        }
    }
}
