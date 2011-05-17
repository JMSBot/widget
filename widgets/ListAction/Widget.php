<?php
/**
 * Index
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
 * @package     Widget
 * @subpackage  ListAction
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-10-10 14:16:45
 */

class ListAction_Widget extends Qwin_Widget_Abstract
{
    /**
     * @var array           默认选项
     * 
     *      -- list         列表元数据
     * 
     *      -- get          用户请求的参数,默认为$_GET数组
     * 
     *      -- layout       布局
     * 
     *      -- row          每页显示数目
     * 
     *      -- popup        是否是弹出框
     * 
     *      -- display      是否显示视图
     */
    protected $_defaults = array(
        'list'      => null,
        'get'       => null,
        'layout'    => array(),
        'row'       => 10,
        'popup'     => false,
        'display'   => true,
    );

    /**
     * 服务处理
     *
     * @param array $options 选项
     * @return array 处理结果
     */
    public function render($options = null)
    {
        // 初始配置
        $options    = (array)$options + $this->_options;
        
        /* @var $listMeta Qwin_Meta_List */
        $list = $options['list'];

        // 检查列表元数据是否合法
        if (!is_object($list) || !$list instanceof Qwin_Meta_List) {
            $this->e('ERR_META_ILLEGAL');
        }
        $meta = $list->getParent();
 
        // 显示哪些域
        $layout = $options['layout'];
        
        // 用户请求参数
        $get = $options['get'] ? $options['get'] : $_GET;
        
        // 主键名称
        $id = $meta['db']['id'];
        
        // 是否以弹出框形式显示
        $popup = $options['popup'];

        // 不显示视图，直接返回数据
        if (!$options['display']) {
            return array(
                'result' => true,
                'data' => get_defined_vars(),
            );
        }
        
        /* @var $jqGridWidget JqGrid_Widget */
        $jqGridWidget = $this->_widget->get('JqGrid');
        $url = Qwin::call('-url');
        
        // jqGrid选项
        $options['row'] = intval($options['row']);
        $jqGridOptions = array(
            'list' => $list,
            'url' => $url->build(array('json' => true) + $get),
            'rowNum' => $options['row'] > 0 ? $options['row'] : $list['db']['limit'],
            'layout' => $layout,
        );

        // 设置弹出窗口属性
        if ($options['popup']) {
            $request        = Qwin::call('-request');
            $popup = array(
                'valueInput'    => $request['popup-value-input'],
                'viewInput'     => $request['popup-view-input'],
                'valueColumn'   => $request['popup-value-column'],
                'viewColumn'    => $request['popup-view-column'],
            );
            $jqGridOptions['multiselect']  = false;
            $jqGridOptions['autowidth']    = false;
            $jqGridOptions['width']        = 800;
        }
        
        Qwin::call('-view')->assign(get_defined_vars());
    }
}