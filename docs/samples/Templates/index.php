<?php

namespace Sample;

require dirname(__DIR__, 3) . '/vendor/autoload.php';

use TextParser\Exception\BaseException;
use TextParser\Template\Factory as TemplateFactory;
use TextParser\Template\Manager as TemplateManager;

try {
    $file = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'sample_string.txt';

    $Template = (new TemplateFactory)->createFromFilePath("template.json");
    /**
     * This closure will receive the value and line being read, and is responsible to extract the Identification
     * that should be defined at the Identification in "Template -> Items -> Identification"
     * Obs: You can also pass an "identifier" tag at the template.json with a Class to be "invoked". It must implement
     * the TextParser\Template\Identifier\IdentifierInterface
     */
    $Template->setIdentifier(function ($value, $line) {
        if ($line === 0) {
            return 'IP20';  // In this file, Header have a identification in a different pattern, than the other lines
        }

        return substr($value, 0, 7);
    });

    $Manager = new TemplateManager($Template);

    $string = (string)file_get_contents($file);

    $dados = $Manager->read($string);

    $str = $Manager->write($dados);

    echo "<h3>Data Readed</h3>";
    echo "<pre>";
    print_r($dados);
    echo "</pre>";

    /**
     * If something goes wrong, like a Layout not found, we set an error internally and continue processing
     */
    if ($Manager->getReader()->hasError()) {
        echo "<h3>Errors On Read</h3>";
        echo "<pre>";
        print_r($Manager->getReader()->getErrors());
        echo "</pre>";
    }

    echo "<h3>Data Writed</h3>";
    echo "<pre>";
    print_r($str);
    echo "</pre>";

    if ($Manager->getWriter()->hasError()) {
        echo "<h3>Errors On Write</h3>";
        echo "<pre>";
        print_r($Manager->getWriter()->getErrors());
        echo "</pre>";
    }
} catch (BaseException $ex) {
    echo "Ops, something went wrong: <b>" . $ex->getMessage() . "</b>";
}
