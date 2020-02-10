<?php
namespace Packaged\Routing\Routes;

use Packaged\Context\Context;
use Packaged\Routing\FuncCondition;
use Packaged\Routing\Handler\FuncHandler;
use Packaged\Routing\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class InsecureRequestUpgradeRoute extends Route
{
  public function __construct()
  {
    $this->add(FuncCondition::i(function (Context $c) { return !$c->request()->isSecure(true); }));
  }

  public function getHandler()
  {
    return new FuncHandler(
      function (Context $c) {
        return RedirectResponse::create(
          str_replace('http:', 'https:', $c->request()->getUri())
        );
      }
    );
  }
}
