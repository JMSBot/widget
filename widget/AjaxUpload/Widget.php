<?php
/**
 * widget
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
 * @since       2011-02-27 14:50:27
 */

class AjaxUpload_Widget extends Qwin_Widget_Abstract
{
    public function render($meta)
    {
        $jquery = Qwin::call('Qwin_Resource_JQuery');
        $cssPacker = Qwin::call('Qwin_Packer_Css');
        $jsPacker = Qwin::call('Qwin_Packer_Js');

        $positionFile = $jquery->loadUi('position', false);
        $dialogFile = $jquery->loadUi('dialog', false);
        $ajaxUploadFile = $jquery->loadPlugin('ajaxupload', null, false);
        $cssPacker
            ->add($positionFile['css'])
            ->add($dialogFile['css'])
            ->add($ajaxUploadFile['css']);
        $jsPacker
            ->add($positionFile['js'])
            ->add($dialogFile['js'])
            ->add($ajaxUploadFile['js']);

        $buttonId = 'ui-button-ajaxupload-' . $meta['id'];

        $code = '<button id="' . $buttonId . '" type="button"><span class="ui-icon ui-icon-arrowthickstop-1-n">' . $meta['id'] . '</span></button>
                <script type="text/javascript">jQuery(function($){
                    $("#' . $buttonId . '").ajaxUpload({
                        input : "#' . $meta['id'] . '"
                    });
                });
              </script>';
        return $code;
    }
}