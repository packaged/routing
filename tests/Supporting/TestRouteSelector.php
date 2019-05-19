<?php
namespace Packaged\Tests\Routing\Supporting;

use Packaged\Context\Context;
use Packaged\Http\Response;
use Packaged\Routing\Handler\FuncHandler;
use Packaged\Routing\RouteSelector;

class TestRouteSelector extends RouteSelector
{
  protected function _generateRoutes()
  {
    yield self::_route('/a', new FuncHandler(function () { return Response::create('a'); }));
    yield self::_route('/b', new FuncHandler(function () { return Response::create('b'); }));
    return new FuncHandler(function () { return Response::create('c'); });
  }

  public function handle(Context $c): \Symfony\Component\HttpFoundation\Response
  {
    $handler = $this->_getHandler($c);
    return $handler->handle($c);
  }

}
