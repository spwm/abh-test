<?php
/**
 * Подключаем файлы
 */
require_once "config.php";
require_once "inc/DB.php";

require_once "inc/Links.php";
require_once "inc/LinksController.php";

require_once "inc/User.php";
require_once "inc/UserController.php";

session_start();
/**
 * Ajax Запрос на создание ссылки
 */
if (isset($_POST['link']))
{
    $url = strip_tags($_POST['link']);
    $short_url = new LinksController();
    try
    {
        $code = $short_url->urlToShortCode($url);
        printf('<p><strong>Ваш короткий URL:</strong> <a href="%s">%2$s</a></p>', $code, BASE_URL.$code);
        exit;
    }
    catch(\Exception $e)
    {
        print_r($e->getMessage());
        exit;
    }

}


/**
 * 
 * 
 * Авторизация Админа
 * 
 */
if (isset($_POST['auth']))
{
 
    $user = new UserController();
    try
    {
        $user->auth($_POST['login'], $_POST['password']);      
        header('Location: admin');
        exit();
       
    }
    catch(\Exception $e)
    {
        $message = $e->getMessage();
        require_once "template/login.php";        
        exit;
    }
}

/**
 * 
 * 
 * Удаление
 * 
 */
if (isset($_GET['url']) and $_GET['url'] === 'admin' and isset($_GET['delete']))
{ 
    if($_SESSION['admin'])
    {
        try
        {
            $links = new LinksController();
            $links->deleteLinks($_GET['id']);       
        }
        catch(\Exception $e)
        {
           $message = $e->getMessage();
        }
    }
}

/**
 * 
 * 
 * Logout
 * 
 */
if (isset($_GET['logout']))
{ 
    $user = new UserController();
    $user->logout();
    header('Location: /');
    exit();
}

/**
 * 
 * Вход в админку
 * 
 */
if (isset($_GET['url']) and $_GET['url'] === 'admin')
{
 
    if($_SESSION['admin'])
    {
        require_once "template/admin.php";
        exit;
    }
    else
    {
        require_once "template/login.php";
        exit;
    }
}


/**
 * 
 * Редерикт если есть ссылка
 * 
 */
if(isset($_GET['url']) and !empty($_GET['url']))
{

    $url = new LinksController();
    $rederict = $url->getUrlbyShortUrl($_GET['url']);

    if($rederict){
        header('Location: '.$rederict);
        exit();
    }

}


require_once "template/user.php";


