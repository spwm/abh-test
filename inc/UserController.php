<?php 


/**
* 
*/
class UserController
{
	protected $user; 


	public function __construct()
	{
		$this->user = new User();
	}
 
    /**
     * Авторизация Админа
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
	public function auth($login = '', $pass = '')
	{
		if(empty($login))
		{
			throw new \Exception("Укажите логин");
		}

		if(empty($pass))
		{
			throw new \Exception("Укажите пароль");
		}

		//Очишаем данные формы
        $login = $this->clearFormInput($login);
        $pass  = md5($this->clearFormInput($pass));

      	if($this->user->getIdByLoginAndPassword(['login' => $login, 'pass' => $pass]))
		{
			$_SESSION['admin'] = $login;
			return true;
		}
        
        throw new \Exception("Пользователь не найден");


	}


	/**
     * Logout
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
	public function logout()
	{
		unset($_SESSION['admin']);
        session_destroy();
	}

    /**
     * Очистка данных формы.
     * @param  string $value [description]
     * @return [type]        [description]
     */
	protected function clearFormInput($value='')
	{
		$value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);

        return $value;
	}
}