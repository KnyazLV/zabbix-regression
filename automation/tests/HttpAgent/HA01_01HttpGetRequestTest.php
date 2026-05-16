<?php

namespace Tests\HttpAgent;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\BaseTestCase;
use Tests\Core\ItemData;
use Tests\Core\ZabbixTarget;

class HA01_01HttpGetRequestTest extends BaseTestCase
{
  #[DataProvider('zabbixTargets')]
  public function testHttpGetRequestReturnsResponseBody(ZabbixTarget $target): void
  {
    $this->loginAsAdmin($target);

    $host = $this->createTemporaryHost($target, 'HA01-01');
    $itemsPage = $host->openItemsPage();

    $item = $this->httpGetResponseBodyItem();

    $itemsPage
      ->createItem($item)
      ->testItem();

    $this->assertStringContainsString(
      'delectus aut autem',
      $itemsPage->getTestResultText(),
    );

    $itemsPage
      ->closeTestDialog()
      ->submitItemForm();

    $this->assertTrue($itemsPage->hasEnabledItem($item->name));
  }

  private function httpGetResponseBodyItem(): ItemData
  {
    return new ItemData(
      name: 'GET Response Body',
      type: 'HTTP agent',
      key: 'http.get.response.body',
      typeOfInformation: 'Text',
      updateInterval: '1m',
      url: 'https://jsonplaceholder.typicode.com/todos/1',
      requestMethod: 'GET',
      retrieveMode: 'Body',
    );
  }
}