<?php
namespace Packaged\Routing;

use Packaged\Context\Context;
use function is_callable;

class RouteCompleteCallback implements RouteCompleter, Condition
{
  protected $_callback;
  protected $_condition;

  public function __construct(callable $callback = null)
  {
    if($callback !== null)
    {
      $this->setCallback($callback);
    }
  }

  public static function i(callable $callback = null)
  {
    return new static($callback);
  }

  public function match(Context $context): bool
  {
    if($this->_condition instanceof Condition)
    {
      return $this->_condition->match($context);
    }
    return true;
  }

  public function setCondition(Condition $condition)
  {
    $this->_condition = $condition;
    return $this;
  }

  public function setCallback(callable $callback)
  {
    $this->_callback = $callback;
    return $this;
  }

  public function complete(Context $context)
  {
    $func = $this->_callback;
    if(is_callable($func))
    {
      return $func($context);
    }
    return null;
  }

}
