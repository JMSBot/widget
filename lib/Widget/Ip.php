<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2012 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget;

/**
 * Get ip
 *
 * @package     Widget
 * @author      Twin Huang <twinh@yahoo.cn>
 */
class Ip extends WidgetProvider
{
    /**
     * Get ip address
     *
     * @param  string $default default ip address
     * @return string ip address
     * @todo valid
     */
    public function __invoke($default = '0.0.0.0')
    {
        return $this->server['HTTP_X_FORWARDED_FOR']
            ?: $this->server['HTTP_CLIENT_IP']
            ?: $this->server['REMOTE_ADDR']
            ?: $default;
    }
}
