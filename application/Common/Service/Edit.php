<?php
/**
 * Update
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
 * @package     Common
 * @subpackage  Service
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-10-11 11:55:35
 */

class Common_Service_Edit extends Common_Service
{
    /**
     * 服务的基本配置
     * @var array
     */
    protected $_option = array(
        'asc'       => array(
            'namespace'     => null,
            'module'        => null,
            'controller'    => null,
            'action'        => null,
        ),
        'data'      => array(),
        'display'   => true,
        'url'       => null,
    );

    public function process(array $option = null)
    {
        // 初始配置
        $option     = array_merge($this->_option, $option);
        
        /* @var $app Qwin_Application */
        $app        = Qwin::call('-app');
        
        /* @var $meta Common_Metadata */
        $meta       = Common_Metadata::getByAsc($option['asc']);
        $primaryKey = $meta['db']['primaryKey'];
        $primaryKeyValue = isset($option['data'][$primaryKey]) ? $option['data'][$primaryKey] : null;

        // 从模型获取数据
        $query = $meta->getQuery(null, array('type' => array('db', 'view')));
        $dbData = $query->where($primaryKey . ' = ?', $primaryKeyValue)->fetchOne();

        // 记录不存在,加载错误视图
        if (false == $dbData) {
            $lang = Qwin::call('-lang');
            $result = array(
                'result' => false,
                'message' => $lang['MSG_NO_RECORD'],
            );
            if ($option['display']) {
                return Qwin::call('-view')->alert($result['message']);
            } else {
                return $result;
            }
        }

        // 获取改动过的数据
        $data = $this->_filterData($meta, $dbData, $option['data']);

        // 转换数据
        $data = $meta->sanitise($data, 'db');

        // 加载验证微件,验证数据
        $validator = Qwin::widget('validator');
        if (!$validator->valid($data, $meta)) {
            $result = array(
                'result' => false,
                'message' => $validator->getInvalidMessage(),
            );
            if ($option['display']) {
                return Qwin::call('-view')->alert($result['message']);
            } else {
                return $result;
            }
        }

        // 填充并保存数据
        $dbData->fromArray($data);
        $dbData->save();

        // 展示视图
        if ($option['display']) {
            if (!$option['url']) {
                $option['url'] = Qwin::call('-url')->url($option['asc'], array('action' => 'Index'));
            }
            return Qwin::call('-view')->success('MSG_OPERATE_SUCCESSFULLY', $option['url']);
        }
        return array(
            'result' => true,
            'data' => get_defined_vars(),
        );
    }

    /**
     * 取出编辑数据,即改动过的,需要更新的数据
     *
     * @param Qwin_Metadata_Abstract 元数据对象
     * @param array $data 从数据库取出的数据
     * @param array $post 用户提交的数据
     * @return array
     */
    protected function _filterData($meta, $data, $post)
    {
        $result = array();
        foreach ($meta['field'] as $name => $field) {
            if (
                isset($post[$name])
                && $post[$name] != $data[$name]
                && 1 != $field['attr']['isReadonly']
            ) {
                $result[$name] = $post[$name];
            }
        }
        return $result;
    }
}