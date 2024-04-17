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
    public function saveUser(User $user)
    {
        $query = $this->connection->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
        $query->execute([
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword()
        ]);
    }

    /**
     * Get a user from the database by username.
     *
     * @param string $username The username of the user.
     * @return User|null The user object if found, null otherwise.
     */
    public function getUserByUsername(string $username): ?User
    {
        $query = $this->connection->prepare('SELECT * FROM users WHERE username = :username');
        $query->execute(['username' => $username]);
        $userData = $query->fetch();

        if ($userData) {
            return new User($userData['username'], $userData['email'], $userData['password']);
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
        $query = $this->connection->prepare('SELECT * FROM users WHERE email = :email');
        $query->execute(['email' => $email]);
        $userData = $query->fetch();

        if ($userData) {
            return new User($userData['username'], $userData['email'], $userData['password']);
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