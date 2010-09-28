<?php
/**
 * Clip
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
 * @subpackage  Clip
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-06-02
 */

class Trex_Clip_Controller_Clip extends Trex_ActionController
{
    public function actionEdit()
    {
        
        parent::actionEdit();
    }

    public function onAfterDb()
    {
        $query = $this->_meta->getDoctrineQuery($this->_set);
        $data = $query->execute()->toArray();
        $cache = array();
        foreach($data as $row)
        {
            $cache[$row['name']] = $row['value'];
        }
        Qwin::run('Qwin_Cache_List')->writeCache($cache, 'clip');
    }

    public function convertEditValue($value, $name, $data, $copyData)
    {
        $this->relatedField->set('value.form._type', $copyData['form_type']);
        // TODO
        if('CKEditor' == $copyData['form_widget'])
        {
            $this->relatedField->set('value.form._widgetDetail', array(
                array(
                    array('Qwin_Widget_Editor_CKEditor', 'render'),
                ),
            ));
        }
        return $value;
    }
}