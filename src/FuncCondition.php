<?php
namespace Packaged\Routing;

use Packaged\Context\Context;

class FuncCondition implements Condition
{
  /** @var callable */
  protected $_func;

  public function __construct(callable $func)
  {
    $this->_func = $func;
  }

  public static function i(callable $func)
  {
    return new static($func);
  }

  public function match(Context $context): bool
  {
    return ($this->_func)($context);
  }
}
