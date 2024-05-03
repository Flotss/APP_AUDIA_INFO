<?php

namespace App\Entity;

class Content
{
    private int $id;
    private string $cle;
    private string $value;

    public function __construct($id, $cle, $value)
    {
        $this->id = $id;
        $this->cle = $cle;
        $this->value = $value;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCle(): string
    {
        return $this->cle;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}