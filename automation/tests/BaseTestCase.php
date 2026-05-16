<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use PHPUnit\Framework\TestCase;
use Tests\Core\ZabbixTarget;
use Tests\Fixtures\ZabbixHostFixture;
use Tests\Pages\LoginPage;

abstract class BaseTestCase extends TestCase
{
  protected RemoteWebDriver $driver;

  /** @var ZabbixHostFixture[] */
  private array $hostFixtures = [];

  protected function setUp(): void
  {
    parent::setUp();

    $options = new ChromeOptions();

    $options->addArguments([
      '--window-size=1920,1080',
      '--no-sandbox',
      '--disable-dev-shm-usage',
    ]);

    $capabilities = DesiredCapabilities::chrome();
    $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

    $this->driver = RemoteWebDriver::create(
      getenv('SELENIUM_URL'),
      $capabilities,
      30000,
      120000,
    );
  }

  protected function tearDown(): void
  {
    try {
      if ($this->status()->isSuccess()) {
        foreach (array_reverse($this->hostFixtures) as $fixture) {
          $fixture->delete();
        }

        $this->hostFixtures = [];
      }
    } finally {
      if (isset($this->driver)) {
        $this->driver->quit();
      }

      parent::tearDown();
    }
  }

  protected function loginAsAdmin(ZabbixTarget $target): void
  {
    $loginPage = new LoginPage($this->driver, $target->url);

    $loginPage
      ->open()
      ->login(
        getenv('ZBX_USERNAME'),
        getenv('ZBX_PASSWORD'),
      );
  }

  protected function createTemporaryHost(
    ZabbixTarget $target,
    string $testCaseId,
    ?string $agentDnsName = null,
  ): ZabbixHostFixture {
    $fixture = new ZabbixHostFixture(
      driver: $this->driver,
      target: $target,
      testCaseId: $testCaseId,
      agentDnsName: $agentDnsName,
    );

    $this->hostFixtures[] = $fixture;

    $fixture->create();

    return $fixture;
  }

  public static function zabbixTargets(): array
  {
    return [
      'Zabbix 7.0.26' => [
        new ZabbixTarget(
          version: '7.0.26',
          url: getenv('ZBX70_URL'),
          agentDns: getenv('ZBX70_AGENT_DNS'),
        ),
      ],

      'Zabbix 7.4.10' => [
        new ZabbixTarget(
          version: '7.4.10',
          url: getenv('ZBX74_URL'),
          agentDns: getenv('ZBX74_AGENT_DNS'),
        ),
      ],
    ];
  }
}