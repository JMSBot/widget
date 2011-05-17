<?php
/**
 * Company
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
 * @since       2011-01-05 00:08:51
 */

class Crm_Company_Meta_Company extends Com_Meta
{
    public function setMeta()
    {
        $this->setCommonMeta();
        $this->merge(array(
            'field' => array(
                'customer_id' => array(
                    'basic' => array(
                        'title' => 'FLD_MEMBER_NAME',
                    ),
                    'form' => array(
                        '_type' => 'text',
                        '_widget' => array(
                            array(
                                array('PopupGrid_Widget', 'render'),
                                array(array(
                                    'title'  => 'LBL_MODULE_MEMBER',
                                    'module' => 'com/member',
                                    'list' => 'id,group_id,username,email',
                                    'fields' => array('username', 'id'),
                                )),
                            ),
                        ),
                    ),
                    'attr' => array(
                        'isLink' => 1,
                    ),
                    'validator' => array(
                        'rule' => array(
                            'required' => true,
                            'notNull' => true,
                        ),
                    ),
                ),
                'name' => array(
                    'basic' => array(
                        'group' => 2,
                    ),
                    'validator' => array(
                        'rule' => array(
                            'required' => true,
                        )
                    ),
                ),
                'industry' => array(
                    'basic' => array(
                        'group' => 2,
                    ),
                    'form' => array(
                        '_type' => 'select',
                        '_resourceGetter' => array(
                            array('Ide_Option_Widget', 'get'),
                            'company-industry',
                        ),
                    ),
                    'sanitiser' => array(
                        'list' => array(
                            array('Ide_Option_Widget', 'sanitise'),
                            'company-industry',
                        ),
                        'view' => 'list',
                    ),
                    'validator' => array(
                        'rule' => array(
                            'required' => true,
                        )
                    ),
                ),
                'nature' => array(
                    'basic' => array(
                        'group' => 2,
                    ),
                    'form' => array(
                        '_type' => 'select',
                        '_resourceGetter' => array(
                            array('Ide_Option_Widget', 'get'),
                            'company-nature',
                        ),
                    ),
                    'sanitiser' => array(
                        'list' => array(
                            array('Ide_Option_Widget', 'sanitise'),
                            'company-nature',
                        ),
                        'view' => 'list'
                    ),
                    'validator' => array(
                        'rule' => array(
                            'required' => true,
                        )
                    ),
                ),
                'size' => array(
                    'basic' => array(
                        'group' => 2,
                    ),
                    'form' => array(
                        '_type' => 'select',
                        '_resourceGetter' => array(
                            array('Ide_Option_Widget', 'get'),
                            'company-size',
                        ),
                    ),
                    'sanitiser' => array(
                        'list' => array(
                            array('Ide_Option_Widget', 'sanitise'),
                            'company-size',
                        ),
                        'view' => array(
                            array('Ide_Option_Widget', 'sanitise'),
                            'company-size',
                        )
                    ),
                    'validator' => array(
                        'rule' => array(
                            'required' => true,
                        )
                    ),
                ),
                'contacter' => array(
                    'basic' => array(
                        'group' => 2,
                    ),
                ),
                'phone' => array(
                    'basic' => array(
                        'group' => 2,
                    ),
                ),
                'email' => array(
                    'basic' => array(
                        'group' => 2,
                    ),
                ),
                'address' => array(
                    'basic' => array(
                        'group' => 2,
                    ),
                    'validator' => array(
                        'rule' => array(
                            'required' => true,
                        )
                    ),
                ),
                'description' => array(
                    'basic' => array(
                        'group' => 2,
                    ),
                    'form' => array(
                        '_type' => 'textarea',
                    ),
                    'attr' => array(
                        'isList' => 0
                    ),
                ),
            ),
            'group' => array(),
            'model' => array(
                'member' => array(
                    'alias' => 'member',
                    'local' => 'member_id',
                    'foreign' => 'id',
                    'type' => 'view',
                    'fieldMap' => array(
                        'member_id' => 'username',
                    ),
                    'asc' => array(
                        'package' => 'Common',
                        'module' => 'Member',
                        'controller' => 'Member',
                    ),
                ),
            ),
            'db' => array(
                'table' => 'company',
                'order' => array(
                    array('date_created', 'DESC'),
                ),
            ),
            'page' => array(
                'title' => 'LBL_MODULE_COMPANY',
            ),
        ));
    }
}