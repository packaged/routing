<?php

namespace Packaged\Tests\Routing\Routes;

use Packaged\Context\Context;
use Packaged\Http\Request;
use Packaged\Routing\Routes\InsecureRequestUpgradeRoute;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;

class InsecureRequestUpgradeRouteTest extends TestCase
{
  public function testHttpUpgrade()
  {
    $ctx = new Context(Request::create('http://www.google.com/a/b/c/?d=e&f=g'));
    $route = InsecureRequestUpgradeRoute::i();
    $this->assertTrue($route->match($ctx));
    /** @var RedirectResponse|null $resp */
    $resp = $route->getHandler()->handle($ctx);
    $this->assertInstanceOf(RedirectResponse::class, $resp);
    $this->assertEquals('https://www.google.com/a/b/c/?d=e&f=g', $resp->getTargetUrl());
  }

  public function testHttpsIgnore()
  {
    $ctx = new Context(Request::create('https://www.google.com/'));
    $route = InsecureRequestUpgradeRoute::i();
    $this->assertFalse($route->match($ctx));
  }
}
