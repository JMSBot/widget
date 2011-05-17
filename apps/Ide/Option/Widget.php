<?php
/**
 * Option
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
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2011-01-20 14:38:02
 */

class Ide_Option_Widget extends Qwin_Widget_Abstract
{
    /**
     * 语言名称,应该以标准形式出现
     * @var string
     */
    protected $_lang;

    /**
     * 数据缓存
     * @var array
     */
    protected $_data;

    /**
     * 选项模块的查询对象
     *
     * @var Doctrine_Query
     */
    protected $_query;

    /**
     * 选项
     * @var array
     */
    protected $_options = array(
        'cachePath' => null,
    );

    /**
     * 附加选项
     *
     * @var array   附加选项数组
     *
     *      -- 0    无，用于表单或显示
     *
     *      -- 1    请选择(相当于空)，用于表单
     *
     *      -- 2    <em>(未填写)</em>，用于显示
     * @todo 加入$options中，允许自由配置
     */
    protected $_defaultAddition = array(
        0 => array(
            'value' => '0',
            'name'  => 'LBL_NO',
            'color' => null,
            'style' => null,
        ),
//        1 => array(
//            'value' => 'NULL',
//            'name'  => 'LBL_PLEASE_SELECT',
//            'color' => null,
//            'style' => null,
//        ),
//        2 => array(
//            'value' => null,
//            'name'  => 'LBL_NOT_FILLED',
//            'color' => null,
//            'style' => null,
//        ),
    );

    public function  __construct(array $options = null)
    {
        if (!is_dir($options['cachePath'])) {
            throw new Qwin_Exception('The option path is not found.');
        }
        // 初始化路径
        $this->_path = $options['cachePath'];

        $lang = Qwin::call('-lang');
        // 初始化附加选项
        $this->_lang = $lang->getName();
        foreach ($this->_defaultAddition as &$row) {
            $row['name'] = $lang[$row['name']];
        }
    }

    /**
     * 获取选项数组
     *
     * @param string $name 标识名称
     * @param mixed $addition 附加选项
     * @param string $lang 语言名称
     * @return array
     */
    public function get($name, $addition = 1, $lang = null)
    {
        // 获取缓存数据
        null == $lang && $lang = $this->_lang;
        !isset($this->_data[$lang]) && $this->_data[$lang] = array();
        $file = $this->_path . '/' . $lang . '/' . $name . '.php';
        if (is_file($file)) {
            $this->_data[$lang][$name] = require $file;
        } else {
            $this->_data[$lang][$name] = $this->setCacheBySign($name, $lang);
        }
        $data = $this->_data[$lang][$name];

        // 附加选项
        /*if (null !== $addition) {
            if (!is_array($addition) && isset($this->_defaultAddition[$addition])) {
                $data = array(
                    $this->_defaultAddition[$addition]['value'] => $this->_defaultAddition[$addition]
                ) + $data;
            } elseif (is_array($addition)) {
                array_unshift($data, $addition);
            }
        }*/

        return $data;
    }
    
    /**
     * 根据标识设置缓存数据
     *
     * @param string $sign 标识名称
     * @param string $lang 语言名称
     * @return array
     */
    public function setCacheBySign($sign, $lang = null)
    {
        null == $lang && $lang = $this->_lang;
        $result = $this
            ->getQuery()
            ->where('sign = ?', $sign)
            ->andWhere('language = ?', $lang)
            ->fetchOne();
        if (false != $result) {
            $data = @unserialize($result['code']);
            $path = $this->_path . '/' . $lang . '/' . $sign . '.php';
            Qwin_Util_File::writeArray($path, $data);
            return $data;
        }
        return array();
    }

    /**
     * 根据数据库数据设置缓存
     *
     * @param array $data
     */
    public function setCache($data)
    {
        $code = @unserialize($data['code']);
        $path = $this->_path . '/' . $data['language'] . '/' . $data['sign'] . '.php';
        Qwin_Util_File::writeArray($path, $code);
    }

    /**
     * 根据编号设置缓存
     * 
     * @param string $id 编号
     */
    public function setCacheById($id)
    {
        $result = $this
            ->getQuery()
            ->where('id = ?', $id)
            ->fetchOne();
        $this->setCache($result);
    }

    /**
     * 获取选项模块的查询对象
     *
     * @return Doctrine_Query
     */
    public function getQuery()
    {
        if (isset($this->_query)) {
            return $this->_query;
        }
        $this->_query = Com_Meta::getQueryByModule('ide/option');
        return $this->_query;
    }

    public function sanitise($value, $name, $addition = 2)
    {
        $data = $this->get($name, $addition);
        if (isset($data[$value])) {
            // 附加颜色到样式中
            null != $data[$value]['color'] && $data[$value]['style'] = 'color:' . $data[$value]['color'] . ';' . $data[$value]['style'];
            if (null == $data[$value]['style']) {
                return $data[$value]['name'];
            } else {
                return '<span style="' . $data[$value]['style'] . '">' . $data[$value]['name'] . '</span>';
            }
        }
        return $value;
    }
    
    public function delete($data)
    {
        foreach($data as $row) {
            $cachePath = QWIN_PATH . '/class/' . $row['language'] . '/' . $row['sign'] . '.php';
            if(is_file($cachePath)) {
                unlink($cachePath);
            }
        }
    }
}