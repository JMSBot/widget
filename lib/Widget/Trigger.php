<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2012 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget;

/**
 * Trigger
 *
 * @package     Widget
 * @author      Twin Huang <twinh@yahoo.cn>
 */
class Trigger extends WidgetProvider
{
    public function __invoke($event, $params = array())
    {
        return $this->eventManager->__invoke($event, $params);
    }
}
