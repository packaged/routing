<?php

namespace Packaged\Tests\Routing;

use Packaged\Context\Context;
use Packaged\Http\Request;
use Packaged\Routing\OrCondition;
use Packaged\Routing\RequestCondition;
use PHPUnit\Framework\TestCase;

class OrConditionTest extends TestCase
{

  public function testMatch()
  {
    $request = Request::create('http://www.test.com:8080/path/one', 'POST');
    $ctx = new Context($request);

    $this->assertTrue(
      OrCondition::i()
        ->add(RequestCondition::i()->scheme('https'))
        ->add(RequestCondition::i()->domain('test'))
        ->match($ctx)
    );

    $this->assertTrue(
      OrCondition::i()
        ->add(RequestCondition::i()->domain('test'))
        ->add(RequestCondition::i()->scheme('https'))
        ->match($ctx)
    );

    $this->assertFalse(
      OrCondition::i()
        ->add(RequestCondition::i()->scheme('https'))
        ->add(RequestCondition::i()->domain('testing'))
        ->match($ctx)
    );

    $this->assertTrue(
      OrCondition::i()
        ->add(RequestCondition::i()->scheme('http'))
        ->add(RequestCondition::i()->rootDomain('test.com'))
        ->match($ctx)
    );
  }
}
