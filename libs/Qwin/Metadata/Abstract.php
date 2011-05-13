<?php
/**
 * Access
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
 * @subpackage  Metadata
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-07-27 15:41:46
 */

abstract class Qwin_Metadata_Abstract extends ArrayObject
{
    /**
     * 管理类
     *
     * @var Qwin_Metadata
     */
    protected $_manager = null;

    /**
     * 初始化类
     *
     * @param array $input 数据
     */
    public function  __construct($input = array())
    {
        parent::__construct($input, self::ARRAY_AS_PROPS);
    }

    /**
     * 设置基本元数据,初始化时调用该方法
     *
     * @return Qwin_Metadata_Abstract 当前对象
     */
    public function setMetadata()
    {
        return $this;
    }

    /**
     * 获取管理器对象
     *
     * @return Qwin_Metadata
     */
    public function getManager()
    {
        return $this->_manager;
    }

    /**
     * 设置管理器
     *
     * @param Qwin_Metadata $metadata 管理器对象
     * @return Qwin_Metadata_Abstract 当前对象
     */
    public function setManager(Qwin_Metadata $metadata)
    {
        $this->_manager = $metadata;
        return $this;
    }

    /**
     * 获取元数据的数组形式(仅获取至第二层)
     *
     * @return 数组
     */
    public function toArray()
    {
        $array = $this->getArrayCopy();
        foreach ($array as $name => $element) {
            if (is_subclass_of($element, 'ArrayObject')) {
                $array[$name] = $element->getArrayCopy();
            }
        }
        return $array;
    }

    /**
     * 将数组加入元数据中
     *
     * @param array $data 数组
     * @return Qwin_Metadata_Abstract 当前对象
     */
    public function fromArray(array $data)
    {
        $this->exchangeArray(array_merge($this->getArrayCopy(), $data));
        return $this;
    }

    /**
     * 合并/附加元数据
     * 
     * @param string $index 键名
     * @param array $data 数据
     * @return QwiQwin_Metadata_Abstract 当前对象
     */
    public function merge($index, $data)
    {
        if (!$this->offsetExists($index)) {
            return $this->set($index, $data);
        }
        $this[$index]->merge($data);
        return $this;
    }
    
    /**
     * 设置元数据的值
     * 
     * @param string $index 键名
     * @param array $data 数据
     * @param string $driver 驱动标识
     * @todo 驱动标识支持多种类型,如类名,对象
     */
    public function set($index, $data = null, $driver = null)
    {
        $meta = Qwin_Metadata::getInstance();
        
        // 获取驱动类名 $driver > $index > default
        if (isset($driver)) {
            $class = $meta->getDriver($driver);
            if (!$class) {
                throw new Qwin_Metadata_Exception(sprintf('Metadata driver "%s" not found.', $driver));
            }
        } else {
            $class = $meta->getDriver($index);
            if (!$class) {
                $class = $meta->getDefaultDriver();
            }
        }
        
        // 不存在该键名,直接设置值
        if (!$this->offsetExists($index)) {
            $this[$index] = new $class;
            $this[$index]->setParent($this);
            $this[$index]->merge($data);
        } else {
            // 元数据该键名的值不是对象
//            if (!is_object($this[$index])) {
//                $data = $data + $this[$index];
//                $this[$index] = new $class;
//                $this[$index]->merge($data);
//            } else {
                // 类名一样,直接设置值
                if ($class == get_class($this[$index])) {
                    $this[$index]->merge($data);
                // 类名不一样,取出原始数据重新设置
                } else {
                    $data = $data + $this[$index]->getArrayCopy();
                    $this[$index] = new $class;
                    $this[$index]->setParent($this);
                    $this[$index]->merge($data);
                }
//            }
        }

        return $this;
    }

    /**
     * 获取元数据唯一编号
     *
     * @return string 编号
     */
    public function getId()
    {
        if (!isset($this->_id)) {
            // 如果存在数据库名称,以数据库名称为唯一编号
            if (isset($this['db']) && isset($this['db']['table'])) {
                $this->_id = $this['db']['table'];
            } else {
                $this->_id = strtolower(get_class($this));
            }
        }
        return $this->_id;
    }

    /**
     * 设置元数据唯一编号
     *
     * @param string $id 编号
     * @return Qwin_Metadata_Abstract 当前对象
     */
    public function setId($id)
    {
        $this->_id = (string)$id;
        return $this;
    }
}
