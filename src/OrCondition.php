<?php
namespace Packaged\Routing;

use Packaged\Context\Context;

class OrCondition implements Condition
{
  public static function i()
  {
    return new static();
  }

  /** @var Condition[] */
  protected $_conditions = [];

  public function match(Context $context): bool
  {
    foreach($this->_conditions as $condition)
    {
      if($condition->match($context))
      {
        return true;
      }
    }
    return false;
  }

  public function add(Condition $condition)
  {
    $this->_conditions[] = $condition;
    return $this;
  }

}
