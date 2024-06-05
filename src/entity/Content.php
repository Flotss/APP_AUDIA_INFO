<?php

namespace App\Entity;

class Content
{
    private int $id;
    private string $cle;
    private string $value;

    /**
     * Content constructor.
     *
     * @param int $id The ID of the content.
     * @param string $cle The key of the content.
     * @param string $value The value of the content.
     */
    public function __construct($id, $cle, $value)
    {
        $this->id = $id;
        $this->cle = $cle;
        $this->value = $value;
    }

    /**
     * Get the ID of the content.
     *
     * @return int The ID of the content.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the key of the content.
     *
     * @return string The key of the content.
     */
    public function getCle(): string
    {
        return $this->cle;
    }

    /**
     * Get the value of the content.
     *
     * @return string The value of the content.
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
