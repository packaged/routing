<?php
namespace Packaged\Tests\Routing\Supporting;

use Exception;
use Packaged\Context\Context;
use Packaged\Http\Response;
use Packaged\Routing\Handler\FuncHandler;
use Packaged\Routing\Handler\Handler;
use Packaged\Routing\Route;
use Packaged\Routing\RouteSelector;

class TestSingleRouteSelector extends RouteSelector
{
  protected $_route;

  public function __construct($route = null)
  {
    $this->_route = $route ?? new FuncHandler(function () { return Response::create('single'); });
  }

  protected function _generateRoutes()
  {
    if($this->_route instanceof Route)
    {
      yield $this->_route;
      return null;
    }
    return $this->_route;
  }

  public function handle(Context $c): \Symfony\Component\HttpFoundation\Response
  {
    $handler = $this->_getHandler($c);
    if($handler instanceof Handler)
    {
      return $handler->handle($c);
    }
    throw new Exception("Unavailable");
  }
}
