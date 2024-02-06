<?php

namespace Packaged\Routing\Routes;

use Packaged\Context\Context;
use Packaged\Routing\Handler\Handler;
use Packaged\Routing\Route;

class ExactPathRoute extends Route
{
  protected array $_paths = [];

  /**
   * @param string                  $exactPath
   * @param Handler|string|callable $handler
   *
   * @return $this
   */
  public function addPath(string $exactPath, Handler|string|callable $handler): static
  {
    $this->_paths[$exactPath] = $handler;
    return $this;
  }

  public function match(Context $context): bool
  {
    $path = $context->request()->path();
    if(isset($this->_paths[$path]))
    {
      $this->setHandler($this->_paths[$path]);
      return true;
    }

    return false;
  }
}
