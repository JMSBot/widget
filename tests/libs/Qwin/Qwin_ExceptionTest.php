<?php

require_once dirname(__FILE__) . '/../../../libs/Qwin/Exception.php';

/**
 * Test class for Qwin_Exception.
 * Generated by PHPUnit on 2012-01-18 at 07:47:21.
 */
class Qwin_ExceptionTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Qwin_Exception
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Qwin_Exception;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers Qwin_Exception::__construct
     */
    public function test__construct()
    {

    }

    /**
     * @covers Qwin_Exception::__invoke
     */
    public function test__invoke() {
        $this->setExpectedException('Qwin_Exception', 'Class "name" not found.');

        $this->object->__invoke('Class "%s" not found.', 'name');
    }
}
