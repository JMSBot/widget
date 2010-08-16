<?php
/**
 * Manager
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
 * @subpackage  Metadata
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-7-26 13:15:23
 */

/**
 * metadata数据管理器
 */

class Qwin_Metadata_Manager
{
    /**
     * 存放所有元数据
     * @var <type>
     */
    private $_data;

    /**
     * 存放所有元数据的原始数据
     * @var <type>
     */
    private $_originalData;

    /**
     * 存储各metada实例化的数组
     * @var <type>
     */
    private static $_metadataObj;

    /**
     * 将一组元数据加入管理器中
     *
     * @param <type> $name
     * @param <type> $metadata
     * @example $metadataManager->set('Default_Article_Metadata_Article', $meta->defaultMetadata);
     */
    public function set($name, $metadata)
    {
        if(!isset($_originalData[$name]))
        {
            $this->_data[$name] = $metadata;
            $this->_originalData = $metadata;
        }
    }

    public static function get($className)
    {
        if(isset(self::$_metadataObj[$className]))
        {
            return self::$_metadataObj[$className];
        }
        if(class_exists($className))
        {
            self::$_metadataObj[$className] = new $className;
            //self::$_metadataObj[$className]->setMetadata();
            return self::$_metadataObj[$className];
        }
        return null;
    }
}
