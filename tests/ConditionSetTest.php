<?php

namespace Packaged\Tests\Routing;

use Packaged\Context\Context;
use Packaged\Http\Request;
use Packaged\Routing\ConditionSet;
use Packaged\Routing\RequestConstraint;
use PHPUnit\Framework\TestCase;

class ConditionSetTest extends TestCase
{

  public function testSet()
  {
    $ctx = new Context(new Request(['a' => 'bb']));

    $condition = ConditionSet::i()->add(RequestConstraint::i()->hasQueryKey('a'));
    $condition->match($ctx);
    $this->assertTrue($condition->match($ctx));

    $condition = ConditionSet::with(
      RequestConstraint::i()->hasQueryKey('a'),
      RequestConstraint::i()->hasQueryValue('a', 'bb')
    );
    $this->assertTrue($condition->match($ctx));
  }
}
