<?php

require_once __DIR__ . '\User.php';

class UserRepository
{

    /** @var PDO|null $pdo */
    protected ?PDO $pdo;


    public function __construct()
    {
        try {

            $dbh = new PDO('mysql:host=localhost;dbname=mysql', 'root', '123');
            $this->pdo = $dbh;
            $dbh = null;

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            $this->pdo = null;
        }
    }

    /**
     * Возвращает обект PDO либо null
     * @return PDO|null
     */
    public function getPdo(): ?PDO
    {
        return $this->pdo;
    }

    /**
     * Проверяет зарегестрирован ли такой пользователь в базе
     * @param User $user
     * @return bool
     */
    public function isExist(User $user): bool
    {
        $sql = 'SELECT * FROM `taskuser` WHERE `name` = :name AND `password` = :password';

        $query = $this->pdo->prepare($sql);
        $query->execute([
            ':name' => $user->getName(),
            ':password' => $user->getPassword(),
        ]);

        return !empty($query->fetchAll());
    }

}