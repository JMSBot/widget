<?php
/**
 * Enus
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
 * @subpackage  Email
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-09-20 10:37:51
 */

class Common_Email_Language_Enus extends Common_Language_Enus
{
    public function  __construct()
    {
        parent::__construct();
        $this->_data += array(
            'LBL_FIELD_FROM' => 'From',
            'LBL_FIELD_FROM_NAME' => 'From Name',
            'LBL_FIELD_TO' => 'To',
            'LBL_FIELD_TO_NAME' => 'To Name',
            'LBL_FIELD_SUBJECT' => 'Subject',
            'LBL_FIELD_RESULT' => 'Result',

            'LBL_ACTION_POST' => 'Post',

            'LBL_MODULE_EMAIL' => 'Email',
        );
    }
}