<?php
namespace Packaged\Routing;

use Packaged\Context\Context;

class HealthCheckCondition implements Condition
{
  public function match(Context $context): bool
  {
    $r = $context->request();
    $hasHeader = false;
    $hasHeader = $hasHeader || $r->headers->has('packaged-health-check');
    $hasHeader = $hasHeader || stripos($r->userAgent(), 'kube-probe') !== false;
    $hasHeader = $hasHeader || stripos($r->userAgent(), 'googlehc') !== false;
    $hasHeader = $hasHeader || stripos($r->userAgent(), 'elb-healthchecker') !== false;
    return $hasHeader || stripos($r->path(), '_ah/health') !== false;
  }
}
