<?php

namespace Tests\ZabbixAgent;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\BaseTestCase;
use Tests\Core\ItemData;
use Tests\Core\ZabbixTarget;

class ZA01_01PassiveCheckTest extends BaseTestCase
{
  #[DataProvider('zabbixTargets')]
  public function testAgentPingReturnsOne(ZabbixTarget $target): void
  {
    $this->loginAsAdmin($target);

    $host = $this->createTemporaryHost(
      target: $target,
      testCaseId: 'ZA01-01',
      agentDnsName: $target->agentDns,
    );

    $itemsPage = $host->openItemsPage();

    $item = $this->agentPingItem();

    $itemsPage
      ->createItem($item)
      ->testItem();

    $testResult = $itemsPage->getTestResultText();

    $this->assertSame(
      '1',
      $testResult,
      sprintf('Expected agent.ping result "1", actual result: %s', $testResult),
    );

    $itemsPage
      ->closeTestDialog()
      ->submitItemForm();

    $this->assertTrue($itemsPage->hasEnabledItem($item->name));
  }

  private function agentPingItem(): ItemData
  {
    return new ItemData(
      name: 'Agent Ping Test',
      type: 'Zabbix agent',
      key: 'agent.ping',
      typeOfInformation: 'Numeric (unsigned)',
      updateInterval: '30s',
    );
  }
}