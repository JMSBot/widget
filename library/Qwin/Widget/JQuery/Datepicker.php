<?php
/**
 * Datepicker
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
 * @subpackage  
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-08-20 17:21:33
 */

class Qwin_Widget_JQuery_Datepicker
{
    public function __construct()
    {
        
    }

    public function render($meta)
    {
        $jquery = Qwin::run('Qwin_Resource_JQuery');
        $buttonId = 'ui-button-ajaxupload-' . $meta['name'];

        $code = $jquery->loadUi('datepicker')
            . '<script type="text/javascript">
                jQuery("#' . $meta['id'] . '").datepicker({dateFormat: "yy-mm-dd"});
               </script>';

        return $code;
    }
}