<?php
/**
 * Controller
 *
 * AciionController is controller with some default action,such as index,list,
 * add,edit,delete,view and so on.
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
 * @package     Trex
 * @subpackage  Controller
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-7-28 15:19:18
 */

class Trex_Controller extends Qwin_Trex_Controller
{
    /**
     * 初始化各类和数据
     */
    public function __construct()
    {
        $ini = Qwin::run('-ini');
        $this->_request = Qwin::run('Qwin_Request');
        $this->_url = Qwin::run('Qwin_Url');
        $set = $this->_set = $ini->getSet();
        $this->_config = $ini->getConfig();
        $this->_member = Qwin::run('Qwin_Session')->get('member');
       
        /**
         * 访问控制
         */
        $this->_isAllowVisited();

        /**
         * 加载语言,同时将该命名空间下的通用模块语言类加入到当前模块的语言类下
         */
        $languageName = $this->getLanguage();
        $commonLanguageName = $set['namespace'] . '_Common_Language_' . $languageName;
        $languageName = $set['namespace'] . '_' . $set['module'] . '_Language_' . $languageName;
        $this->_lang = Qwin::run($languageName);
        if(null == $this->_lang)
        {
            $languageName = 'Trex_Language';
            $this->_lang = Qwin::run($languageName);
        }
        $this->_commonLang = Qwin::run($commonLanguageName);
        if(null != $this->_commonLang)
        {
            $this->_lang->merge($this->_commonLang);
        }
        Qwin::addMap('-lang', $languageName);

        /**
         * 加载元数据
         */
        $metadataName = $ini->getClassName('Metadata', $set);
        if(class_exists($metadataName))
        {
            $this->_meta = Qwin_Metadata_Manager::get($metadataName);
        } else {
            $metadataName = 'Trex_Metadata';
            $this->_meta = Qwin::run($metadataName);
        }
        Qwin::addMap('-meta', $metadataName);

        /**
         * 加载模型
         */
        $modelName = $ini->getClassName('Model', $set);
        $this->_model = Qwin::run($modelName);
        if(null == $this->_model)
        {
            $modelName = 'Qwin_Trex_Model';
            $this->_model = Qwin::run($modelName);
        }
        Qwin::addMap('-model', $modelName);
    }

    /**
     * 是否有权限浏览该页面
     *
     * @return boolen
     */
    private function _isAllowVisited()
    {
        // 除了登陆页面之外,其他页面都得设置访问权限
        $allowSet = array(
            array(
                'namespace' => 'Trex',
                'module' => 'Member',
                'controller' => 'Log',
                'action' => 'Login',
            ),
            array(
                'namespace' => 'Trex',
                'module' => 'Trex',
                'controller' => 'Captcha',
                'action' => 'Index',
            ),
        );

        if(!in_array($this->_set, $allowSet))
        {
            if(null == Qwin::run('-ses')->get('member'))
            {
                $url = Qwin::run('-url');
                $url->to($url->createUrl(array(
                    'module' => 'Member',
                    'controller' => 'Log',
                    'action' => 'Login',
                )));
            }
        }
        return true;
    }

    public function setRedirectView($message, $method = null)
    {
        $this->_view['class'] = 'Trex_Common_View_Redirect';
        $this->_view['data']['message'] = $message;
        $this->_view['data']['method'] = $method;
        return $this;
    }
}
