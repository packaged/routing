<?php

namespace Packaged\Tests\Routing;

use Packaged\Context\Context;
use Packaged\Http\Request;
use Packaged\Routing\FuncCondition;
use PHPUnit\Framework\TestCase;

class FuncConditionTest extends TestCase
{
  protected function _makeContext()
  {
    $ctx = new Context(
      Request::create(
        'https://localhost/?query1=val1&query2=val2&query3=val3',
        'POST',
        ['post1' => 'val1', 'post2' => 'val2', 'post3' => 'val3'],
        ['cookie1' => 'val1', 'cookie2' => 'val2'],
        [],
        ['HTTPS' => 'on']
      )
    );

    $ctx->meta()->set('a', 'b');
    return $ctx;
  }

  public function testInstance()
  {
    $c = $this->_makeContext();
    self::assertTrue((new FuncCondition(function (Context $ctx) { return $ctx->meta()->has('a'); }))->match($c));
    self::assertFalse((new FuncCondition(function (Context $ctx) { return $ctx->meta()->has('b'); }))->match($c));
  }
}
