<?php

namespace TextParser\Formatter;

final class PaddingBlankRight extends FormatterAbstract
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

        return str_pad($value, $length, ' ', STR_PAD_RIGHT);
    }
}
