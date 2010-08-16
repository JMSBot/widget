<?php
/**
 * JqGrid
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
 * @subpackage  
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-08-14 15:32:17
 */

class Default_Common_View_JqGrid extends Default_View
{
    public function display()
    {
        /**
         * 初始变量,方便调用
         */
        $primaryKey = $this->primaryKey;
        $meta = $this->meta;

        /**
         * 数据转换
         */
        // 获取json数据的链接
        $urlGet = $_GET;
        $urlGet['action'] = 'List';
        $jsonUrl = '?' . Qwin::run('-url')->arrayKey2Url($urlGet);

        // 获取栏数据
        $columnName = array();
        $columnSetting = array();
        foreach($this->listField as $field)
        {
            $columnName[] = $meta['field'][$field]['basic']['title'];
            $columnSetting[] = array(
                'name' => $field,
                'index' => $field,
            );
            if($primaryKey == $field)
            {
                $columnSetting[count($columnSetting) - 1]['hidden'] = true;
            }
        }

        // 排序
        if(isset($meta['db']['order']) && !empty($meta['db']['order']))
        {
            $sortName = $meta['db']['order'][0][0];
            $sortOrder = $meta['db']['order'][0][1];
        } else {
            $sortName = $primaryKey;
            $sortOrder = 'DESC';
        }

        require_once $this->_layout;
    }
}