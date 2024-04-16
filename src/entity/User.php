<?php

namespace App\Entity;

class User
{
    /**
     * @var int|null The ID of the user.
     */
    private $id;

    /**
     * @var string|null The username of the user.
     */
    private $username;

    /**
     * @var string|null The email of the user.
     */
    private $email;

    /**
     * @var string|null The hashed password of the user.
     */
    private $password;

    /**
     * User constructor.
     *
     * @param string $username The username of the user.
     * @param string $email The email of the user.
     * @param string|null $password The password of the user (optional).
     */
    public function __construct(string $username, string $email, string $password = null)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password ? password_hash($password, PASSWORD_DEFAULT) : null;
    }

    /**
     * Gets the ID of the user.
     *
     * @return int|null The ID of the user.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the username of the user.
     *
     * @return string|null The username of the user.
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Sets the username of the user.
     *
     * @param string $username The new username.
     * @return self
     */
    public function setName(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Gets the email of the user.
     *
     * @return string|null The email of the user.
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Sets the email of the user.
     *
     * @param string $email The new email.
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Gets the hashed password of the user.
     *
     * @return string|null The hashed password of the user.
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Sets the password of the user.
     *
     * @param string $password The new password.
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}