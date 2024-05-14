<?php

namespace App\Entity;

class DataMonitoringSingle
{
    private string $date;
    private int $value;

    public function __construct($date, $value)
    {
        $this->date = $date;
        $this->value = $value;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
