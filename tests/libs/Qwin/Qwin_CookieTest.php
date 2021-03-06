<?php
ob_start();
require_once dirname(__FILE__) . '/../../../libs/Qwin.php';

/**
 * Test class for Qwin_Cookie.
 * Generated by PHPUnit on 2012-01-18 at 09:10:40.
 */
class Qwin_CookieTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Qwin_Cookie
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     * @covers Qwin_Cookie::__construct
     */
    protected function setUp() {
        $this->object = Qwin::getInstance()->cookie;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers Qwin_Cookie::__invoke
     */
    public function test__invoke() {
        $widget = $this->object;

        $widget->cookie('test', __METHOD__);

        $this->assertEquals(__METHOD__, $widget->cookie('test'));
    }

    /**
     * @covers Qwin_Cookie::get
     */
    public function testGet() {
        $widget = $this->object;

        $widget->set('test', __METHOD__);

        $this->assertEquals(__METHOD__, $widget->get('test'));
    }

    /**
     * @covers Qwin_Cookie::set
     */
    public function testSet() {
        $widget = $this->object;

        $widget->set('test', __METHOD__, array('expire' => 1));

        $this->assertEquals(__METHOD__, $widget->get('test'));

        $widget->set('test', __METHOD__, array('expire' => -1));

        $this->assertEquals(null, $widget->get('test'), 'test expired cookie');
    }
    
    /**
     * @covers Qwin_Cookie::remove
     * @covers Qwin_Cookie::offsetUnset
     */
    public function testRemove() {
        $widget = $this->object;

        $widget->set('test', __METHOD__);

        $this->assertEquals(__METHOD__, $widget->get('test'));

        $widget->offsetUnset('test');

        $this->assertEquals(null, $widget->get('test'));
    }
}
