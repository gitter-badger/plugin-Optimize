<?php

use PHPUnit\Framework\TestCase;

require_once('../../core/php/core.inc.php');

class OptimizeAjaxTest extends TestCase
{
    public $dataStorage;

    protected function setUp()
    {
        JeedomVars::$jeedomIsConnected = true;
    }

    protected function tearDown()
    {
    }

    public function testNotConnected()
    {
        JeedomVars::$jeedomIsConnected = false;
        include(dirname(__FILE__) . '/../core/ajax/Optimize.ajax.php');
        $actions = MockedActions::get();
        $this->assertEquals(2, count($actions));
        $this->assertEquals('include_file', $actions[0]['action']);
        $this->assertEquals('authentification', $actions[0]['name']);
        $this->assertEquals('ajax_error', $actions[1]['action']);
    }

    public function testConnected()
    {
        scenario::init();
        JeedomVars::$initAnswers = array('category' => 'scenario', 'id' => 1, 'type' => 'log');
        include(dirname(__FILE__) . '/../core/ajax/Optimize.ajax.php');
        $actions = MockedActions::get();
        $this->assertEquals(6, count($actions));
        $this->assertEquals('include_file', $actions[0]['action']);
        $this->assertEquals('authentification', $actions[0]['name']);
        $this->assertEquals('ajax_init', $actions[1]['action']);
        $this->assertEquals('set_configuration', $actions[2]['action']);
        $this->assertEquals('save', $actions[3]['action']);
        $this->assertEquals('ajax_success', $actions[4]['action']);
    }
}
