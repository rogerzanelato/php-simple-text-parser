<?php

namespace TextParser\Formatter;

use TextParser\Util\StringUtis;

abstract class FormatterAbstract implements FormatterInterface
{
    /**
     * @var bool
     */
    protected $removeEspecialChars;

    /**
     * @param boolean $removeEspecialChars
     */
    public function __construct($removeEspecialChars = true)
    {
        $this->removeEspecialChars = $removeEspecialChars;
    }

    /**
     * Cut value if necessary. Remove especial chars, if necessary
     *
     * @param mixed $value
     * @param integer $length
     * @return void
     */
    protected function adjustValue($value, int $length)
    {
        if (strlen($value) > $length) {
            $value = substr($value, 0, $length);
        }

        if ($this->removeEspecialChars && is_string($value)) {
            $value = StringUtis::removeSpecialChars($value);
        }

        return $value;
    }
}
