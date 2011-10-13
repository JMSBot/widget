<?php

/**
 * Method
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
 * @since       2011-09-15 21:18:31
 */

/**
 * @see Zend_Reflection_Class
 */
require_once 'Zend/Reflection/Method.php';

class Qwin_Reflection_Method extends Zend_Reflection_Method
{
    public function toArray()
    {
        try {
            $docblock = $this->getDocblock();
            $longDescription = $docblock->getLongDescription();
            $shortDescription = $docblock->getShortDescription();
            
            $returnTag = $docblock->getTag('return');
            $return = array(
                'type' => $returnTag ? $returnTag->getType() : '-',
                'description' => $returnTag ? $returnTag->getDescription() : null,
            );

            $paramsDescription = array();
            $tags = $docblock->getTags();
            /* @var $tag Zend_Reflection_Docblock_Tag_Param */
            foreach ($tags as $tag) {
                if ('param' == $tag->getName()) {
                    $paramsDescription[$tag->getVariableName()] = $tag->getDescription();
                }
            }
        } catch (Zend_Reflection_Exception $e) {
            $type = '-';
            $longDescription = null;
            $shortDescription = null;
            
            $return = array(
                'type' => '-',
                'description' => null,
            );
        }

        $parameters = $parameterText = array();
        $hasDescription = false;
        /* @var $parameter Qwin_Reflection_Parameter */
        foreach ($this->getParameters() as $parameter) {
            $parameters[$parameter->getName()] = $parameter->toArray();
            $array = &$parameters[$parameter->getName()];
            
            if ($parameter->isDefaultValueAvailable()) {
                $defaultValue = var_export($parameter->getDefaultValue(), true);
                if ('NULL' == $defaultValue) {
                    $defaultValue = 'null';
                }
                $parameterText[] = $array['type'] . ' ' . $array['varName'] . ' = ' . $defaultValue;
            } else {
                $parameterText[] = $array['type'] . ' ' . $array['varName'];
            }

            if (isset($paramsDescription[$array['varName']])) {
                $array['description'] = $paramsDescription[$array['varName']];
                $hasDescription = true;
            } else {
                $array['description'] = null;
            }
        }
        
        $parameterText = implode(', ', $parameterText);
        empty($parameterText) && $parameterText = 'void';
        $parameterText = '( ' . $parameterText . ' )';

        return array(
            'name' => $this->getName(),
            'class' => $this->class,
            'return' => $return,
            'modifiers' => implode(' ', Reflection::getModifierNames($this->getModifiers())),
            'longDescription' => $longDescription,
            'shortDescription' => $shortDescription,
            'parameters' => $parameters,
            'parameterText' => $parameterText,
            'hasDescription' => $hasDescription,
            'startLine' => (int)$this->getStartLine(true),
        );
    }
    
    /**
     * Retrieve method docblock reflection
     *
     * @return Qwin_Reflection_Docblock
     * @throws Zend_Reflection_Exception
     */
    public function getDocblock($reflectionClass = 'Qwin_Reflection_Docblock')
    {
        return parent::getDocblock($reflectionClass);
    }

    /**
     * Get reflection of declaring class
     *
     * @param  string $reflectionClass Name of reflection class to use
     * @return Qwin_Reflection_Class
     */
    public function getDeclaringClass($reflectionClass = 'Qwin_Reflection_Class')
    {
        return parent::getDeclaringClass($reflectionClass);
    }

    /**
     * Get all method parameter reflection objects
     *
     * @param  string $reflectionClass Name of reflection class to use
     * @return array of Qwin_Reflection_Parameter objects
     */
    public function getParameters($reflectionClass = 'Qwin_Reflection_Parameter')
    {
        return parent::getParameters($reflectionClass);
    }
}