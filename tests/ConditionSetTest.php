<?php

namespace Packaged\Tests\Routing;

use Packaged\Context\Context;
use Packaged\Http\Request;
use Packaged\Routing\ConditionSet;
use Packaged\Routing\RequestCondition;
use PHPUnit\Framework\TestCase;

class ConditionSetTest extends TestCase
{

  public function testSet()
  {
    $ctx = new Context(new Request(['a' => 'bb']));

    $condition = ConditionSet::i()->add(RequestCondition::i()->hasQueryKey('a'));
    $condition->match($ctx);
    $this->assertTrue($condition->match($ctx));

    $condition = ConditionSet::with(
      RequestCondition::i()->hasQueryKey('a'),
      RequestCondition::i()->hasQueryValue('a', 'bb')
    );
    $this->assertTrue($condition->match($ctx));
  }
}
