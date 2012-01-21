<?php

require_once dirname(__FILE__) . '/../../../libs/Qwin.php';
require_once dirname(__FILE__) . '/../../../libs/Qwin/IsEqual.php';

/**
 * Test class for Qwin_IsEqual.
 * Generated by PHPUnit on 2012-01-18 at 09:09:55.
 */
class Qwin_IsEqualTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Qwin_IsEqual
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Qwin_IsEqual;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers Qwin_IsEqual::call
     * @todo Implement testCall().
     */
    public function testCall() {
        $object = $this->object;
        
        $object->source = 'string';
        
        $this->assertTrue($object->isEqual(true));
        
        $this->assertFalse($object->isEqual(true, true));
    }

}

?>