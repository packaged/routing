<?php

namespace Packaged\Tests\Routing;

use Packaged\Context\Context;
use Packaged\Http\Request;
use Packaged\Tests\Routing\Supporting\TestHandlerRouteSelector;
use Packaged\Tests\Routing\Supporting\TestNoRouteSelector;
use Packaged\Tests\Routing\Supporting\TestRouteSelector;
use Packaged\Tests\Routing\Supporting\TestSingleRouteSelector;
use PHPUnit\Framework\TestCase;

class RouteSelectorTest extends TestCase
{
  public function testSelector()
  {
    $selector = new TestRouteSelector();
    $a = $selector->handle(new Context(Request::create('/a')));
    $this->assertEquals('a', $a->getContent());
    $b = $selector->handle(new Context(Request::create('/b')));
    $this->assertEquals('b', $b->getContent());
    $c = $selector->handle(new Context(Request::create('/c')));
    $this->assertEquals('c', $c->getContent());
  }

  public function testSingleSelector()
  {
    $selector = new TestSingleRouteSelector();
    $this->assertEquals('single', $selector->handle(new Context())->getContent());
  }

  public function testEmptySelector()
  {
    $selector = new TestSingleRouteSelector(false);
    $this->expectExceptionMessage('Unavailable');
    $selector->handle(new Context())->getContent();
  }

  public function testHandlerSelector()
  {
    $selector = new TestHandlerRouteSelector();
    $this->assertEquals('single', $selector->handle(new Context())->getContent());
  }

  public function testHandlerEmptySelector()
  {
    $selector = new TestHandlerRouteSelector(false);
    $this->expectExceptionMessage('Unavailable');
    $selector->handle(new Context())->getContent();
  }

  public function testNullSelector()
  {
    $selector = new TestNoRouteSelector();
    $this->expectExceptionMessage('Unavailable');
    $selector->handle(new Context())->getContent();
  }
}
