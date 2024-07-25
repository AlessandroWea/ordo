<?php

namespace Ordo\Database;

class EntityRepository
{
    private string|null $model = null;
    protected QueryBuilder $queryBuilder;
    protected string|null $tableName = null;
    protected int $limit = 1000;
    protected int $offset = 0;

    public function __construct(string $model)
    {
        $this->queryBuilder = new QueryBuilder();
        $this->model = $model; //   'app\models\User'

        $ref = new \ReflectionClass($this->model);
        $tableAttr = $ref->getAttributes('Ordo\Database\Mapping\Table');
        if($tableAttr){
            $this->tableName = $tableAttr[0]->getArguments()['name'];
        }
        else {
            $this->tableName = @end(explode('\\', $this->model));
        }
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function setLimit(int $limit)
    {
        $this->limit = $limit;
    }

    public function setOffset(int $offset)
    {
        $this->offset = $offset;
    }

    public function findAll()
    {
        $sql = 'SELECT * FROM ' . $this->tableName . ' limit ' . $this->limit . ' offset ' . $this->offset;
        dd($sql);
        // $ret = $this->query($sql);

        // return $ret->fetchAll();
    }

    public function where(array $arr = [])
    {
        $sql = 'SELECT * FROM ' . $this->tableName . ' where ';
        $keys = array_keys($arr);
        foreach($keys as $key)
        {
            $sql .= "$key = :$key AND ";
        }

        $sql = trim($sql, ' AND');
        $sql .= ' limit ' . $this->limit . ' offset ' . $this->offset;

        $ret = $this->query($sql, $arr);
        return $ret->fetchAll();
    }

    public function whereOr(array $arr = [])
    {
        $sql = 'SELECT * FROM ' . $this->tableName . ' where ';
        $keys = array_keys($arr);
        foreach($keys as $key)
        {
            $sql .= "$key = :$key OR ";
        }

        $sql = trim($sql, ' OR');
        $sql .= ' limit ' . $this->limit . ' offset ' . $this->offset;

        $ret = $this->query($sql, $arr);
        return $ret->fetchAll();
    }

    public function first(array $arr = [])
    {
        $sql = 'SELECT * FROM ' . $this->tableName . ' where ';
        $keys = array_keys($arr);
        foreach($keys as $key)
        {
            $sql .= "$key = :$key AND ";
        }

        $sql = trim($sql, ' AND');
        $sql .= ' limit ' . $this->limit . ' offset ' . $this->offset;
        $ret = $this->query($sql, $arr);
        return $ret->fetch();
    }

    public function add($arr)
    {
        $arr = $this->filter_cols($arr);
        $keys = array_keys($arr);

        $cols = implode(',', $keys);
        $vals = ':' . implode(',:', $keys);
        $sql = 'INSERT INTO ' . $this->tableName . ' (' . $cols . ') VALUES (' . $vals . ')';
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

        $sql = 'UPDATE ' . $this->tableName . ' SET ' . $cols . ' WHERE id=:id';
        $arr['id'] = $id;
        $ret = $this->query($sql, $arr);

        return $ret;
    }

    public function updateWhere($where, $arr)
    {
        //UPDATE users SET last_name = :last_name WHERE id = 4 ANt name='ss'
        $cols = '';
        foreach($arr as $key => $value)
        {
            $cols .= $key . '=:' . $key . ',';
        }
        $cols = trim($cols, ',');

        $whereStr = '';
        foreach($where as $key => $value)
        {
            $whereStr .= $key . '=:' . $key . ' AND ';
        }
        $whereStr = rtrim($whereStr, ' AND ');

        $sql = 'UPDATE ' . $this->tableName . ' SET ' . $cols . ' WHERE ' . $whereStr;

        $args = array_merge($arr, $where);
        $ret = $this->query($sql, $args);

        return $args;
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM ' . $this->tableName . ' WHERE id=:id';
        $ret = $this->query($sql, ['id'=>$id]);

        return $ret;
    }

    public function deleteBy($col, $val)
    {
        $sql = 'DELETE FROM ' . $this->tableName . " WHERE $col = :$col";
        $ret = $this->query($sql, [$col=>$val]);

        return $ret;
    }

    public function deleteWhere($arr)
    {
        $sql = 'DELETE FROM ' . $this->tableName . " WHERE ";
        $keys = array_keys($arr);
        foreach($keys as $key)
        {
            $sql .= " $key = :$key AND";
        }

        $sql = rtrim($sql, ' AND');
        $ret = $this->query($sql, $arr);

        return $ret->rowCount();
    }

    public function search($fields, $search)
    {
        $sql = 'SELECT * FROM ' . $this->tableName . ' WHERE ';
        $search = '%' . $search . '%';
        $str = '';
        foreach($fields as $field)
        {
            $str .= $field . ' LIKE :search OR ';
        }
        $str = trim($str, ' OR ');
        $sql .= $str;
        $sql .= ' LIMIT ' . $this->limit . ' OFFSET ' . $this->offset;
        $ret = $this->query($sql, ['search' => $search]);
        return $ret->fetchAll();
    }
}