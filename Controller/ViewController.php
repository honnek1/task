<?php

/**
 * Класс для работы с шаблонами страниц
 */
class ViewController
{
    /** @var string $path */
    protected string $path;

    /** @var array|null $data */
    protected array|null $data;


    /**
     * Устанавливаем значение пути
     */
    public function __construct()
    {
        $this->path = __DIR__ . '/../' . 'View/';
    }

    /**
     * Устанавливаем набор данных для отображения в шаблоне
     * @param array|null $newData
     * @return void
     */
    public function setData(?array $newData): void
    {
        $this->data = $newData;
    }

    /**
     * Возврат массива из свойства дата
     * @return array|null
     */
    public function getData(): array|null
    {
        return $this->data;
    }

    /**
     * метод для отображения шаблона
     * @param string $template
     * @return void
     */
    public function display(string $template): void
    {
        if (file_exists($this->path . $template . '.php')) {
            include($this->path . $template . '.php');
        }
    }


    /**
     * метод для возврата шаблона для отображения
     * @param string $template
     * @return string
     * @throws Exception
     */
    public function render(string $template): string
    {
        if (file_exists($this->path . $template . '.php')) {

            return ($this->path . $template . '.php');
        }

        throw new Exception('Файл не найден');
    }

    /**
     * сохраняем данные с именем $name и значением $value в шаблон
     * @param string $name
     * @param string $value
     * @return void
     */
    public function assign(string $name, string $value): void
    {
        $this->data[$name] = [$value];
    }

}