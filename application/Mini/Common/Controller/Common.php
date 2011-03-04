<?php
/**
 * Common
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
 * @since       2011-01-24 18:40:36
 */

class Mini_Common_Controller_Common extends Qwin_Application_Controller
{
    public function actionIndex()
    {
        $config = Qwin::config();
        ini_set('zlib.output_compression', '0');

        $option['maxAge'] = 1800;
        $option['minApp']['groupsOnly'] = true;

        // IIS may need help
        if (0 === stripos(PHP_OS, 'win')) {
            $_SERVER['DOCUMENT_ROOT'] = dirname($config['root']);
        }

        // 设置缓存类型
        $cachePath = $config['root'] . 'cache/minify';
        Minify::setCache($cachePath);

        // 调试
        if ($config['debug']) {
            $option['debug'] = true;
        }

        // 日志记录
        if ($config['log']) {
            Minify_Logger::setLogger(FirePHP::getInstance(true));
        }

        // 获取文件
        $request = Qwin::call('-request');
        $name = $request->get('g');
        $file = Qwin::widget('minify')->getCacheFile($name);
        if (!is_file($file)) {
            Qwin::widget('log4php')->info('minify file ' . $name . ' not found.');
            exit;
        }
        $option['minApp']['groups'][$name] = require $file;

        // serve!
        Minify::serve('MinApp', $option);
    }
}