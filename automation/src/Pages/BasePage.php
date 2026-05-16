<?php

namespace Tests\Pages;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverElement;

abstract class BasePage
{
  protected RemoteWebDriver $driver;

  public function __construct(RemoteWebDriver $driver)
  {
    $this->driver = $driver;
  }

  protected function waitForPresence(WebDriverBy $locator, int $timeout = 15): WebDriverElement
  {
    return $this->driver
      ->wait($timeout, 250)
      ->until(WebDriverExpectedCondition::presenceOfElementLocated($locator));
  }

  protected function waitForVisibility(WebDriverBy $locator, int $timeout = 15): WebDriverElement
  {
    return $this->driver
      ->wait($timeout, 250)
      ->until(WebDriverExpectedCondition::visibilityOfElementLocated($locator));
  }

  protected function waitForClickable(WebDriverBy $locator, int $timeout = 15): WebDriverElement
  {
    return $this->driver
      ->wait($timeout, 250)
      ->until(WebDriverExpectedCondition::elementToBeClickable($locator));
  }

}