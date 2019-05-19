<?php
namespace Packaged\Tests\Routing\Supporting;

use Exception;
use Packaged\Context\Context;
use Packaged\Routing\Handler\Handler;
use Packaged\Routing\RouteSelector;
use Symfony\Component\HttpFoundation\Response;

class TestNoRouteSelector extends RouteSelector
{
  protected function _generateRoutes()
  {
    return [];
  }

  public function handle(Context $c): Response
  {
    $handler = $this->_getHandler($c);
    if($handler instanceof Handler)
    {
      return $handler->handle($c);
    }
    throw new Exception("Unavailable");
  }
}
