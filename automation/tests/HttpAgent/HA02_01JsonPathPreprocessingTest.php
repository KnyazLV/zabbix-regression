<?php

namespace Tests\HttpAgent;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\BaseTestCase;
use Tests\Core\ItemData;
use Tests\Core\ZabbixTarget;

class HA02_01JsonPathPreprocessingTest extends BaseTestCase
{
  #[DataProvider('zabbixTargets')]
  public function testJsonPathExtractsExpectedValue(ZabbixTarget $target): void
  {
    $this->loginAsAdmin($target);

    $host = $this->createTemporaryHost($target, 'HA02-01');
    $itemsPage = $host->openItemsPage();

    $item = $this->jsonPathExtractTitleItem();

    $itemsPage
      ->createItem($item)
      ->addJsonPathPreprocessing('$.title')
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

  private function jsonPathExtractTitleItem(): ItemData
  {
    return new ItemData(
      name: 'JSONPath Extract Title',
      type: 'HTTP agent',
      key: 'http.jsonpath.extract.title',
      typeOfInformation: 'Text',
      updateInterval: '1m',
      url: 'https://jsonplaceholder.typicode.com/todos/1',
      requestMethod: 'GET',
      requiredStatusCodes: '200',
      retrieveMode: 'Body',
    );
  }
}