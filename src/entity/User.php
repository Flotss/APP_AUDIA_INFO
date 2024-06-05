<?php

namespace App\Entity;

use App\Utils\Security;

class User
{
    private $id;
    private string $username;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $password;
    private string $location;
    private string $phone;
    private string $role;
    private string $image;

    public string $prefTemp = "";
    public string $prefSon = "";

    /**
     * User constructor.
     *
     * @param int $id The ID of the user.
     * @param string $username The username of the user.
     * @param string $email The email of the user.
     * @param string $password The password of the user.
     * @param string $firstName The first name of the user.
     * @param string $lastName The last name of the user.
     * @param string $location The location of the user.
     * @param string $phone The phone number of the user.
     * @param string $role The role of the user.
     */
    public function __construct(int $id, string $username, string $email, string $password, string $firstName, string $lastName, string $location = "", string $phone = "", string $role = 'USER')
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
        $this->image = "";
    }

    /**
     * Creates a new User object from an array of data.
     *
     * @param array $data The user data.
     * @return User The created User object.
     */
    public static function createUserFromArray(array $data): User
    {
        return new self($data['id'], $data['username'], $data['email'], $data['password'], $data['firstName'], $data['lastName'], $data['location'], $data['phone'], $data['role']);
    }

    /**
     * Converts the user to a string representation.
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
    public function setUserName(string $username): self
    {
        $this->username = $username;

        return $this;
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

    /**
     * Sets the hashed password of the user.
     *
     * @param string $password The new password.
     * @return self
     */
    public function setPasswordHashed(string $password): self
    {
        $this->password = Security::hashPassword($password);

        return $this;
    }

    /**
     * Gets the first name of the user.
     *
     * @return string|null The first name of the user.
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Sets the first name of the user.
     *
     * @param string $firstName The new first name.
     * @return self
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Gets the last name of the user.
     *
     * @return string|null The last name of the user.
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * Sets the last name of the user.
     *
     * @param string $lastName The new last name.
     * @return self
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Gets the full name of the user.
     *
     * @return string The full name of the user.
     */
    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * Sets the full name of the user.
     *
     * @param string $firstName The new first name.
     * @param string $lastName The new last name.
     * @return self
     */
    public function setFullName(string $firstName, string $lastName): self
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Gets the location of the user.
     *
     * @return string|null The location of the user.
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * Sets the location of the user.
     *
     * @param string $location The new location.
     * @return self
     */
    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Gets the phone number of the user.
     *
     * @return string|null The phone number of the user.
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Sets the phone number of the user.
     *
     * @param string $phone The new phone number.
     * @return self
     */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Gets the role of the user.
     *
     * @return string|null The role of the user.
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * Sets the role of the user.
     *
     * @param string $role The new role.
     * @return self
     */
    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Gets the image of the user.
     *
     * @return string|null The image of the user.
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Sets the image of the user.
     *
     * @param string $image The new image.
     * @return self
     */
    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Gets the preferred temperature of the user.
     *
     * @return string|null The preferred temperature of the user.
     */
    public function getPrefTemp(): ?string
    {
        return $this->prefTemp;
    }

    /**
     * Sets the preferred temperature of the user.
     *
     * @param string $prefTemp The new preferred temperature.
     * @return self
     */
    public function setPrefTemp(string $prefTemp): self
    {
        $this->prefTemp = $prefTemp;

        return $this;
    }

    /**
     * Gets the preferred sound of the user.
     *
     * @return string|null The preferred sound of the user.
     */
    public function getPrefSon(): ?string
    {
        return $this->prefSon;
    }

    /**
     * Sets the preferred sound of the user.
     *
     * @param string $prefSon The new preferred sound.
     * @return self
     */
    public function setPrefSon(string $prefSon): self
    {
        $this->prefSon = $prefSon;

        return $this;
    }
}
