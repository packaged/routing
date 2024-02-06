<?php

namespace Packaged\Tests\Routing\Routes;

use Packaged\Context\Context;
use Packaged\Http\Request;
use Packaged\Routing\Routes\ExactPathRoute;
use PHPUnit\Framework\TestCase;

class ExactPathRouteTest extends TestCase
{
  public function testUnmatchedPath()
  {
    $ctx = new Context(Request::create('http://www.google.com/a/b/c/?d=e&f=g'));

    $route = new ExactPathRoute();
    $route->addPath('/test', 'test');
    static::assertFalse($route->match($ctx));
  }

  public function matchPathProvider()
  {
    return [
      ['/test', 'testHandle'],
      ['/test/', 'testHandle'],
      ['/test?query=string', 'testHandle'],
      ['/test/?query=string', 'testHandle'],
      ['/test/?query=string&another=param', 'testHandle'],
      ['/secondary', 'handleTwo'],
      ['/random', 'randomHandle'],
    ];
  }

  /**
   * @param $url
   * @param $handler
   *
   * @dataProvider matchPathProvider
   * @return void
   */
  public function testMatchedPath($url, $handler)
  {
    $ctx = new Context(Request::create($url));

    $route = new ExactPathRoute();
    $route->addPath('/test', 'testHandle');
    $route->addPath('/test/', 'testHandle');
    $route->addPath('/secondary', 'handleTwo');
    $route->addPath('/random', 'randomHandle');
    static::assertTrue($route->match($ctx));
    static::assertEquals($handler, $route->getHandler());
  }
}
