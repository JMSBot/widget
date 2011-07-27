<?php
/**
 * form
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
 * @since       2011-7-11 14:41:04
 */

return array(
    'fields' => array(
        'id' => array(
            
        ),
        'category_id' => array(
            '_type' => 'select',
            '_relation' => array(
                'module' => 'member/menu',
                'alias' => 'menu',
                'display' => 'title',
            ),
        ),
        'title' => array(
            
        ),
        'url' => array(
            
        ),
        'target' => array(
            '_value' => '_self',
        ),
        'order' => array(
            '_value' => 50,
        ),
    ),
    'hidden' => array(
        'id',
    ),
    'layout' => array(
        'GRP_BASIC' => array(
            array('category_id'),
            array('title'),
            array('url'),
            array('target'),
            array('order'),
        ),
    ),
);