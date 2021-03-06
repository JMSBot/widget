<?php
require_once dirname(__FILE__) . '/../../../libs/Qwin/Storable.php';
require_once dirname(__FILE__) . '/../../../libs/Qwin/Apc.php';

/**
 * Test class for Qwin_Apc.
 * Generated by PHPUnit on 2012-06-07 at 12:03:25.
 */
class Qwin_ApcTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Qwin_Apc
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        if (!extension_loaded('apc')) {
            $this->markTestSkipped('Extension "apc" is not loaded.');
        }

        $this->object = Qwin::getInstance()->apc;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers Qwin_Apc::get
     * @covers Qwin_Apc::remove
     * @covers Qwin_Apc::__construct
     */
    public function testGet() {
        $widget = $this->object;

        $widget->remove('test');

        $widget->set('test', __METHOD__);

        $this->assertEquals(__METHOD__, $widget->get('test'), 'get known cache');

        $widget->remove('test');

        $this->assertFalse($widget->get('test'), 'cache has been removed');

        $widget->set('test', __METHOD__, -1);

        $this->assertFalse($widget->get('test'), 'cache is expired');
    }

    /**
     * @covers Qwin_Apc::__invoke
     */
    public function test__invoke() {
        $widget = $this->object;

        $widget->apc(__METHOD__, true);

        $this->assertEquals(true, $widget->apc(__METHOD__));
    }

    /**
     * @covers Qwin_Apc::set
     */
    public function testSet() {
        $widget = $this->object;

        $widget->remove('test2');

        $widget->set('test2', __METHOD__);

        $this->assertEquals(__METHOD__, $widget->get('test2'));
    }

    /**
     * @covers Qwin_Apc::add
     */
    public function testAdd() {
        $widget = $this->object;

        $widget->remove(__METHOD__);

        $this->assertTrue($widget->add(__METHOD__, true));

        $widget->set(__METHOD__ . 'key', true);

        $this->assertFalse($widget->add(__METHOD__ . 'key', true));
    }

    /**
     * @covers Qwin_Apc::replace
     */
    public function testReplace() {
        $widget = $this->object;

        $widget->remove(__METHOD__);

        $this->assertFalse($widget->replace(__METHOD__, true));

        $widget->set(__METHOD__ . 'key', 'value');

        $this->assertTrue($widget->replace(__METHOD__ . 'key', true));
    }

    /**
     * @covers Qwin_Apc::increment
     */
    public function testIncrement() {
        $widget = $this->object;

        $widget->set(__METHOD__, 1);

        $widget->increment(__METHOD__);

        $this->assertEquals($widget->get(__METHOD__), 2);

        $widget->remove(__METHOD__);

        $result = $widget->increment(__METHOD__);

        $this->assertFalse($result, 'increment not found key');

        $widget->set(__METHOD__, 'string');

        $this->assertFalse($widget->increment(__METHOD__), 'not number key');
    }

    /**
     * @covers Qwin_Apc::decrement
     */
    public function testDecrement() {
        $widget = $this->object;

        $widget->set(__METHOD__, 1);

        $widget->decrement(__METHOD__);

        $this->assertEquals($widget->get(__METHOD__), 0);
    }

    /**
     * @covers Qwin_Apc::clear
     */
    public function testClear()
    {
        $widget = $this->object;

        $widget->set(__METHOD__, true);

        $widget->clear();

        $this->assertFalse($widget->get(__METHOD__), 'cache not found');
    }
}