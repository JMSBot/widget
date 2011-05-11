<?php
/**
 * Padb
 *
 * Copyright (c) 2008-2010 Twin Huang. All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package     Qwin
 * @subpackage  Padb
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-09-24 13:01:41
 */

class Doctrine_Connection_Padb extends Doctrine_Connection_Common
{
    /**
     * @var string $driverName
     */
    protected $driverName = 'Padb';

    /**
     * Qwin_Padb_Connection连接对象
     * @var object
     */
    protected $_conn;

    /**
     * Qwin_Padb_Query查询对象
     * @var Qwin_Padb_Query
     */
    protected $_query;

    public function connect()
    {
        if ($this->isConnected) {
            return false;
        }

        $config = str_replace('\\', '/', $this->options['dsn']);

        $pos = strrpos($config, '/');
        $database = substr($config, $pos + 1);

        $rootPos = strrpos($config, '@');
        $root = substr($config, $rootPos + 1, $pos - strlen($config));

        $this->_conn = new Qwin_Padb_Connection($root);
        $this->_query = new Qwin_Padb_Query($this->_conn);
        $this->_query->selectDatabase($database);
        
        //$connected = parent::connect();
        $this->dbh = new Doctrine_Adapter_Padb();
        $this->isConnected = true;

        return $this->_conn->isConnect();
    }

    /**
     * 获取Padb查询对象
     *
     * @return objct Padb查询对象
     */
    public function getPadbQuery()
    {
        return $this->_query;
    }

    /**
     * 设置字符类型,Padb不支持字符类型
     *
     * @param string $charset 字符类型
     */
    public function setCharset($charset)
    {
        parent::setCharset($charset);
    }

    public function update(Doctrine_Table $table, array $fields, array $identifier)
    {
        if (empty($fields)) {
            return false;
        }

        $this->_query->update($table->getTableName());
        foreach($fields as $field => $value)
        {
            $this->_query->set($field, '?', $value);
        }
        foreach($identifier as $key => $value)
        {
            $this->_query->where($key . ' = ' . $value);
        }

        return $this->_query->execute();
    }

    public function insert(Doctrine_Table $table, array $fields)
    {
        $this->_query->insert($table->getTableName());
        foreach($fields as $field => $value)
        {
            $this->_query->value($field, $value);
        }
        return $this->_query->execute();
    }

    public function delete(Doctrine_Table $table, array $identifier)
    {
        $this->_query->delete($table->getTableName());
        foreach($identifier as $field => $value)
        {
            $this->_query->where($field .' = ' . $value);
        }
        return $this->_query->execute();
    }

    public function exec($query, array $params = array())
    {
        $this->connect();

        // 删除操作
        // 说明:Doctrine在删除操作中并未使用到connection类的delete方法,需在此进行判断
        if('DELETE' == substr($query, 0, 6))
        {
            $tables = $this->getTables();
            $table = $tables[key($tables)];
            $identifier = $table->getIdentifier();
            return $this->delete($table, array($identifier => $params[0]));
        }

        try {
            if ( ! empty($params)) {
                $stmt = $this->prepare($query);
                $stmt->execute($params);

                return $stmt->rowCount();
            } else {
                $event = new Doctrine_Event($this, Doctrine_Event::CONN_EXEC, $query, $params);

                $this->getAttribute(Doctrine_Core::ATTR_LISTENER)->preExec($event);
                if ( ! $event->skipOperation) {
                    $count = $this->dbh->exec($query);

                    $this->_count++;
                }
                $this->getAttribute(Doctrine_Core::ATTR_LISTENER)->postExec($event);

                return $count;
            }
        } catch (Doctrine_Adapter_Exception $e) {
        } catch (PDOException $e) { }

        $this->rethrowException($e, $this, $query);
    }
}