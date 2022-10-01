<?php
spl_autoload('Model/TaskRepository');
spl_autoload('Model/UserRepository');

/**
 * Основной контроллер
 */
class MainController
{
    /** @var TaskRepository $taskRepository */
    protected TaskRepository $taskRepository;

    /** @var ViewController $viewController */
    protected ViewController $viewController;

    /** @var UserRepository $userRepository */
    protected UserRepository $userRepository;

    /**
     * Инициализируем поля
     */
    public function __construct()
    {
        $this->taskRepository = new TaskRepository();
        $this->viewController = new ViewController();
        $this->userRepository = new UserRepository();
    }

    /**
     * Основной экшн для главной страницы
     */
    public function actionMain(?array $params)
    {
        session_start();
        if (!($_SESSION['user_id'] ?? false)) {
            session_destroy();
        }


        $page = $params['page'] ?? 1;
        $orderBy = $params['by'] ?? '';
        $limit = 3;
        $offset = ($page - 1) * $limit;
        $tasks = $this->taskRepository->findWithLimitOffsetOrderBy($limit, $offset, $orderBy);

        if (!$tasks) {
            throw new OutOfBoundsException(message: 'Ошибка запроса к БД');
        }

        $this->viewController->setData([
            'page' => $page,
            'tasks' => $tasks,
            'limit' => $limit,
            'countAll' => $this->taskRepository->getCountTasks(),
            'orderBy' => $orderBy,
            'isAdmin' => !!($_SESSION['user_id'] ?? false),
        ]);


        $this->viewController->display('main');
    }

    /**
     * Экшн для добавления задачи в базу
     * @param array|null $params
     * @param array|null $postParams
     */
    public function actionAddTask(?array $params, ?array $postParams)
    {
        if (null === $postParams['email'] || null === $postParams['user'] || null === $postParams['text']) {
            throw new OutOfBoundsException('Не играйтесь с POST запросами!');
        }
        if (!preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i', $postParams['email'])) {
            throw new OutOfBoundsException('Невалидный email!');
        }

        $task = new Task;
        $task->setEmail($postParams['email']);
        $task->setUser($postParams['user']);
        $task->setText($postParams['text']);

        $this->taskRepository->setNewTask($task);

        header('Location: http://localhost/project/src/index.php/main/main');
    }

    /**
     * Редактирует текст задачи
     *
     * @param array|null $params
     * @param array|null $postParams
     * @throws Exception
     */
    public function actionEdit(?array $params, ?array $postParams)
    {
        if (empty($postParams)) {
            throw new Exception(message: 'Не найден POST запрос');
        }
        $id = (int)$postParams['id'];
        if (!$this->taskRepository->findByPK($id)) {
            throw new OutOfBoundsException('Не найдена задача с id ' . $id);
        }
        if (isset($postParams['text'])) {
            $newText = $postParams['text'];
            $this->taskRepository->editTaskText($id, $newText);
        }
        if (isset($postParams['newStatus'])) {
            $newStatus = $postParams['newStatus'];
            $this->taskRepository->editTaskStatus($id, $newStatus);
        }

        header('Location: http://localhost/project/src/index.php/main/main');
    }

    /**
     * Экшн входа в личный кабинет
     *
     * @param array|null $params
     * @param array|null $postParams
     */
    public function actionLogin(?array $params, ?array $postParams)
    {
        $postParams = empty($postParams) ? null : $postParams;
        if (null !== $postParams) {
            $user = new User();
            $user->setName($postParams['user']);
            $user->setPassword(sha1($postParams['pass']));
            $isExist = $this->userRepository->isExist($user);

            if ($isExist) {
                session_start();
                $_SESSION['user_id'] = $user->getName();
                header('Location: http://localhost/project/src/index.php/main/main');
                exit();
            }
        }

        $this->viewController->display('login');
    }

    /**
     * Экшн выхода из личного кабинета
     */
    public function actionLogout(): void
    {
        session_start();
        $_SESSION['user_id'] = null;
        session_destroy();
        header('Location: http://localhost/project/src/index.php/main/main');
        exit();
    }



}