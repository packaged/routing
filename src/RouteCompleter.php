<?php
namespace Packaged\Routing;

use Packaged\Context\Context;

interface RouteCompleter
{
  public function complete(Context $context);
}
