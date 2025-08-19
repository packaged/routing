<?php

namespace Packaged\Routing\Routes;

use Packaged\Context\Context;
use Packaged\Routing\Handler\Handler;
use Packaged\Routing\RequestCondition;
use Packaged\Routing\Route;

class PathPrefixRoute extends Route
{
  protected array $_paths = [];
  protected string $_routedPath = '';

  /**
   * @param string                  $pathPrefix
   * @param Handler|string|callable $handler
   *
   * @return $this
   */
  public function addPath(string $pathPrefix, Handler|string|callable $handler): static
  {
    $this->_paths[$pathPrefix] = $handler;
    return $this;
  }

  public function match(Context $context): bool
  {
    $path = $context->request()->path();
    foreach($this->_paths as $pathPrefix => $handler)
    {
      if(str_starts_with($path, $pathPrefix))
      {
        $this->_routedPath = $pathPrefix;
        $this->setHandler($handler);
        return true;
      }
    }
    return false;
  }

  public function complete(Context $context)
  {
    $context->meta()->set(RequestCondition::META_ROUTED_PATH, $this->_routedPath);
  }
}
