<?php

namespace Tests\Components;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Tests\Pages\BasePage;

class Sidebar extends BasePage
{
  private WebDriverBy $monitoringMenu;
  private WebDriverBy $dataCollectionMenu;

  private WebDriverBy $dataCollectionHosts;
  private WebDriverBy $monitoringLatestData;

  public function __construct(RemoteWebDriver $driver)
  {
    parent::__construct($driver);

    $this->monitoringMenu = WebDriverBy::id('view');
    $this->dataCollectionMenu = WebDriverBy::id('config');

    $this->dataCollectionHosts = WebDriverBy::xpath("//li[@id='config']//a[normalize-space(text())='Hosts']");
    $this->monitoringLatestData = WebDriverBy::xpath("//li[@id='view']//a[normalize-space(text())='Latest data']");
  }

  public function openDataCollectionHosts(): self
  {
    $this->ensureMenuIsExpanded($this->dataCollectionMenu, $this->dataCollectionHosts);
    $this->waitForClickable($this->dataCollectionHosts)->click();

    return $this;
  }

  public function openLatestData(): self
  {
    $this->ensureMenuIsExpanded($this->monitoringMenu, $this->monitoringLatestData);
    $this->waitForClickable($this->monitoringLatestData)->click();

    return $this;
  }

  private function ensureMenuIsExpanded(WebDriverBy $parentLocator, WebDriverBy $childLocator): void
  {
    $parent = $this->waitForPresence($parentLocator);
    $class = $parent->getAttribute('class') ?? '';

    if (!str_contains($class, 'is-expanded')) {
      $parent
        ->findElement(WebDriverBy::tagName('a'))
        ->click();
    }

    $this->waitForVisibility($childLocator);
  }
}