<?php

namespace Widget;

/**
 * Cache
 *
 * @package     Widget
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   2008-2012 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2012-06-16
 */
class Cache extends WidgetProvider
{
    public $options = array(
        'driver' => 'apc',
    );

    /**
     * Cache object
     *
     * @var Widget_Storable
     */
    protected $_cache;

    public function __construct(array $options = array())
    {
        parent::__construct($options);

        $class = 'Widget_' . ucfirst($this->options['driver']);

        if (!in_array('Widget_Storable', class_implements($class))) {
            $this->exception('Cache driver "%s" not found', $class);
        }

        $this->_cache = new $class($options);
    }

    public function __invoke($key, $value = null, array $expire = array())
    {
        if (1 == func_num_args()) {
            return $this->get($key);
        } else {
            return $this->set($key, $value, $expire);
        }
    }

    public function __call($name, $args)
    {
        return call_user_func_array(array($this->_cache, $name), $args);
    }
}
