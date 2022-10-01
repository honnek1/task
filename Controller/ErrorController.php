<?php

spl_autoload('ViewController');

class ErrorController
{
    /**
     * Метод вызывается при неверно переданном запросе в URI, просто выводит в окно браузера строку
     * @return void - выводит строку
     */
    public function actionError(): void
    {
        $view = new ViewController();
        $view->display('errorTemplate');
    }
}