<?php

namespace App\Entity;

class DataMonitoringSingle
{
    private string $date;
    private float $value;

    public function __construct($date, $value)
    {
        $this->date = $date;
        $this->value = $value;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
