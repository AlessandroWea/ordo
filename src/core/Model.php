<?php

namespace Ordo;

use Ordo\Db;

class Model extends Db
{
    static protected string $tableName = 'unknown_table';
    static protected array $enabledCols = [];

    public function filter_cols(array $data) : array
    {
        foreach ($data as $key => $value) {
            if(!in_array($key, static::$enabledCols))
            {
                unset($data[$key]);
            }
        }

        return $data;
    }

    public function findAll()
    {
        $sql = 'SELECT * FROM ' . static::$tableName;
        $ret = $this->query($sql);

        return $ret->fetchAll();
    }

    public function where(array $arr = [])
    {
        $sql = 'SELECT * FROM ' . static::$tableName . ' where ';
        $keys = array_keys($arr);
        foreach($keys as $key)
        {
            $sql .= "$key = :$key AND ";
        }

        $sql = trim($sql, ' AND');
        $ret = $this->query($sql, $arr);
        return $ret->fetchAll();
    }

    public function first(array $arr = [])
    {
        $sql = 'SELECT * FROM ' . static::$tableName . ' where ';
        $keys = array_keys($arr);
        foreach($keys as $key)
        {
            $sql .= "$key = :$key AND ";
        }

        $sql = trim($sql, ' AND');
        $ret = $this->query($sql, $arr);
        return $ret->fetch();
    }

    public function add($arr)
    {
        $arr = $this->filter_cols($arr);
        $keys = array_keys($arr);

        $cols = implode(',', $keys);
        $vals = ':' . implode(',:', $keys);
        $sql = 'INSERT INTO ' . static::$tableName . ' (' . $cols . ') VALUES (' . $vals . ')';
        $ret = $this->query($sql, $arr);
        return Db::$db->lastinsertid();
        
    }

    public function update($id, $arr)
    {
        //UPDATE users SET last_name = :last_name WHERE id = 4
        $cols = '';
        foreach($arr as $key => $value)
        {
            $cols .= $key . '=:' . $key . ',';
        }
        $cols = trim($cols, ',');

        $sql = 'UPDATE ' . static::$tableName . ' SET ' . $cols . ' WHERE id=:id';
        $arr['id'] = $id;
        $ret = $this->query($sql, $arr);

        return $ret;
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM ' . static::$tableName . ' WHERE id=:id';
        $ret = $this->query($sql, ['id'=>$id]);

        return $ret;
    }
}