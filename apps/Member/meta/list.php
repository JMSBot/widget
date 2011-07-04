<?php
/**
 * list
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
 * @since       2011-04-27 15:35:49
 */

return array(
    'fields' => array(
        'id' => array(
            'link' => false,
            'hidden' => true,
        ),
        'group_id' => array(
            'link' => true,
//            'sanitiser' => array(
//                array('Com_Category_Widget', 'sanitise'),
//                array(
//                    'com/member/group',
//                    null,
//                    array('id', null, 'name'),
//                ),
//            ),
        ),
        'sex' => array(
            'link' => true,
            '_sanitiser' => array(
                'list' => array(
                    array('Ide_Option_Widget', 'sanitise'),
                    'sex',
                ),
            ),
        ),
    ),
    'layout' => array(
        'id', 'group_id', 'username', 'email', 'sex', 'date_modified', 'operation',
    ),
);