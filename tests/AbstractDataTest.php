<?php
/**
 * Created by PhpStorm.
 * User: vmp
 * Date: 04.08.2017
 * Time: 12:00
 */

use Data\AbstractData;
use PHPUnit\Framework\TestCase;

class AbstractDataTest extends TestCase
{
    protected $obj_;

    public function testSetGet()
    {
        /**
         * @var $stub AbstractData
         */
        $stub = $this->getMockForAbstractClass(Data\AbstractData::class);
        $this->assertEquals(null, $stub->test);

        $stub->test = 123;
        $this->assertEquals(123, $stub->test);
        $stub->test = 456;
        $this->assertEquals(456, $stub->test);
        $stub->test = false;
        $this->assertEquals(false, $stub->test);
        $stub->test = false;
        $this->assertEquals(false, $stub->test);
        $stub->test = null;
        $this->assertEquals(null, $stub->test);
        $stub->test = array();
        $this->assertEquals(array(), $stub->test);
    }

    public function testIsSetted()
    {
        /**
         * @var $stub AbstractData
         */
        $stub = $this->getMockForAbstractClass(Data\AbstractData::class);

        $this->assertEquals(false, $stub->isSet('test'));

        $stub->test = 123;
        $this->assertEquals(true, $stub->isSet('test'));
        $this->assertEquals(false, $stub->isSet('test,test2'));
        $this->assertEquals(null, $stub->isSet('test,test2', true));

        $stub->setArray(array('test2' => 456));
        $this->assertEquals(true, $stub->isSet('test,test2'));
        $this->assertEquals(array('test' => 123, 'test2' => 456), $stub->isSet('test,test2', true));
    }

    public function testSetArray()
    {
        $func = 'setArray';
        /**
         * @var $stub AbstractData
         */
        $stub = $this->getMockForAbstractClass(Data\AbstractData::class);

        $ans = $stub->setArray(array('test' => 123, 'test2' => 456));
        $this->assertEquals(true, $ans);
        $this->assertEquals(123, $stub->isSet('test'));
        $this->assertEquals(456, $stub->isSet('test2'));

        $ans = $stub->setArray(array('test' => 123, 'test2' => 456, '1' => 'thisPass'));
        $this->assertEquals(true, $ans, '$func pass with numeric array');

        $ans = $stub->setArray(array('test' => 123, 'test2' => 456, '1' => 'thisFail'), false);
        $this->assertEquals(false, $ans);
    }

    public function testGetKeys()
    {
        $func = 'getArray';
        /**
         * @var $stub AbstractData
         */
        $stub = $this->getMockForAbstractClass(Data\AbstractData::class);

        $arr = array('test' => 123, 'test2' => 456);

        $stub->setArray($arr);
        $ans = $stub->getArray();
        $this->assertEquals($arr, $ans);

        $ans = $stub->getArray('nokey');
        $this->assertEquals(array('nokey' => null), $ans);

        $ans = $stub->getArray('nokey', true);
        $this->assertEquals(array(), $ans);

        $ans = $stub->getArray('test2');
        $this->assertEquals(array('test2' => 456), $ans);
    }

    public function testSetArrEl()
    {
        $func = 'setArrEl';
        /**
         * @var $stub AbstractData
         */
        $stub = $this->getMockForAbstractClass(Data\AbstractData::class);

        $stub->setArrEl('test', 'key', 'val');
        $ans = $stub->test;
        $this->assertEquals(array('key' => 'val'), $ans);

        $stub->test = array('key' => 'val');

        $stub->setArrEl('test', 'key', 'val2');
        $ans = $stub->test;
        $this->assertEquals(array('key' => 'val2'), $ans);
    }

    public function testAppendArrEl()
    {
        $func = 'appendArrEl';
        /**
         * @var $stub AbstractData
         */
        $stub = $this->getMockForAbstractClass(Data\AbstractData::class);

        $stub->appendArrEl('test', 'val');
        $ans = $stub->test;
        $this->assertEquals(array(0 => 'val'), $ans);

        $stub->test = array(0 => 'val');

        $stub->appendArrEl('test', 'val2');
        $ans = $stub->test;
        $this->assertEquals(array(0 => 'val', 1 => 'val2'), $ans);
    }
}
