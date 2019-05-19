<?php
namespace Packaged\Routing;

use Packaged\Context\Context;

interface Condition
{
  public function match(Context $context): bool;
}
