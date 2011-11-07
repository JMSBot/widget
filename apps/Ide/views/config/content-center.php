<?php
/**
 * center
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
 * @package     Qwin
 * @subpackage
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-12-10 00:37:30
 */
?>
<div class="ui-form ui-box ui-widget ui-widget-content ui-corner-all" id="ui-form">
    <div class="ui-box-header">
            <?php Qwin::hook('ViewContentHeader', $this) ?>
        </div>
    <form action="" method="post">
        <div class="ui-operation-field">
        </div>
        <div class="ui-form-content ui-box-content ui-widget-content">
            <table class="ui-table ui-widget-content ui-corner-all" cellpadding="0" cellspacing="0">
            <tr class="ui-widget-content">
                <td class="ui-state-default" width="20%"><?php echo qw_lang('FLD_TITLE') ?></td>
                <td class="ui-state-default"><?php echo qw_lang('FLD_DESCRIPTION') ?></td>
                <td class="ui-state-default" width="10%"><?php echo qw_lang('FLD_OPERATION') ?></td>
            </tr>
            <?php
            foreach($data as $row):
            ?>
            <tr class="ui-widget-content">
                <td class="ui-state-default"><?php echo $row['title'] ?></td>
                <td><?php echo $row['description'] ?></td>
                <td><?php echo Qwin_Util_JQuery::icon($url->url('ide/config', 'render', array('groupId' => $row['form_name'])), $lang->t('ACT_EDIT'), 'ui-icon-tag') ?></td>
            </tr>
            <?php
            endforeach;
            ?>
        </table>
        </div>
    </form>
</div>