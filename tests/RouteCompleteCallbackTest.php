<?php

namespace Packaged\Tests\Routing;

use Exception;
use Packaged\Context\Context;
use Packaged\Http\Request;
use Packaged\Http\Response;
use Packaged\Routing\Handler\FuncHandler;
use Packaged\Routing\RequestCondition;
use Packaged\Routing\Route;
use Packaged\Routing\RouteCompleteCallback;
use Packaged\Tests\Routing\Supporting\TestSingleRouteSelector;
use PHPUnit\Framework\TestCase;

class RouteCompleteCallbackTest extends TestCase
{
  public function testComplete()
  {
    $handler = new FuncHandler(
      function () {
        return Response::create('OK');
      }
    );

    $request = Request::create('http://www.test.com:8080/');
    $ctx = new Context($request);

    (new TestSingleRouteSelector(
      Route::with(
        RouteCompleteCallback::i(
          function (Context $ctx) {
            $ctx->meta()->set('callback', 1);
          }
        )
      )->setHandler($handler)
    ))->handle($ctx);

    $this->assertEquals(1, $ctx->meta()->get('callback'));

    try
    {
      (new TestSingleRouteSelector(
        Route::with(
          RouteCompleteCallback::i(
            function (Context $ctx) {
              $ctx->meta()->set('callback', 2);
            }
          )->setCondition(RequestCondition::i()->domain('invalid'))
        )->setHandler($handler)
      ))->handle($ctx);
    }
    catch(Exception $e)
    {
    }
    $this->assertEquals(1, $ctx->meta()->get('callback'));

    (new TestSingleRouteSelector(
      Route::with(
        RouteCompleteCallback::i(
          function (Context $ctx) {
            $ctx->meta()->set('callback', 3);
          }
        )->setCondition(RequestCondition::i()->domain('test'))
      )->setHandler($handler)
    ))->handle($ctx);

    $this->assertEquals(3, $ctx->meta()->get('callback'));

    (new TestSingleRouteSelector(Route::with(RouteCompleteCallback::i())->setHandler($handler)))->handle($ctx);
    $this->assertEquals(3, $ctx->meta()->get('callback'));
  }
}
