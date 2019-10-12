<?php

class Links
{

   
    protected $db;

    protected $tableName = 'links';

    
    public function __construct()
    {
        $this->db = DB::getDBO();
    }

    /**
     * Добавление ссылки в базу
     * @param  [array] $data [description]
     * @return [int]     ID link  or false
     */
    public function create($data)
    {

        $sql = "INSERT INTO $this->tableName (url, hash) VALUES (:url, :hash)";

        $r = $this->execute($sql, $data);

        return ($r > 0) ? $this->getIdByHash($data) : false;

    }
    
    /**
     * Обновление ссылки, пока добавляем только короткую ссылку
     *
     * @param  [array] $data array('id' => ID, 'short_url' => short_url)
     * @return [type]       [description]
     */
    public function update($data)
    {
        $sql = "UPDATE $this->tableName SET short_url = :short_url WHERE id = :id";

        return $this->execute($sql, $data);
    }

    /**
     * Удаление ссылки
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
        $sql = "DELETE FROM $this->tableName WHERE id = :id";

        return $this->execute($sql, ['id' => $id]);
    }
    
    /**
     * Получение ID по хешу md5() ссылки
     * @param  [array] $data 
     * @return [int]   ID or false
     */
    public function getIdByHash($data)
    {
        $result = $this->getLinkByHash($data);

        return (isset($result['id'])) ? $result["id"] : false;
    }
    
    /**
     * Получение Кроткую ссылку по хешу md5() ссылки
     * @param  [array] $data 
     * @return [int]   short_url or false
     */
    public function getShortUrlByHash($data)
    {
        $result = $this->getLinkByHash($data);

        return (isset($result['id'])) ? $result["short_url"] : false;
    }

    /**
     * Получение Ссылку по хешу md5()
     * @param  [array] $data 
     * @return [int]   row link or false
     */
    public function getLinkByHash($data)
    {
        $r = $this
            ->db
            ->prepare("SELECT * FROM $this->tableName WHERE hash = :hash LIMIT 1");

        $r->execute(['hash' => $data['hash']]);
        $result = $r->fetch();

        return (isset($result['id'])) ? $result : false;
    }

    /**
     * Получение всех ссылок
     * 
     * @return [array] links
     */
    public function getAll()
    {
        return $this
            ->db
            ->query("SELECT * FROM $this->tableName")
            ->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Получение Ссылку по короткой ссылке
     * @param  [array] $data 
     * @return [int]  link or false
     */
    public function getLinkByShortUrl($data)
    {
        $r = $this
            ->db
            ->prepare("SELECT * FROM $this->tableName WHERE short_url = :short_url LIMIT 1");

        $r->execute($data);
        $result = $r->fetch();

        return (isset($result['id'])) ? $result['url'] : false;
    }
 
    /**
     * Update or Insert
     * @param  [type] $sql  [description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    private function execute($sql, $data)
    {
        try
        {
            return $this
                ->db
                ->prepare($sql)
                ->execute($data);
        }
        catch(PDOException $e)
        {
            throw new \Exception($e->getMessage());
        }
    }
}

