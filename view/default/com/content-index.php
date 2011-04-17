<?php
/**
 * 列表页
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
 * @subpackage  View
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2009-11-24 18:47:32
 */
echo $this->getPackerSign();
if ($request->isAjax()) :
?>
<style type="text/css">
#t_ui-jqgrid-table{
    display : none;
}
.ui-jqgrid{
    padding: 0;
}
</style>
<?php require $this->decodePath('<root>com/basic/jqgird<suffix>') ?>
<?php
else :
?>
<div class="ui-form ui-box ui-widget ui-widget-content ui-corner-all" id="ui-form">
	<div class="ui-box-header">
    	<?php Qwin::hook('ViewContentHeader', $this) ?>
    </div>
    <div class="ui-form-content ui-box-content ui-widget-content">
        <div class="ui-operation-field">
        <?php require $this->decodePath('<root>com/basic/jqgird<suffix>') ?>
        </div>
    </div>
</div>
<?php
endif;
?>