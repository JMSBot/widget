<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2012 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget;

/**
 * Cookie
 *
 * @package     Widget
 * @author      Twin Huang <twinh@yahoo.cn>
 */
class Cookie extends ArrayWidget
{
    /**
     * @var array Options
     * @see http://php.net/manual/en/function.setcookie.php
     */
    public $options = array(
        'parameters'    => false,
        'expire'        => 86400,
        'path'          => '/',
        'domain'        => null,
        'secure'        => false,
        'httpOnly'      => false,
        'raw'           => false,
    );

    /**
     * The cookies that have not been sent to header, but will sent when class destruct
     *
     * @var array
     * @see \Widget\Cookie::__destruct
     */
    protected $rawCookies = array();

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        parent::__construct($options);

        if (is_array($this->options['parameters'])) {
            $this->data = $this->options['parameters'];
        } else {
            $this->data = $_COOKIE;
        }
    }

    /**
     * Get or set cookie
     *
     * @param  string       $key     the name of cookie
     * @param  mixed        $value   the value of cookie
     * @param  array        $options options for set cookie
     * @return \Widget\Cookie
     */
    public function __invoke($key, $value = null, array $options = array())
    {
        if (1 == func_num_args()) {
            return $this->get($key);
        } else {
            return $this->set($key, $value, $options);
        }
    }

    /**
     * Get cookie
     *
     * @param  string $key
     * @param  mixed  $default default value
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return isset($this->data[$key]) ? @unserialize($this->data[$key]) : $default;
    }

    /**
     * Set cookie
     *
     * @param  string       $key     The name of cookie
     * @param  mixed        $value   The value of cookie
     * @param  array        $options
     * @return \Widget\Cookie
     * @todo serialize or not ?
     */
    public function set($key, $value = null, array $options = array())
    {
        if (isset($options['expire']) && 0 > $options['expire'] && isset($this->data[$key])) {
             unset($this->data[$key]);
        } else {
            //$this->data[$key] = serialize($value);
            $this->data[$key] = $value;
        }

        $this->rawCookies[$key] = array(
            'value' => $value
        ) + $options + $this->options;

        return $this;
    }

    /**
     * Remove cookie
     *
     * @param string $key the name of cookie
     */
    public function remove($key)
    {
        if (isset($this->data[$key])) {
            $this->set($key, null, array(
                'expire' => -1
            ));
        }

        return $this;
    }

    /**
     * Remove cookie
     *
     * @param  string       $key the name of cookie
     * @return \Widget\Cookie
     */
    public function offsetUnset($key)
    {
        return $this->remove($key);
    }

    /**
     * Send cookie to header
     *
     * @return \Widget\Cookie
     */
    public function send()
    {
        foreach ($this->rawCookies as $name => $o) {
            $fn = $o['raw'] ? 'setrawcookie' : 'setcookie';
            $fn($name, $o['value'], time() + $o['expire'], $o['path'], $o['domain'], $o['secure'], $o['httpOnly']);
            unset($this->rawCookies[$name]);
        }

        return $this;
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        $this->send();
    }
}
