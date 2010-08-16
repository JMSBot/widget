<?php
/**
 * JqGrid
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
 * @since       2010-08-14 11:27:56
 */

class Default_Common_View_JqGridJson extends Default_View
{
    public function display()
    {
        /**
         * 初始变量,方便调用
         */
        $primaryKey = $this->primaryKey;
        $request = Qwin::run('Qwin_Request');

        /**
         * 转换为jqGrid的行数据
         */
        $i = 0;
        $rowData = array();
        foreach($this->data as $key => $row)
        {
            $rowData[$i][$primaryKey] = $row[$primaryKey];
            foreach($this->listField as $field)
            {
                $rowData[$i]['cell'][] = $row[$field];
            }
            $i++;
        }

        /**
         * @todo 当前页数,行数等信息的获取
         */
        $nowPage = intval($request->g('page'));
        $nowPage <= 0 && $nowPage = 1;
        
        $rowNum = intval($request->g('row'));
        if($rowNum <= 0)
        {
            $rowNum = $this->meta['db']['limit'];
        // 最多同时读取500条记录
        } elseif($rowNum > 500) {
            $rowNum = 500;
        }

        /**
         * 输出json数据
         */
        $jsonData = array(
            'page' => $nowPage,
            // 总页面数
            'total' => ceil($this->count / $rowNum),
            'records' => $this->count,
            'rows' => $rowData,
        );
        echo Qwin::run('-arr')->jsonEncode($jsonData);
    }
}