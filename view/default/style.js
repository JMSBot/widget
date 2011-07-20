/**
 * qwin
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
 * @since       2010-01-20 03:20:19
 */

jQuery.noConflict();

var qwin = {
    get: {},
    app: {},
    lang: {},
    page: {},
    ajax: {}
};

qwin.urlSeparator = {
    0: '&',
    1: '='
};
qwin.url = {
    createUrl : function(array1, array2)
    {
        // TODO: 合并数组1和2
        if ('undefined' != typeof(array2)) {
            for(var i in array2) {
                array1[i] = array2[i];
            }
        }
        return '?' + this.arrayKey2Url(array1);
    },
    arrayKey2Url : function(arr) {
        var url = '';
        for (var i in arr) {
            url += this.array2Url(arr[i], i) + qwin.urlSeparator[0];
        }
        return url.slice(0, -1);
    },
    array2Url : function(arr, name)
    {
        var url = '';
        if ('object' == typeof(arr)) {
            for (var key in arr) {
                if ('object' == typeof(arr[key])) {
                    url += this.array2Url(arr[key], name + '[' + key + ']') + qwin.urlSeparator[0];
                } else if(name) {
                    url += name + '[' + key + ']' + qwin.urlSeparator[1] + arr[key] + qwin.urlSeparator[0];

                } else {
                    url += name + qwin.urlSeparator[1] + arr[key] + qwin.urlSeparator[0];
                }
            }
        } else {
            return name + qwin.urlSeparator[1] + arr;
        }
        return url.slice(0, -1);
    }
};
function qw_l(name)
{
    if ('undefined' != typeof(qwin.Lang[name])) {
        return qwin.Lang[name];
    }
    return name;
}
function qw_f(name)
{
    return qw_l('FLD_' + name.toUpperCase());
}
jQuery(function($){
    qwin.page = {
        left: $('#qw-left'),
        right: $('#qw-right'),
        content: $('#qw-content'),
        middle: $('#qw-middle'),
        splitter: $('#qw-content > td.qw-splitter'),
        fixContentHeight: function(){
            if (!document.getElementById('qw-content-table')) {
               return false;
            }
            var height = $(window).height() - $('#qw-content-table').offset().top;
            $('#qw-content-table').css('height', height);
            return true;
        }
    };
    
    // 设置全局Ajax提示信息
    qwin.ajax.show = function(msg){
        $('#qw-ajax').html(msg).css({
            left: ($(window).width() - $('#qw-ajax').width()) / 2
        }).fadeIn(200).fadeOut(2000);
    }
    $.ajax({
        beforeSend: function(){
            //qwin.ajax.show(qwin.lang.MSG_START_REQUEST);
        },
        error: function(){
            qwin.ajax.show(qwin.lang.MSG_ERROR);
        },
        success: function(){
            //qwin.ajax.show(qwin.lang.MSG_SUCCEEDED);
        }
    });

    // 调整中间栏到最大高度
    // 修复360极速浏览器(6.0Chrome内核)高度不正确的问题
    $(window).load(function() {
        qwin.page.fixContentHeight();
    }).resize(function(){
        qwin.page.fixContentHeight();
    });

    // 点击分割栏缩进
    qwin.page.splitter.qui().click(function(){
        var id = $(this).attr('id');
        $('#qw-' + id.substring(id.lastIndexOf('-') + 1, id.length)).toggle(0, function(){
            qwin.page.splitter.trigger('toggle');
        });
    });
    
    // 为表单增加样式和鼠标操作效果
    $('button:not(.ui-button-none), input:submit, input:reset, input:button, a.ui-anchor').button();
    $('td.qw-field-radio, td.qw-field-checkbox').buttonset();
    $('button.ui-button, a.ui-button').qui({
        click: true,
        focus: true
    });
    $('table.qw-form-table input:text, table.qw-form-table textarea, table.qw-form-table input:password').qui();

    // 点击页脚下按钮,回到顶部
    $('#qw-footer-arrow').click(function(){
        $('html').animate({scrollTop:0}, 700);
        return false;
    });
    
    $('table.ui-table tr').not('.ui-table-header').qui();
    $('table.ui-table td.ui-state-default').qui();
    $('table.ui-table td a.ui-jqgrid-icon').qui();

    //
    /*if ($.browser.mozilla) {
        function fixSelectStyle(obj) {
            obj.attr('style', obj.find('option:selected').attr('style'));
        }
        $('select').each(function(){
             fixSelectStyle($(this));
        }).change(function(){
            fixSelectStyle($(this));
        });
    }*/
});