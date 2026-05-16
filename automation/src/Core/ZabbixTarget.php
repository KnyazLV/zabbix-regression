<?php

namespace Tests\Core;

class ZabbixTarget
{
  public function __construct(
    public string $version,
    public string $url,
    public string $agentDns,
  ) {
  }
}