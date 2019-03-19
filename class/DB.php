<?php
/**
 * Created by PhpStorm.
 * User: nmabe
 * Date: 11/6/2018
 * Time: 5:25 PM
 */

class DB
{
    private static $_instance;
    private $_pdo,
        $_count,
        $_error = false,
        $_query,
        $_result;

    private function __construct()
    {
        try {
            $this->_pdo = new PDO(Config::get('mysql/dsn') . 'dbname=' . Config::get('mysql/database') . ';',
                Config::get('mysql/username'), Config::get('mysql/password'));
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return (self::$_instance);
    }

    public function query($sql, $params = array())
    {
        $this->_error = false;
        if ($this->_query = $this->_pdo->prepare($sql))
        {
            $i = 1;
            if (count($params))
            {
                foreach ($params as $param)
                {
                    $this->_query->bindValue($i, $param);
                    $i++;
                }
            }
            if ($this->_query->execute())
            {
                $this->_result = $this->_query->fetchAll(5);
                $this->_count = $this->_query->rowCount();
            }
            else {
                die( 'Error '. $this->_query->errorInfo()[2] .'<br>');
                $this->_error = true;
            }
        }
        return ($this);
    }

    public function action($action, $table, $where = array())
    {
        if (count($where) == 3)
        {
            $operators = array('=', '<', '>', '<=', '>=', '<>', '!=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if (in_array($operator, $operators))
            {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                if (!$this->query($sql, array($value))->error())
                {
                    return ($this);
                }
            }
        }
        return (false);
    }

    public function update($table, $id, $fields = array(), $key = NULL)
    {
        $set = '';
        $i = 1;
        foreach ($fields as $name => $value)
        {
            $set .= $name.' = ?';
            if ($i < count($fields))
            {
                $set .= ', ';
            }
            $i++;
        }
        if($key)
        {
            $sql = "UPDATE {$table} SET {$set} WHERE {$key} = {$id}";
        }else{
            $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
        }
        if (!$this->query($sql, $fields)->error())
        {
            return (true);
        }
        return (false);
    }

    public function insert($table, $fields = array()){
		if (count($fields)) {
			$keys = array_keys($fields);
			$i = 1;
			$values = '';
			foreach ($fields as $field) {
				$values .= '?';
				if ($i < count($fields)) {
					$values .= ', ';
				}
				$i++;
			}
			$sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) ."`) VALUES ({$values})";
			if (!$this->query($sql, $fields)->error()) {
				return (true);
			}
		}
		return (false);
    }
    
    public function get($table, $where)
    {
        return ($this->action('SELECT *', $table, $where));
    }

    public function delete($table, $where)
    {
        return ($this->action('DELETE',$table, $where));
    }

    public function result()
    {
        return ($this->_result);
    }

    public function error()
    {
        return ($this->_error);
    }

    public function first()
    {
        return($this->result()[0]);
    }

    public function count()
    {
        return($this->_count);
    }
}