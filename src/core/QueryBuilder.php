<?php

namespace Ordo;

class QueryBuilder
{
    const ALL_COLUMNS = '*';

    const TYPE_SELECT = 0;
    // const TYPE_INSERT = 1;
    const TYPE_UPDATE = 2;
    const TYPE_DELETE = 3;

    const TYPE_WHERE_NONE = -1;
    const TYPE_WHERE_AND = 0;
    const TYPE_WHERE_OR = 1;

    private string $query = '';
    private int $type = -1;
    private array $fromData = [];
    private array $deleteData = [];
    private array $updateData = [];
    private string $selectColumns = '';
    private array $parameters = [];
    private int $offset = 0;
    private int $limit = 100;
    private array $whereData = [];
    private array $joinData = [];
    private int $countJoins = 0;
    
    const JOIN_DEFAULT_COLUMN = 'id';

    public function select(string $columns) : self
    {
        $this->type = self::TYPE_SELECT;
        $this->selectColumns = $columns;

        return $this;
    }

    public function from(string $table, string $alias) : self
    {
        $this->fromData['table'] = $table;
        $this->fromData['alias'] = $alias;

        return $this;
    }

    public function join(string $table, string $alias = '', string $joinOn = self::JOIN_DEFAULT_COLUMN) : self
    {
        $i = $this->countJoins;
        $this->joinData[$i]['table'] = $table;
        $this->joinData[$i]['alias'] = $alias;
        $this->joinData[$i]['on'] = $joinOn;
        $this->countJoins++;

        return $this;
    }

    public function where(string $condition) : self
    {
        if(!empty($this->whereData))
        {
            throw new \Exception('whereData is set already'); die;
        }
        $this->_where($condition, self::TYPE_WHERE_NONE);
        return $this;
    }

    public function andWhere(string $condition) : self
    {
        $this->_where($condition, self::TYPE_WHERE_AND);
        return $this;
    }

    public function orWhere(string $condition) : self
    {
        $this->_where($condition, self::TYPE_WHERE_OR);
        return $this;
    }

    private function _where(string $condition, int $type) : self
    {
        $this->whereData[] = [
            'info' => $condition,
            'type' => $type,
        ];
        return $this;  
    }

    public function setParameter($parameter, $value) : self
    {
        $this->parameters[$parameter] = $value;
        return $this;
    }

    public function set($parameter) : self
    {
        $this->updateData['columns'][] = $parameter;
        return $this;
    }

    public function update(string $table, string $alias)
    {
        $this->updateData['table'] = $table;
        $this->updateData['alias'] = $alias;

        return $this;
    }

    public function delete(string $table, string $alias)
    {
        $this->type = self::TYPE_DELETE;

        $this->deleteData['table'] = $table;
        $this->deleteData['alias'] = $alias;

        return $this;    
    }

    public function getQuery()
    {
        //build querey heree
        switch($this->type)
        {
            case self::TYPE_SELECT:
                $this->buildSelect();
                break;
            case self::TYPE_UPDATE:
                $this->buildUpdate();
                break;
            case self::TYPE_DELETE:
                $this->buildDelete();
                break;
            default:
                die('error');
        }
        return $this->query;
    }

    private function buildSelect()
    {
        $this->query = "SELECT $this->selectColumns FROM " . $this->fromData['table'] . " " . $this->fromData['alias'] . " ";

        $this->buildJoins();
        $this->buildWhere();

        $this->query .= "LIMIT $this->limit OFFSET $this->offset";
        
    }

    private function buildJoins()
    {
        if(!empty($this->joinData))
        {
            foreach($this->joinData as $join)
            {
                $this->query .= 'JOIN ' . $join['table'] . ' ' . $join['alias'] . ' ON ' . $join['on'] . ' ';
            }
        }     
    }

    private function buildWhere()
    {
        $str_where = '';
        if(!empty($this->whereData))
        {
            // was used where(), so it's just one sentence
            if($this->whereData[0]['type'] == self::TYPE_WHERE_NONE)
            {
                $str_where = 'WHERE ' . $this->whereData[0]['info'] . ' ';
            }
            else
            {
                $str_where .= 'WHERE ';
                foreach($this->whereData as $where)
                {
                    $str_where .= $where['info'];
                    if($where['type'] == self::TYPE_WHERE_AND)
                        $str_where .= ' AND ';
                    else if($where['type'] == self::TYPE_WHERE_OR)
                        $str_where .= ' OR ';
                }

                $str_where = rtrim($str_where, ' AND OR '); // should test this line
            }

            $this->query .= $str_where;
        }   
    }

    // where t1.name = :name , t1.name = 'Name'

    //UPDATE table SET name = :name, age = :age WHERE id = :id
    private function buildUpdate()
    {
        $this->query = 'UPDATE ' . $this->updateData['table'] . ' SET ';
        foreach($this->updateData['columns'] as $column)
        {
            $this->query .= $column . ' = ' . ':' . $column . ', ';
        }

        $this->query = rtrim($this->query, ',');

        $this->buildWhere();
    }

    private function buildDelete()
    {
        $this->query = "DELETE {$this->deleteData['table']} {$this->deleteData['alias']} ";
        $this->buildWhere();
    }

    public function getResult()
    {
        //executes the query;
    }

    public function setFirstResult(int $offset)
    {
        $this->offset = $offset;
    }

    public function setMaxResult(int $limit)
    {
        $this->limit = $limit;
    }
}