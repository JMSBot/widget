<?php
/**
 * Language
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
 * @subpackage  Management
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-09-20 15:51:17
 */

class Trex_Management_Controller_Language extends Trex_Controller
{
    public function actionIndex()
    {
        $class1 = $this->_request->g('class1');
        $class2 = $this->_request->g('class2');

        $object1 = Qwin::run($class1);
        if(!is_subclass_of($object1, 'Trex_Language'))
        {
            exit('类1不是语言类');
        }
        $object2 = Qwin::run($class2);
        if(!is_subclass_of($object2, 'Trex_Language'))
        {
            exit('类2不是语言类');
        }

        $data1 = $object1->toArray();
        $data2 = $object2->toArray();

        foreach($data1 as $key => $value)
        {
            if(!isset($data2[$key]))
            {
                $data2[$key] = $data1[$key];
            }
        }

        $arr = Qwin::run('-arr');
        p($arr->toPhpCode($data2));
    }
}