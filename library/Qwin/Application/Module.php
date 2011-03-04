<?php
 /**
 * Module
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
 * @subpackage  Application
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-04-17 15:50:02
 */

abstract class Qwin_Application_Module
{
    /**
     * 根据应用结构配置获取模块
     *
     * @param array $asc 应用结构配置
     * @return Qwin_Application_Module 模块对象
     */
    public static function getByAsc(array $asc, $instanced = true)
    {
        $class = $asc['namespace'] . '_' . $asc['module'] . '_Module';
        return $instanced ? Qwin::call($class) : null;
    }
}