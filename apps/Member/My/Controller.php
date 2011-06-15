<?php
/**
 * Controller
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
 * @since       2011-04-05 06:14:49
 */

class Com_Member_My_Controller extends Com_Controller
{
    /**
     * 锁定的核心帐号，防止恶意修改
     * @var array
     */
    protected $_lock = array(
        'guest', 'admin', '7641b5b1-c727-6c07-e11f-9cb5b74ddfc9',
    );
    
    public function  __construct($config = array(), $module = null, $action = null) {
        parent::__construct($config, $module, $action);
        $this->_memberModule = new Qwin_Module('com/member');
    }

    public function actionIndex()
    {
        $meta = $this->getMeta();
        $this->getView()->assign(get_defined_vars());
    }

    public function actionEdit()
    {
        $member = $this->getMember();
        if (!$this->_request->isPost()) {
            return Qwin::call('-widget')->get('View')->execute(array(
                'module'    => $this->_memberModule,
                'id'        => $member['id'],
                'asAction'  => 'edit',
                'isView'    => false,
                'viewClass' => 'Com_View_Edit',
            ));
        } else {
            return Qwin::call('-widget')->get('Add')->execute(array(
                'module'    => $this->_memberModule,
                'data'      => array('id' => $member['id']) + $_POST,
                'url'       => urldecode($this->_request->post('_page')),
            ));
        }
    }

    public function actionView()
    {
        $member = $this->getMember();
        return Qwin::call('-widget')->get('View')->execute(array(
                'module'    => $this->_memberModule,
                'id'        => $member['id'],
            ));
    }

    public function actionEditPassword()
    {
        $request = $this->_request;
        $member = $this->getMember();
        $id = $member['id'];
        if (in_array($id, $this->_lock)) {
            $lang = Qwin::call('-lang');
            return $this->getView()->alert($lang->t('MSG_MEMBER_LOCKED'));
        }
        $meta = Qwin_Meta::getInstance()->get('Com_Member_PasswordMeta');

        if (!$request->isPost()) {
            return Qwin::call('-widget')->get('View')->execute(array(
                'module'    => $this->_memberModule,
                'meta'      => $meta,
                'id'        => $id,
                'asAction'  => 'edit',
                'isView'    => false,
            ));
        } else {
            return Com_Widget::getByModule('com/member', 'editPassword')->execute(array(
                'data'      => array('id' => $id) + $_POST,
            ));
        }
    }

    public function actionStyle()
    {
        if (!$this->_request->isPost()) {
            $style = Qwin::call('-widget')->get('Style');

            $styles = $style->getStyles();
            $path = $style->getSourcePath();
            $meta = $this->getMeta();
            
            $this->getView()->assign(get_defined_vars());
        } else {
            $session = $this->getSession();
            $member = $session->get('member');
            $style = $session->get('style');
            
            $result = Com_Meta::getQueryByModule($this->_memberModule)
                ->update()
                ->set('theme', '?', $style)
                ->where('id = ?', $member['id'])
                ->execute();

            $url = $this->getUrl()->url($this->_module->toUrl(), 'index');
            $this->getView()->success(Qwin::call('-lang')->t('MSG_SUCCEEDED'), $url);
        } 
    }

    public function actionLanguage()
    {
        if (!$this->_request->isPost()) {
            $meta = $this->getMeta();
            $urlLanguage = $this->_request->get('lang');

            $this->getView()->assign(get_defined_vars());
        } else {
            $session = $this->getSession();
            $member = $session->get('member');
            $lang = $session->get('lang');

            $result = Com_Meta::getQueryByModule($this->_memberModule)
                ->update()
                ->set('language', '?', $lang)
                ->where('id = ?', $member['id'])
                ->execute();

            $url = $this->getUrl()->url($this->_module->toUrl(), 'index');
            $this->getView()->success(Qwin::call('-lang')->t('MSG_SUCCEEDED'), $url);
        }
    }
}