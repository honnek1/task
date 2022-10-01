<?php


require_once __DIR__ . '\Task.php';

class TaskRepository
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
     * @param int $id
     * @return array|false
     */
    public function findByPK(int $id): array|false
    {
        $sql = 'SELECT * FROM `task` WHERE `id` = :id';

        $params = [
         ':id' => $id
        ];

        $query = $this->pdo->prepare($sql);
        $query->execute($params);

        return $query->fetch();
    }

    /**
     * Устанавливает новую задачу
     * @param Task $task
     */
    public function setNewTask(Task $task): void
    {
        $sql = 'INSERT INTO `task` (user, email, text) VALUES (:user, :email, :text)';

        $params = [
            ':user' => $task->getUser(),
            ':email' => $task->getEmail(),
            ':text' => $task->getText()
        ];

        $query = $this->pdo->prepare($sql);
        $query->execute($params);
    }

    /**
     * Возвращает число записей
     * @return int
     */
    public function getCountTasks(): int
    {
        $sql = 'SELECT * FROM `task`';
        $query = $this->pdo->prepare($sql);
        $query->execute();

        return $query->rowCount();
    }

    /**
     * Возвращает массив задачи по указанным параметрам
     *
     * @param string $limit
     * @param string $offset
     * @param string|null $orderBy
     * @return bool|array
     */
    public function findWithLimitOffsetOrderBy(string $limit, string $offset, ?string $orderBy = null): bool|array
    {
        $sql = 'SELECT * FROM `task`';

        if ('' === $orderBy) {
            $sql .= ' ORDER BY id ASC';
        } else {
            $sql .= ' ORDER BY :orderBy, id DESC';
        }

        $sql .= ' LIMIT :limit OFFSET :offset';
        $query = $this->pdo->prepare($sql);
        if ('' !== $orderBy){
            $query->bindParam(':orderBy', $orderBy);
        }
        $query->bindParam(':limit', $limit, PDO::PARAM_INT);
        $query->bindParam(':offset', $offset, PDO::PARAM_INT);

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * Редактирует текст новости по id
     * @param int $id
     * @param string $newText
     */
    public function editTaskText(int $id, string $newText): void
    {
        $sql = 'UPDATE `task` SET `text` = :newText WHERE `id` = :id';

        $params = [
            ':id' => $id,
            ':newText' => $newText,
        ];
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
    }

    /**
     * Редактирует новость по id
     * @param int $id
     * @param string $newStatus
     */
    public function editTaskStatus(int $id, string $newStatus): void
    {
        $sql = 'UPDATE `task` SET `status` = :newStatus WHERE `id` = :id';

        $params = [
            ':id' => $id,
            ':newStatus' => $newStatus,
        ];
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
    }
}