<?php

namespace App\Entity;

use App\Utils\Security;

class User
{
    /**
     * @var int|null The ID of the user.
     */
    private $id;

    /**
     * @var string|null The username of the user.
     */
    private string $username;

    private string $firstName;

    private string $lastName;


    /**
     * @var string|null The email of the user.
     */
    private string $email;

    /**
     * @var string|null The hashed password of the user.
     */
    private string $password;

    private string $location;
    private string $phone;
    private string $role;



    /**
     * User constructor.
     *
     * @param string $username The username of the user.
     * @param string $email The email of the user.
     * @param string|null $password The password of the user (optional).
     */
    public function __construct(int $id, string $username, string $email, string $password = null, string $firstName, string $lastName, string $location = null, string $phone = null, string $role = 'USER')
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->location = $location;
        $this->phone = $phone;
        $this->role = $role;
    }

    /**
     * User constructor with array.
     *
     * @param array $data The user data.
     */
    public static function createUserFromArray(array $data)
    {
        return new self($data['id'], $data['username'], $data['email'], $data['password'], $data['firstName'], $data['lastName'], $data['location'], $data['phone'], $data['role']);
    }

    /**
     * Converts the user to a string.
     *
     * @return string The user as a string.
     */
    public function toString(): string
    {
        return "User: [id: $this->id, username: $this->username, email: $this->email, password: $this->password, firstName: $this->firstName, lastName: $this->lastName, location: $this->location, phone: $this->phone, role: $this->role]";
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
     * Sets the ID of the user.
     *
     * @param int $id The new ID.
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Sets the password of the user.
     *
     * @param string $password The new password.
     * @return self
     */
    public function setPasswordHashed(string $password): self
    {
        $this->password = Security::hashPassword($password);

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function setFullName(string $firstName, string $lastName): self
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
}
