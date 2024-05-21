<?php

namespace App\Database;

use App\Config\Credentials;
use App\Entity\User;
use PDO;

/**
 * The DataBaseSingleton class represents a singleton database connection.
 */
class DataBaseSingleton
{
    private static ?DataBaseSingleton $instance = null;
    private PDO $connection;

    /**
     * Private constructor to prevent creating multiple instances of the class.
     */
    private function __construct()
    {
        $credentials = Credentials::getCredentials(Credentials::$DB_PROD);

        $this->connection = new PDO(
            'mysql:host=' . $credentials->getHost() . ';port=' . $credentials->getPort() . ';dbname=' . $credentials->getName(),
            $credentials->getUser(),
            $credentials->getPassword()
        );
    }

    /**
     * Get the instance of the DataBaseSingleton class.
     *
     * @return DataBaseSingleton The instance of the DataBaseSingleton class.
     */
    public static function getInstance(): DataBaseSingleton
    {
        if (self::$instance === null) {
            self::$instance = new DataBaseSingleton();
        }
        return self::$instance;
    }

    /**
     * Get the database connection.
     *
     * @return PDO The database connection.
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * Save a user to the database.
     *
     * @param User $user The user to be saved.
     * @return void
     */
    public function saveUser(User $user): User
    {
        if ($user->getId() != 0) {
            $query = $this->connection->prepare('UPDATE User SET username = :username, firstName = :firstName, lastName = :lastName, email = :email, location = :location, phone = :phone, password = :password, role = :role WHERE id = :id');
            $query->bindValue('id', $user->getId());
        } else {
            $query = $this->connection->prepare('INSERT INTO User (username, firstName, lastName, email, location, phone, password, role) VALUES (:username, :firstName, :lastName, :email, :location, :phone, :password, :role)');
        }
        $query->execute([
            'username' => $user->getUsername(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'email' => $user->getEmail(),
            'location' => $user->getLocation(),
            'phone' => $user->getPhone(),
            'password' => $user->getPassword(),
            'role' => $user->getRole(),
        ]);

        if ($user->getId() == 0) {
            $user->setId($this->connection->lastInsertId());
        }

        return $user;
    }

    /**
     * Get a user from the database by username.
     *
     * @param string $username The username of the user.
     * @return User|null The user object if found, null otherwise.
     */
    public function getUserByUsername(string $username): ?User
    {
        $query = $this->connection->prepare('SELECT * FROM User WHERE username = :username');
        $query->execute(['username' => $username]);
        $userData = $query->fetch();

        if ($userData) {
            return User::createUserFromArray($userData);
        }

        return null;
    }

    /**
     * Get a user from the database by email.
     *
     * @param string $email The email of the user.
     * @return User|null The user object if found, null otherwise.
     */
    public function getUserByEmail(string $email): ?User
    {
        $query = $this->connection->prepare('SELECT * FROM User WHERE email = :email');
        $query->execute(['email' => $email]);
        $userData = $query->fetch();

        if ($userData) {
            return User::createUserFromArray($userData);
        }

        return null;
    }

    /**
     * Get a user by their token.
     *
     * @param string $token The token of the user.
     * @return User|null The user object if found, null otherwise.
     */
    public function getUserByToken(string $token): ?User
    {
        $userData = $this->makeRequest('SELECT * FROM User WHERE token = :token', ['token' => $token]);

        if (!empty($userData)) {
            return User::createUserFromArray($userData[0]);
        }

        return null;
    }

    /**
     * Make a database query and return the result as an array.
     *
     * @param string $query The SQL query.
     * @param array $params The parameters for the query.
     * @return array The result of the query as an array.
     */
    public function makeRequest($query, $params = []): array
    {
        $query = $this->connection->prepare($query);
        $query->execute($params);
        return $query->fetchAll();
    }
}
