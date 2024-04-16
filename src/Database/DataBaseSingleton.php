<?php

namespace App\Database;

use App\Config\Credentials;
use App\Entity\User;
use PDO;


class DataBaseSingleton
{
    private static ?DataBaseSingleton $instance = null;
    private PDO $connection;

    private function __construct()
    {
        $credentials = Credentials::getCredentials(Credentials::DB_DEV);

        $this->connection = new PDO(
            'mysql:host=' . $credentials->getHost() . ';port=' . $credentials->getPort() . ';dbname=' . $credentials->getName(),
            $credentials->getUser(),
            $credentials->getPassword()
        );
    }

    public static function getInstance(): DataBaseSingleton
    {
        if (self::$instance === null) {
            self::$instance = new DataBaseSingleton();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }


    public function saveUser(User $user)
    {
        $query = $this->connection->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
        $query->execute([
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword()
        ]);
    }

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

    public function makeRequest($query, $params = []): array
    {
        $query = $this->connection->prepare($query);
        $query->execute($params);
        return $query->fetchAll();
    }
}
