<?php

namespace Packaged\Tests\Routing;

use Packaged\Context\Context;
use Packaged\Http\Request;
use Packaged\Routing\HealthCheckCondition;
use PHPUnit\Framework\TestCase;

class HealthCheckConditionTest extends TestCase
{

  public function testMatch()
  {
    $this->assertFalse(HealthCheckCondition::i()->match(new Context(Request::create('http://www.test.com:8080/'))));
    $this->assertTrue(
      HealthCheckCondition::i()->match(new Context(Request::create('http://www.test.com:8080/_ah/health')))
    );

    $ctx = new Context(Request::create('http://www.test.com:8080/'));
    $this->assertFalse(HealthCheckCondition::i()->match($ctx));

    $ctx = new Context(
      Request::create('http://www.test.com:8080/', 'GET', [], [], [], ['HTTP_USER_AGENT' => 'GoogleHC/1'])
    );
    $this->assertTrue(HealthCheckCondition::i()->match($ctx));

    $ctx = new Context(
      Request::create('http://www.test.com:8080/', 'GET', [], [], [], ['HTTP_USER_AGENT' => 'kube-probe'])
    );
    $this->assertTrue(HealthCheckCondition::i()->match($ctx));

    $ctx = new Context(
      Request::create('http://www.test.com:8080/', 'GET', [], [], [], ['HTTP_USER_AGENT' => 'elb-healthchecker'])
    );
    $this->assertTrue(HealthCheckCondition::i()->match($ctx));
  }
}
