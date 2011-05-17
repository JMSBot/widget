<?php
/**
 * Care
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
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2011-01-18 11:46:12
 */

class Crm_Customer_Care_Meta extends Com_Meta
{
    public function setMeta()
    {
        $this->setAdvancedMeta();
        $this->merge(array(
            'field' => array(
                'name' => array(
                    'attr' => array(
                        'isList' => 1,
                    ),
                ),
                'care_at' => array(
                    'attr' => array(
                        'isList' => 1,
                    ),
                    'form' => array(
                        '_widget' => array(
                            array(
                                array('Datepicker_Widget', 'render'),
                            ),
                        ),
                    ),
                ),
                'customer_id' => array(
                    'basic' => array(
                        'title' => 'LBL_MODULE_CUSTOMER',
                    ),
                    'form' => array(
                        '_widget' => array(
                            array(
                                array('PopupGrid_Widget', 'render'),
                                array(array(
                                    'title'  => 'LBL_MODULE_CUSTOMER',
                                    'module' => 'crm/customer',
                                    'list' => 'id,name,birthday,email,source',
                                    'fields' => array('name', 'id'),
                                )),
                            ),
                        ),
                    ),
                    'attr' => array(
                        'isList' => 1,
                        'isLink' => 1,
                    ),
                ),
                'contact_id' => array(
                    'basic' => array(
                        'title' => 'LBL_MODULE_CONTACT',
                    ),
                    'form' => array(
                        '_widget' => array(
                            array(
                                array('PopupGrid_Widget', 'render'),
                                array(array(
                                    'title'  => 'LBL_MODULE_CONTACT',
                                    'module' => 'crm/contact',
                                    'list' => 'id,full_name,birthday,email,source',
                                    'fields' => array('full_name', 'id'),
                                )),
                            ),
                        ),
                    ),
                ),
                'type' => array(
                    'form' => array(
                        '_type' => 'select',
                        '_resourceGetter' => array(
                            array('Ide_Option_Widget', 'get'),
                            'customer-care-type',
                        ),
                    ),
                    'sanitiser' => array(
                        'list' => array(
                            array('Ide_Option_Widget', 'sanitise'),
                            'customer-care-type',
                        ),
                        'view' => 'list',
                    ),
                    'attr' => array(
                        'isLink' => 1,
                        'isList' => 1,
                    ),
                ),
                'content' => array(
                    'basic' => array(
                        'layout' => 2,
                        'group' => 1,
                    ),
                    'form' => array(
                        '_type' => 'textarea',
                    ),
                ),
                'feedback' => array(
                    'basic' => array(
                        'layout' => 2,
                        'group' => 1,
                    ),
                    'form' => array(
                        '_type' => 'textarea',
                    ),
                ),
                'description' => array(
                    'basic' => array(
                        'layout' => 2,
                        'group' => 1,
                    ),
                    'form' => array(
                        '_type' => 'textarea',
                    ),
                ),
            ),
            'group' => array(
                1 => 'LBL_GROUP_DETAIL_DATA',
            ),
            'layout' => array(

            ),
            'model' => array(
                'customer' => array(
                    'module' => 'crm/customer',
                    'alias' => 'customer',
                    'type' => 'view',
                    'local' => 'customer_id',
                    'fieldMap' => array(
                        'customer_id' => 'name',
                    ),
                ),
            ),
            'db' => array(
                'table' => 'customer_care',
                'order' => array(
                    array('date_created', 'DESC')
                ),
                'defaultWhere' => array(
                    array('is_deleted', 0),
                ),
            ),
            'page' => array(
                'title' => 'LBL_MODULE_CUSTOMERCARE',
                'icon' => 'user',
                'tableLayout' => 1,
                'alias' => 'customer',
                'useTrash' => true,
                'mainField' => 'name',
            ),
        ));
    }

    public function sanitiseEditCustomerId($value, $name, $data, $dataCopy)
    {
        $data = Com_Meta::getQueryByModule('crm/customer')
            ->select('name')
            ->where('id = ?', $value)
            ->fetchOne();

        $this['field'][$name]['form']['_value2'] = $data['name'];
        return $value;
    }

    public function sanitiseEditContactId($value, $name, $data, $dataCopy)
    {
        $data = Com_Meta::getQueryByModule('crm/contact')
            ->select('last_name, first_name')
            ->where('id = ?', $value)
            ->fetchOne();

        $this['field'][$name]['form']['_value2'] = $data['last_name'] . $data['first_name'];
        return $value;
    }
}