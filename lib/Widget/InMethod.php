<?php

/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2012 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget;

/**
 * InMethod
 *
 * @package     Widget
 * @author      Twin Huang <twinh@yahoo.cn>
 */
class InMethod extends WidgetProvider
{
    public function __invoke($method)
    {
        return 0 === strcasecmp($this->server('REQUEST_METHOD'), $method);
    }
}
