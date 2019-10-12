<?php  



/**
* 
*/
class User
{

	protected $db;

    protected $tableName = 'users';
	
	public function __construct()
	{
		$this->db = DB::getDBO();
	}


	/**
     * Получение Id по логину и паролю
     * @param  [array] $data 
     * @return [int]   row link or false
     */
    public function getIdByLoginAndPassword($data)
    {
        $r = $this
            ->db
            ->prepare("SELECT * FROM $this->tableName WHERE login = :login AND pass = :pass LIMIT 1");

        $r->execute($data);
        $result = $r->fetch();

        return (isset($result['id'])) ? $result['id'] : false;
    }
}