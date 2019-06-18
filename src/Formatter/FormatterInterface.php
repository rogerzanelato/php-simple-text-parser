<?php

namespace TextParser\Formatter;

interface FormatterInterface
{
    /**
     * Return the param as a formatted value
     *
     * @param mixed $value
     * @param int $length
     * @return mixed
     */
    public function format($value, int $length);
}
