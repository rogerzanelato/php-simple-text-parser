<?php

namespace TextParser\Template;

use TextParser\Loader\LoaderInterface;
use TextParser\Exception\InvalidLayoutItemException;
use TextParser\Exception\InvalidTemplateException;
use TextParser\Exception\InvalidTemplateItemException;
use TextParser\Layout\Factory as LayoutFactory;
use TextParser\Template\Model\TemplateItem;
use TextParser\Template\Model\Template;
use TextParser\Template\Identifier\IdentifierInterface;

/**
 * Loader
 * 
 * This class is responsible to receive a loader, load a config file and validate it
 */
final class Loader
{
    /**
     * @var LoaderInterface
     */
    private $loader;

    /**
     * @var array
     */
    private $formattersKeyMapping;

    /**
     * @var string
     */
    private $basePathLayout;

    /**
     * @param LoaderInterface $Loader
     * @param array $formattersKeyMapping
     * @param string $basePathLayout
     */
    public function __construct(LoaderInterface $Loader, array $formattersKeyMapping = [], string $basePathLayout = null)
    {
        $this->loader = $Loader;
        $this->formattersKeyMapping = $formattersKeyMapping;
        $this->basePathLayout = $basePathLayout;
    }

    /**
     * Load, validate and returna validated Layout
     *
     * @param string $filePath
     * @return Template
     */
    public function loadTemplate(string $filePath): Template
    {
        $content = $this->loader->load($filePath);

        return $this->getTemplateFromArray($content);
    }

    /**
     * Validate and return the Template class
     *
     * @param array $dataTemplateFile
     * @throws InvalidTemplateException
     * @throws InvalidTemplateItemException
     * @return Template
     */
    private function getTemplateFromArray(array $dataTemplateFile): Template
    {
        $Template = new Template;
        $sequence = [];

        $this->validateBaseTemplate($dataTemplateFile);

        foreach ($dataTemplateFile['items'] as $dataItem) {
            $this->validateDataItem($dataItem);

            $filePath = $this->basePathLayout . $dataItem['layoutSource'];
            $Layout = (new LayoutFactory)->createFromFilePath($filePath, $this->formattersKeyMapping);

            $order = $dataItem['order'] ?? 0;

            $TemplateItem = new TemplateItem;
            $TemplateItem->setLayout($Layout);
            $TemplateItem->setLayoutSource($dataItem['layoutSource']);
            $TemplateItem->setAlias($dataItem['alias'] ?? null);
            $TemplateItem->setIdentification($dataItem['identification']);
            $TemplateItem->setOrder($order);

            $sequence[$order] = $TemplateItem;
        }

        ksort($sequence, SORT_NUMERIC);

        $this->validateSequence($sequence);

        if (isset($dataTemplateFile['identifier'])) {
            $Template->setIdentifier($this->instanceIdentifier($dataTemplateFile['identifier']));
        }
        $Template->setDelimiter($dataTemplateFile['delimiter'] ?? "\n");
        $Template->setItens($sequence);

        return $Template;
    }

    /**
     * @param array $dataTemplateFile
     * @throws InvalidTemplateException
     * @return void
     */
    private function validateBaseTemplate(array $dataTemplateFile)
    {
        if (empty($dataTemplateFile)) {
            throw new InvalidTemplateException("Config template must not be empty!");
        }

        if (empty($dataTemplateFile['items'])) {
            throw new InvalidTemplateItemException("Config template must have at least one item!");
        }
    }

    /**
     * Try to instance an Identifier, throw an InvalidTemplateException if something fail
     *
     * @param string $identifier
     * @throws InvalidTemplateException
     * @return IdentifierInterface
     */
    private function instanceIdentifier(string $identifier): IdentifierInterface
    {
        if (!class_exists($identifier)) {
            throw new InvalidTemplateException("The identifier $identifier supplied at config file doesn't exists");
        }

        $identifierCls = new $identifier;

        if (!($identifierCls instanceof IdentifierInterface)) {
            throw new InvalidTemplateException("The identifier supplied must implement the TextParser\\Template\\Identifier\\IdentifierInterface");
        }

        return $identifierCls;
    }

    /**
     * @param array $dataItem
     * @throws InvalidLayoutItemException
     * @return void
     */
    private function validateDataItem(array $dataItem)
    {
        $requiredFields = ["identification", "layoutSource"];
        $keys = array_keys($dataItem);

        $diff = array_diff($requiredFields, $keys);

        if (!empty($diff)) {
            throw new InvalidLayoutItemException("This tags are required in the item configuration: " . implode(", ", $diff));
        }
    }

    /**
     * @param array $dataItem
     * @throws InvalidLayoutItemException
     * @return void
     */
    private function validateSequence(array $dataItem)
    {
        $identification = array_map(function (TemplateItem $it) {
            return $it->getIdentification();
        }, $dataItem);

        /**
         * If the identification is a Array, it'll raise a warning
         */
        $duplicates = array_filter(@array_count_values($identification), function ($it) {
            return $it > 1;
        });

        if (!empty($duplicates)) {
            $duplicatesName = array_keys($duplicates);
            throw new InvalidTemplateItemException("The item 'identification' at template item must be unique. Error at: " . implode(", ", $duplicatesName));
        }
    }
}
