<?php
namespace Packaged\Tests\Routing\Supporting;

use Exception;
use Packaged\Context\Context;
use Packaged\Http\Response;
use Packaged\Routing\Handler\FuncHandler;
use Packaged\Routing\Handler\Handler;
use Packaged\Routing\Route;
use Packaged\Routing\RouteSelector;

class TestHandlerRouteSelector extends RouteSelector
{
  protected $_handler;

  public function __construct($handler = null)
  {
    $this->_handler = $handler ?? new FuncHandler(function () { return Response::create('single'); });
  }

  protected function _generateRoutes()
  {
    return $this->_handler;
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
