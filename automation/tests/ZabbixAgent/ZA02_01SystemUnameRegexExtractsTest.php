<?php

namespace Tests\ZabbixAgent;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\BaseTestCase;
use Tests\Core\ItemData;
use Tests\Core\ZabbixTarget;

class ZA02_01SystemUnameRegexExtractsTest extends BaseTestCase
{
  #[DataProvider('zabbixTargets')]
  public function testSystemUnameRegexExtractsLinux(ZabbixTarget $target): void
  {
    $this->loginAsAdmin($target);

    $host = $this->createTemporaryHost(
      target: $target,
      testCaseId: 'ZA02-01',
      agentDnsName: $target->agentDns,
    );

    $itemsPage = $host->openItemsPage();

    $item = $this->systemUnameRegexItem();

    $itemsPage
      ->createItem($item)
      ->addPreprocessing(
        type: 'Regular expression',
        firstParameter: '^(Linux).*$',
        secondParameter: '\1',
      )
      ->testItem();

    $this->assertSame(
      'Linux',
      $itemsPage->getTestResultText(),
    );

    $itemsPage
      ->closeTestDialog()
      ->submitItemForm();

    $this->assertTrue($itemsPage->hasEnabledItem($item->name));
  }

  private function systemUnameRegexItem(): ItemData
  {
    return new ItemData(
      name: 'System Uname Regex Test',
      type: 'Zabbix agent',
      key: 'system.uname',
      typeOfInformation: 'Character',
      updateInterval: '30s',
    );
  }
}