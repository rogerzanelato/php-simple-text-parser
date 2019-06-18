<?php

namespace Sample;

require dirname(__DIR__, 3) . '/vendor/autoload.php';

use TextParser\Exception\BaseException;
use TextParser\Layout\Factory as LayoutFactory;
use TextParser\Layout\Manager as LayoutManager;
use TextParser\Formatter\FormatterInterface;

/**
 * TO create Custom Classes, you just have to implement the FormatterInterface
 */
class IntegerToHamburguer implements FormatterInterface
{
    /**
     * Why not?
     */
    public function format($value, int $length)
    {
        return preg_replace('/[0-9]/', "🍔", $value);
    }
}

try {
    $Layout = (new LayoutFactory)->createFromFilePath("header.json");

    $Manager = new LayoutManager($Layout);

    $file = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'sample_string.txt';
    $string = (string)file_get_contents($file);
    $exploded = explode("#", $string);
    $dados = $Manager->read($exploded[0]);

    $str = $Manager->write($dados);

    echo "<h3>Data Readed</h3>";
    echo "<pre>";
    print_r($dados);
    echo "</pre>";

    echo "<h3>Data Writed</h3>";
    echo "<pre>";
    print_r($str);
    echo "</pre>";
} catch (BaseException $ex) {
    echo "Ops, something went wrong: <b>" . $ex->getMessage() . "</b>";
}
