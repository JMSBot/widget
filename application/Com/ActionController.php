<?php
/**
 * ActionController
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
 * @package     Com
 * @subpackage  ActionController
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-08-26 15:31:26
 */

class Com_ActionController extends Com_Controller
{
    /**
     * 控制器默认首页,Common命名空间的默认首页是数据列表
     *
     * @return array 服务处理结果
     */
    public function actionIndex()
    {
        $request = $this->getRequest();
        if ($request->isJson()) {
            return Com_Widget::getByModule('Com', 'JsonList')->process(array(
                'module'=> $this->_module,
                'list'  => $request->getListField(),
                'order' => $request->getOrder(),
                'where' => $request->getWhere(),
                'offset'=> $request->getOffset(),
                'limit' => $request->getLimit(),
            ));
        } else {
            return Com_Widget::getByModule('Com', 'List')->process(array(
                'module'=> $this->_module,
                'list'  => $request->getListField(),
                'popup' => $request['popup'],
            ));
        }
    }

    /**
     * 查看一条记录
     *
     * @return array 服务处理结果
     */
    public function actionView()
    {
        return Com_Widget::getByModule('Com', 'View')->process(array(
            'module'    => $this->_module,
            'id'        => $this->_request->getPrimaryKeyValue($this->_module),
        ));
    }

    /**
     * 添加记录
     *
     * @return array 服务处理结果
     */
    public function actionAdd()
    {
        if (!$this->_request->isPost()) {
            return Com_Widget::getByModule('Com', 'Form')->process(array(
                'module'    => $this->_module,
                'id'        => $this->_request->getPrimaryKeyValue($this->_module),
                'initalData'=> $this->_request->getInitialData(),
            ));
        } else {
            return Com_Widget::getByModule('Com', 'Add')->process(array(
                'module'    => $this->_module,
                'data'      => $_POST,
                'url'       => urldecode($this->_request->post('_page')),
            ));
        }
    }

    /**
     * 编辑记录
     *
     * @return array 服务处理结果
     */
    public function actionEdit()
    {
        if (!$this->_request->isPost()) {
            return Com_Widget::getByModule('Com', 'View')->process(array(
                'module'    => $this->_module,
                'id'        => $this->_request->getPrimaryKeyValue($this->_module),
                'asAction'  => 'edit',
                'isView'    => false,
                'viewClass' => 'Com_View_Edit',
            ));
        } else {
            return Com_Widget::getByModule('Com', 'Edit')->process(array(
                'module'    => $this->_module,
                'data'      => $_POST,
                'url'       => urldecode($this->_request->post('_page')),
            ));
        }
    }

    /**
     * 删除记录
     *
     * @return array 服务处理结果
     */
    public function actionDelete()
    {
        return Com_Widget::getByModule('Com', 'Delete')->process(array(
            'module'    => $this->_module,
            'data'      => array(
                'primaryKeyValue' => $this->_request->getPrimaryKeyValue($this->_module),
            ),
        ));
    }
}