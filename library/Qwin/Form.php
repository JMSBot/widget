<?php
/**
 * 表单
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
 * @subpackage  Form
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2009-11-24 20:45:11
 * @todo        添加,修改,删除类,扩展类
 */

class Qwin_Form
{
    // 表单基本类型的扩展类集合
    private $_class = array();
    // 表单基本类型 的扩展 的扩展类的集合
    private $_extClass = array();
    // 表单的扩展属性,作为html代码的属性
    private $_publicSet = array();
    // 表单的私有属性,作为php的配置属性
    private $_privateSet = array();
    // 表单的值
    private $_value;
    
    
    /**
     * 根据配置生成表单
     */
    public function auto(&$set, $initData = null)
    {
        $data = '';
        // 初始化数据
        $this->_init($set, $initData);
        $data = $this->_callType();
        $data = $this->_callExtType($data);
        return $data;
    }
    
    /**
     * 增加扩展类,不检查类是否存在,类的检查在  _callType 中
     * 
     * @param string $className 类名
     */
    public function add($className)
    {
        $this->_class[$className] = $className;
        return $this;
    }
    
    /**
     * 增加表单扩展的 扩展类,不检查类是否存在,类的检查在  _callExtType 中
     */
    public function addExt($className)
    {
        $this->_extClass[$className] = $className;
        return $this;
    }
    
    /**
     * 执行对应的表单类型方法
     */
    private function _callType()
    {
        $data = '';
        // TODO 名称标准化
        $type = str_replace('_', '', $this->_privateSet['_type']);
        foreach($this->_class as $val)
        {
            if(method_exists(qw($val), $type))
            {
                $data = call_user_func_array(
                    array(qw($val), $type), 
                    array($this->_publicSet, $this->_privateSet, $this->_value)
                );
            }
        }
        return $data;
    }
    
    /**
     * 执行对应的表单类型的扩展 的方法
     *
     * @todo 缓存类中的方法,多对多对应
     */
    private function _callExtType($data)
    {
        if(!isset($this->_privateSet['_typeExt']))
        {
            return $data;
        }
        $type_arr = qw('-arr')->decodeArray($this->_privateSet['_typeExt']);
        foreach($type_arr as $method => $set)
        {
            $method = str_replace('_', '', $method);
            foreach($this->_extClass as $class)
            {
                $class = Qwin::run($class);
                if(method_exists($class, $method))
                {
                    return call_user_func_array(
                        array($class, $method),
                        array($this->_publicSet, $this->_privateSet, $this->_value, $data)
                    );
                }
            }
        }
        return $data;
    }
    
    /**
     * 转换, 初始化数据
     *
     *
     */
    private function _init($set, $initData = null)
    {
        // 置空
        $this->_privateSet = array();
        $this->_publicSet = array();

        // 转换表单资源
        if(isset($set['_resourceGetter']))
        {
            $set['_resource'] = Qwin::callByArray($set['_resourceGetter']);
        }

        // 获取初始值
        if(!isset($initData[$set['name']]))
        {
            $this->_value = $set['_value'];
        } else {
            $this->_value = $initData[$set['name']];
        }
        
        // 获取id
        if(!isset($set['id']))
        {
            $set['id'] = preg_replace("/(\w*)\[(\w+)\]/", "$1-$2", $set['name']);
        }
        
        foreach($set as $key => $val)
        {
            if(substr($key, 0, 1) == '_')
            {
                $this->_privateSet[$key] = $val;
            } else {
                $this->_publicSet[$key] = $val;
            }
        }
    }
    
    /**
     * 将数组转换为 html 标签的属性
     *
     * @param array $set 属性配置
     * @return string html
     */
    protected function _getAttr($set)
    {
        $attr = '';
        foreach($set as $key => $val)
        {
            $attr .= $key . '="' . $val . '" ';
        }
        return $attr;
    }
}