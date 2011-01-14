<?php
/**
 * Detail
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
 * @package     Common
 * @subpackage  Article
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-05-27 00:13:24
 */

class Common_Article_Metadata_Detail extends Common_Metadata
{
    public function  setMetadata()
    {
        $this//->setIdMetadata()
             ->parseMetadata(array(
            'field' => array(
                'id' => array(
                    'form' => array(
                        '_type' => 'hidden',
                        'name' => 'id',
                    ),
                    'attr' => array(
                        'isList' => 0,
                        'isView' => 0,
                    ),
                ),
                'article_id' => array(
                    'form' => array(
                        '_type' => 'hidden',
                        'name' => 'article_id',
                    ),
                    'attr' => array(
                        'isList' => 0,
                        'isView' => 0,
                    ),
                ),
                'content' => array(
                    'basic' => array(
                        'order' => 400,
                        'layout' => 2,
                    ),
                    'form' => array(
                        '_type' => 'textarea',
                        '_widget' => 'CKEditor',
                        'name' => 'content',
                    ),
                    'attr' => array(
                        'isList' => 0,
                    ),
                ),
                'meta' => array(
                    'form' => array(
                        '_type' => 'custom',
                        'name' => 'meta',
                    ),
                    'attr' => array(
                        'isList' => 0,
                        'isDbField' => 1,
                        'isView' => 0,
                    ),
                ),
                'meta_keywords' => array(
                    'basic' => array(
                        'group' => 3,
                    ),
                    'form' => array(
                        '_type' => 'text',
                        'name' => 'meta_keywords',
                    ),
                    'attr' => array(
                        'isList' => 0,
                        'isDbField' => 0,
                        'isDbQuery' => 0,
                    ),
                ),
                'meta_description' => array(
                    'basic' => array(
                        'group' => 3,
                    ),
                    'form' => array(
                        '_type' => 'text',
                        'name' => 'meta_description',
                    ),
                    'attr' => array(
                        'isList' => 0,
                        'isDbField' => 0,
                        'isDbQuery' => 0,
                    ),
                ),
            ),
            'model' => array(),
            'metadata' => array(),
            'db' => array(
                'table' => 'article_detail',
                'primaryKey' => 'id',
            ),
            // 页面显示
            'page' => array(
                'title' => 'LBL_MODULE_ARTICLE_DETAIL',
                'rowNum' => 10,
            ),
            'shortcut' => array(
            )
        ));
    }

    public function convertDbMeta($value, $name, $data, $copyData)
    {
        return serialize(array(
            'keywords' => $copyData['meta_keywords'],
            'description' => $copyData['meta_description'],
        ));
    }

    public function convertEditMeta($value, $name, $data, $copyData)
    {
        return @unserialize($value);
    }

    public function convertEditMetaKeywords($value, $name, $data, $copyData)
    {
        return $data['meta']['keywords'];
    }

    public function convertEditMetaDescription($value, $name, $data, $copyData)
    {
        return $data['meta']['description'];
    }

    public function convertViewMeta($value, $name, $data, $copyData)
    {
        return @unserialize($value);
    }

    public function convertViewMetaKeywords($value, $name, $data, $copyData)
    {
        return $data['meta']['keywords'];
    }

    public function convertViewMetaDescription($value, $name, $data, $copyData)
    {
        return $data['meta']['description'];
    }
}