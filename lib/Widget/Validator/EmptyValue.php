<?php
/**
 * Widget Framework
 *
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget\Validator;

/**
 * @package     Widget
 * @author      Twin Huang <twinh@yahoo.cn>
 */
class EmptyValue extends AbstractRule
{
    protected $message = 'This value must be null';
    
    public function __invoke($value)
    {
        return empty($value);
    }
}