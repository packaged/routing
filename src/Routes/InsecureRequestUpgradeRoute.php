<?php
namespace Packaged\Routing\Routes;

use Packaged\Context\Context;
use Packaged\Routing\FuncCondition;
use Packaged\Routing\Handler\FuncHandler;
use Packaged\Routing\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class InsecureRequestUpgradeRoute extends Route
{
  protected $_subDomain;

  public function __construct()
  {
    $this->add(FuncCondition::i(function (Context $c) { return !$c->request()->isSecure(true); }));
  }

  /**
   * @param string $subDomain
   *
   * @return InsecureRequestUpgradeRoute
   */
  public static function withSubdomain(string $subDomain = 'www'): InsecureRequestUpgradeRoute
  {
    $i = new static();
    $i->_subDomain = trim($subDomain, '.');
    return $i;
  }

  public function getHandler()
  {
    return new FuncHandler(
      function (Context $c) {

        if($this->_subDomain)
        {
          $r = $c->request();
          if(null !== $qs = $r->getQueryString())
          {
            $qs = '?' . $qs;
          }
          $uri = $r->getBaseUrl() . $r->getPathInfo() . $qs;
          return RedirectResponse::create("https://" . $this->_subDomain . $r->urlSprintf(".%d.%t%o") . $uri);
        }

        return RedirectResponse::create(str_replace('http:', 'https:', $c->request()->getUri()));
      }
    );
  }
}
