<?php
/**
 * Qwin Framework
 *
 * Copyright (c) 2008-2011 Twin Huang. All rights reserved.
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
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 */

/**
 * Form
 * 
 * @namespace   Qwin
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @author      Twin Huang <twinh@yahoo.cn>
 * @since       2011-05-11 00:31:52
 */
class Qwin_Form extends Qwin_Widget
{
    /**
     * @var array               域默认选项,以下划线开头为私有属性,否则为Html属性
     * 
     *      -- _label           表单标题名称,如果为空,使用表单名称代替
     * 
     *      -- _type            表单类型,和Html属性type相对应
     * 
     *      -- _resource        表单资源,当表单类型为select,checkbox,raido时,其子项
     *                          通过资源数组来表示
     * 
     *      -- _resourceGetter  表单资源回调结构
     * 
     *      -- _value           表单的初始值
     * 
     *      -- name             表单名称
     * 
     *      -- id               表单唯一编号
     * 
     *      -- class            表单类名称
     * 
     *      -- _widgets         表单微件流程回调结构
     * 
     *      -- _readonly        值为真时,不可编辑,对添加,查看无影响
     * 
     *      -- _view            值为假时,在视图页不显示
     * 
     * @todo 整理注释
     */
    protected $_fieldDefaults = array(
        '_type'     => 'text',
        '_resource' => null,
        '_value'    => '',
        'name'      => null,
        //'_label' => null,
        //'id' => null,
        //'class' => null,
        //'_widgets' => array(),
        //'_readonly' => false,
        //'_sanitiser' => array(),
        //_resourceGetter = null, 
    );
    
    /**
     * 关联选项
     * 
     * @var array 
     * @todo 条件查询 criteria
     * @todo 排序查询 order
     * @todo 显示的类型
     *       1. field name
     *       2. format field name
     *       3. callback
     */
    protected $_relationDefaults = array(
        'module'    => null,
        'alias'     => null,
        'db'        => 'db',
        'field'     => 'id',
        'display'   => 'id',
        'criteria'  => array(),
        'order'     => array(),
        'loaded'    => false,
    );
    
    /**
     * @var array               域组默认配置
     * 
     *      -- _open            是否打开
     * 
     *      -- _show            是否显示
     */
    protected $_fieldsetDefaults = array(
        '_open' => true,
        '_show' => true,
    );
    
    /**
     * 默认选项
     * @var array
     */
    public $options = array(
        'fields' => array(),
        'fieldsets' => array(),
        'layout' => array(),
        'hidden' => array(),
        'topButtons' => false,
        'columns' => 1,
    );

    /**
     * 将数据格式化并加入
     *
     * @param array $data 数据
     * @param array $options 选项
     * @return Qwin_Meta_Model 当前对象
     */
    public function merge($data, array $options = array())
    {
        // 初始化结构,保证数据完整性
        $data = (array)$data + $this->_defaults;
        !is_array($data['fields']) && $data['fields'] = (array)$data['fields'];
        
        // 处理通配选项
        if (array_key_exists('*', $data['fields'])) {
            $this->_fieldDefaults = $this->_fieldDefaults + (array)$data['fields']['*'];
            unset($data['fields']['*']);
        }
        
        foreach ($data['fields'] as $name => &$field) {
            // TODO 能否可选
            !isset($field['name']) && $field['name'] = $name;
            !isset($field['id']) && $field['id'] = $name;
            if (isset($field['_relation'])) {
                $field['_relation'] = (array)$field['_relation'] + $this->_relationDefaults;
            }
            $field = (array)$field + $this->_fieldDefaults;
        }
        $this->exchangeArray($data);
        return $this;

//        // 初始验证器和补全验证信息
//        if(isset($data['validator']) && !empty($data['validator']['rule'])) {
//            foreach ($data['validator']['rule'] as $key => $rule) {
//                if (!isset($data['validator']['message'][$key])) {
//                    $data['validator']['message'][$key] = 'VLD_' . strtoupper($key);
//                }
//            }
//        }
    }
    
    
//    public function getResource($field)
//    {
//        if (isset($this[$field])) {
//            if ($this[$field]['form']['_resource']) {
//                return $this[$field]['form']['_resource'];
//            } else {
//                if (isset($this[$field]['form']['_resourceGetter'])) {
//                    $resource = Qwin::call('-flow')->callOne($this[$field]['form']['_resourceGetter']);
//                } else {
//                    return array();
//                }
//
//                // 认定为选项模块的选项
//                $element = $resource[key($resource)];
//                if (is_array($element)) {
//                    $this[$field]['form']['_resource'] = $resource;
//                } else {
//                    // 否则,认定为value=>name的形式
//                    $return = array();
//                    foreach($resource as $value => $name) {
//                        $return[$value] = array(
//                            'value' => $value,
//                            'name' => $name,
//                            'color' => null,
//                            'style' => null,
//                        );
//                    }
//                    $this[$field]['form']['_resource'] = $return;
//                }
//
//                return $this[$field]['form']['_resource'];
//            }
//        }
//        throw new Qwin_Meta_Field_Exception('Undefined field "' . $field . '"');
//    }
    
    public function call($name = null, $module = null)
    {
        if (!$module) {
            $module = $this->module();
        }
        $class = $module->toClass() . '_' . ucfirst($name) . 'Form';
        return $this->qwin($class);
    }
    
    public function render()
    {
        echo 'render form';
        return $this;
    }
}