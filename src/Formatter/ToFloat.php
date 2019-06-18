<?php

namespace TextParser\Formatter;

use TextParser\Util\StringUtis;

final class ToFloat extends FormatterAbstract
{
    /**
     * Return the param as a formatted value
     *
     * @param mixed $value
     * @param int $length
     * @return mixed
     */
    public function format($value, int $length)
    {
        $value = $this->adjustValue($value, $length);

        $value = StringUtis::onlyNumbers($value);

        return (float)$value;
    }
}
