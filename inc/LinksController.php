<?php

class LinksController
{

    /**
     * Строка с символами для формирования короткой ссылки
     * @var string
     */
    protected static $chars = "123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";

    /**
     * Флаг существования ссылки в бд
     * @var boolean
     */
    protected static $checkUrlExists = true;

    protected $links;

    public function __construct()
    {
        $this->links = new Links();
    }

    /**
     * Получение короткой ссылки
     * @param  [string] $url
     * @return [string]
     */
    public function urlToShortCode($url)
    {
        if (empty($url))
        {
            throw new \Exception("Введите  URL.");
        }

        //Прверям ссылку на соответсвие
        if ($this->validateUrlFormat($url) == false)
        {
            throw new \Exception("Не верный формат");
        }

        //Прверям ссылку на существование
        if ($this->checkURLExists($url) == false)
        {
            throw new \Exception("Ссылка не существует");
        }

        //Проверяем на существование в бд
        $shortCode = $this->urlExistsHash($url);
        if ($shortCode == false)
        {
            $shortCode = $this->createShortUrl($url);
        }

        return $shortCode;
    }

    /**
     * Провека ссылки на соответствие
     * @param  [string] $url
     * @return [bool]
     */
    public function getUrlbyShortUrl($url)
    {
        return $this
            ->links
            ->getLinkByShortUrl(['short_url' => $url ]);;
    }

    /**
     * Провека ссылки на соответствие
     * @param  [string] $url
     * @return [bool]
     */
    protected function validateUrlFormat($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED);
    }

    /**
     * Проверяем существует ли ссылка в бд
     * @param  [string] $url
     * @return [string]  short_url or false
     */
    protected function urlExistsHash($url)
    {
        return $this
            ->links
            ->getShortUrlByHash(['hash' => md5($url) ]);
    }

    /**
     * Создание короткой ссылки
     * @param  [string] $url
     * @return [string]   $shortCode or error
     */
    protected function createShortUrl($url)
    {
        $id = $this->insertUrlInDb($url);
        $shortCode = $this->generatorShortUrl($id);
        $this->insertShortCodeInDb($id, $shortCode);
        return $shortCode;
    }

    /**
     * Вставка ссылки в бд
     * @param  [string] $url
     * @return [int]   ID or false
     */
    protected function insertUrlInDb($url)
    {
        return $this
            ->links
            ->create(['url' => $url, 'hash' => md5($url) ]);
    }


    /**
     * Получение всех ссылок
     * @param  [string] $url
     * @return [int]   ID or false
     */
    public function getAllLinks()
    {
        return $this
            ->links
            ->getAll();
    }

     /**
     * Удаление ссылки
     * @param  [string] $url
     * @return [int]   ID or false
     */
    public function deleteLinks($id)
    {
        $id = intval($id);
        if ($id < 1)
        {
            throw new \Exception("ID должно быть числом");
        }

        return $this->links->delete($id);
    }

    /**
     * [generatorShortUrl description]
     * @param  [int] $id
     * @return short url or Exception
     */
    protected function generatorShortUrl($id)
    {
        $id = intval($id);
        if ($id < 1)
        {
            throw new \Exception("ID не является некорректным целым числом.");
        }

        $length = strlen(self::$chars);

        $code = "";
        while ($id > $length - 1)
        {
            // Определяем значение следующего символа
            // в коде и подготавливаем его
            $code = self::$chars[fmod($id, $length) ] . $code;
            // Сбрасываем $id до оставшегося значения для конвертации
            $id = floor($id / $length);
        }

        // Оставшееся значение $id меньше, чем
        // длина self::$chars
        $code = self::$chars[$id] . $code;

        return $code;
    }
 
    /**
     * Проверка на существование url
     * @param  string $url [description]
     * @return [type]      [description]
     */
    protected function checkURLExists($url = "")
    {
        if (empty($url)) return false;

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($http_code >= 200 && $http_code < 300) return true;
        return false;
    }

    /**
     * Вставляем короткую ссылку в бд
     * @param  [type] $id        [description]
     * @param  [type] $short_url [description]
     * @return [type]            [description]
     */
    protected function insertShortCodeInDb($id, $short_url)
    {
        return $this
            ->links
            ->update(['id' => $id, 'short_url' => $short_url]);
    }
}

