<?php

namespace Ordo;

use Exception;
use Ordo\Db;

class Model extends Db
{
    static protected string $tableName = 'unknown_table';
    static protected array $enabledCols = [];
    public array $validationErrors = [];

    /**
     * Holds validation rules for your columns
     *
     * @var array
     * 
     * Available options:
     *  - NotBlank
     *  - Blank
     *  - NotNull
     *  - Regex
     *  - IsTrue
     *  - IsFalse
     *  - Numeric
     *  - Email
     *  - unique
     *  - EqualTo
     *  - NotEqualTo
     *  - IdenticalTo
     *  - NotIdenticalTo
     *  - LessThan
     *  - LessThanOrEqual
     *  - GreaterThan
     *  - GreaterThanOrEqual
     *  - Range
     *  - Positive
     *  - PositiveOrZero
     *  - Negative
     *  - NegativeOrZero
     *  - Choice
     */
    protected array $validationRules = [
        'email' => [
            'NotBlank',
            'Email',
        ],
        'username' => [
            'Alpha',
            'Regex' => [
                'pattern' => '[a-zA-Z0-9 ]+',
                'match' => true,
                'message' => 'Your username should only contain letters, numbers and spaces',
            ],
            'Length' => [
                'min' => 2,
                'max' => 50,
                'minMessage' => 'Your first name must be at least {{ limit }} characters long',
                'maxMessage' => 'Your first name cannot be longer than {{ limit }} characters',
            ],
            'Age' => [
                'EqualTo' => [
                    'value' => 18,
                    'message' => '{{ value }} should be {{ compared_value }} and of type {{ compared_value_type }}',
                ]
            ]
        ]
    ];

    public function validate($data)
    {
        $this->validationErrors = [];
        
        if(!empty($this->validationRules))
        {
            $columns = array_keys($this->validationRules);
            foreach($columns as $column){
                $value = $data[$column] ?? null;
                $rules = array_keys($this->validationRules[$column]);
                $stop  = false;
                foreach($rules as $rule)
                {
                    if($stop) break;

                    if(is_numeric($rule))
                        $validatorClassName = 'Ordo\\Validators\\' .$this->validationRules[$column][$rule] . 'Validator';
                    else
                        $validatorClassName = 'Ordo\\Validators\\' .$rule . 'Validator';

                    if(class_exists($validatorClassName))
                    {
                        if(is_array($this->validationRules[$column][$rule]))
                        {
                            $validatorObject = new $validatorClassName($this->validationRules[$column][$rule]);
                        }
                        else
                        {
                            $validatorObject = new $validatorClassName();
                        }

                        if(method_exists($validatorObject, 'run'))
                        {
                            if(!$validatorObject->run($value))
                            {
                                $this->validationErrors[$column] = $validatorObject->message;
                                $stop = true;
                            }
                        }
                        else
                            throw new Exception('Method RUN is not implemented');
                    }
                    else
                        dd('Class doesnot exists: ' . $validatorClassName);
                }
            }
        }

        return true;
    }

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