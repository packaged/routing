<?php
namespace Packaged\Tests\Routing;

use Packaged\Context\Context;
use Packaged\Http\Response;
use Packaged\Routing\Handler\FuncHandler;
use PHPUnit\Framework\TestCase;

class FuncHandlerTest extends TestCase
{
  public function testHandle()
  {
    $handler = new FuncHandler(function ($c) { return Response::create('Done'); });
    $resp = $handler->handle(new Context());
    $this->assertEquals('Done', $resp->getContent());
  }
}
