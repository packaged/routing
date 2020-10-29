<?php
namespace Packaged\Routing;

use Packaged\Context\Context;
use Packaged\Routing\Handler\Handler;

class Route extends ConditionSet implements ConditionHandler, RouteCompleter
{
  private $_result;
  /**
   * @var array
   */
  protected $_onComplete = [];

  public function getHandler()
  {
    return $this->_result;
  }

  /**
   * @param Handler|string|callable $handler
   *
   * @return Route
   */
  public function setHandler($handler)
  {
    $this->_result = $handler;
    return $this;
  }

  public function complete(Context $context)
  {
    foreach($this->_conditions as $condition)
    {
      if($condition instanceof RouteCompleter)
      {
        $condition->complete($context);
      }
    }
    foreach($this->_onComplete as $callback)
    {
      $callback($context);
    }
  }

  public function addCompleteCallback(callable $callback)
  {
    $this->_onComplete[] = $callback;
    return $this;
  }

}
