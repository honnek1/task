<?php

spl_autoload('Controller/ErrorController');
spl_autoload('Controller/MainController');

/**
 * Класс Роутер
 */
class Router
{
    /** @var string $controllerName - имя контроллера который приходит от пользователя */
    protected string $controllerName;

    /** @var string $action - имя экшна который приходит от пользователя */
    protected string $action;

    /** @var null|array $params - массив с get-параметрами который мы получили от пользователя */
    protected null|array $params;

    /** @var object $controller - созданый объект контроллера */
    protected object $controller;

    /** @var array|null $postParams - Post параметры */
    protected null|array $postParams;


    /**
     * Заполняет свойства $controllerName, $action и $params массив (если есть get-парметры)
     */
    public function __construct(array $request)
    {
        $query = $request['QUERY_STRING'];
        $path = $request['REQUEST_URI'];
        $arrayPath = explode('/', $path);
        $this->controllerName = ucfirst($arrayPath[count($arrayPath) - 2]) . 'Controller';
        $this->action = 'action' . ucfirst(explode('?', $arrayPath[count($arrayPath) - 1])[0]);
        $this->postParams = $_POST;

        if (!empty($query)) {
            $this->params = explode("&", $query);
        } else {
            $this->params = null;
        }

    }

    /**
     * Создает объект вызываемого контроллера, при выбрасывании ошибки создает объект класса ErrorController, и вызовет его экшн - actionError
     * @return object - возвращает объект вызываемого контроллера
     */
    public function getController(): object
    {
        try {
            $this->controller = new ($this->controllerName);
        } catch (Throwable $error) {

            $this->controller = new ErrorController();
            $this->action = 'actionError';
        }
        return $this->controller;
    }

    /**
     * Функция возвращает экшн указанный в URI вызываемого контроллера, если в вызываемом контроллере данного экшона нет, вернет 'actionEmpty'
     * @return string - возвращает имя запрашиваемого экшна
     */
    public function getAction(): string
    {
        if (method_exists($this->controller, $this->action)) {

            return $this->action;
        }

        return 'actionEmpty';
    }

    /**
     * Функция возвращает get-параметры переданные в URI в массиве или null(если их нет)
     * @return array|null - возвращает параметры
     */
    public function getParams(): array|null
    {
        $assocParams = [];

        if (null === $this->params) {
            return null;
        }

        foreach ($this->params as $param) {
            $param = explode('=', $param);
            $assocParams[$param[0]] = $param[1];
        }

        return $assocParams;
    }

    /**
     * Возвращает массив с пост параметрами
     * @return array|null
     */
    public function getPostParams(): array|null
    {
        return $this->postParams;
    }
}
