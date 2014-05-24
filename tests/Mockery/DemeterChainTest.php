<?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010-2014 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */


class DemeterChainTest extends \PHPUnit_Framework_TestCase
{
    public function testTwoChains()
    {
        $mock = Mockery::mock('object')->shouldIgnoreMissing();
        $mock->shouldReceive('getElement->getFirst')
            ->once()
            ->andReturn('something');

        $mock->shouldReceive('getElement->getSecond')
            ->once()
            ->andReturn('somethingElse');

        $mock->getElement()->getFirst();
        $mock->getElement()->getSecond();
    }

    public function testTwoNotRelatedChains()
    {
        $mock = Mockery::mock('object')->shouldIgnoreMissing();
        $mock->shouldReceive('getElement->getFirst')
            ->once()
            ->andReturn('something');

        $mock->shouldReceive('getOtherElement->getSecond')
            ->once()
            ->andReturn('somethingElse');

        $mock->getElement()->getFirst();
        $mock->getOtherElement()->getSecond();
    }

    public function testDemeterChain()
    {
        $mock = Mockery::mock('object')->shouldIgnoreMissing();

        $mock->shouldReceive('getElement->getFirst')
            ->once()
            ->andReturn('somethingElse');

        $this->assertEquals('somethingElse', $mock->getElement()->getFirst());

    }

    public function testChainedMethodAndBaseMethod()
    {
        $mock = Mockery::mock('object')->shouldIgnoreMissing();
        $mock->shouldReceive('getElement->getFirst')
            ->andReturn('somethingElse');

        $mock->shouldReceive('getElement')
            ->andReturn('something');

        $mock->getElement()->getFirst();
        $mock->getElement();
    }

    public function testBaseMethodAndChainedMethod()
    {
        $mock = Mockery::mock('object')->shouldIgnoreMissing();
        $mock->shouldReceive('getElement')
            ->andReturn('something');

        $mock->shouldReceive('getElement->getFirst')
            ->andReturn('somethingElse');


       // $mock->getElement()->getFirst();
        $mock->getElement();
    }
}
