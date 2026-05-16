<?php

namespace Tests\Fixtures;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Tests\Components\Sidebar;
use Tests\Core\ZabbixTarget;
use Tests\Pages\HostsPage;
use Tests\Pages\ItemsPage;

class ZabbixHostFixture
{
    public readonly string $hostName;

    public function __construct(
        private readonly RemoteWebDriver $driver,
        private readonly ZabbixTarget $target,
        string $testCaseId,
        private readonly string $hostGroup = 'Test',
        private readonly ?string $agentDnsName = null,
    ) {
        $this->hostName = sprintf(
            'TMP-%s-%s-%s',
            $testCaseId,
            str_replace('.', '-', $target->version),
            date('His'),
        );
    }

    public function create(): self
    {
        $hostsPage = $this->openHostsPage();

        $hostsPage->createHost(
            hostName: $this->hostName,
            hostGroup: $this->hostGroup,
            agentDnsName: $this->agentDnsName,
        );

        if (!$hostsPage->isHostCreatedMessageVisible()) {
            throw new \RuntimeException(sprintf(
                'Temporary host "%s" was not created. URL: %s. Errors: %s',
                $this->hostName,
                $hostsPage->getCurrentUrl(),
                $hostsPage->getFormErrors(),
            ));
        }

        if (!$hostsPage->hasExactlyOneHost($this->hostName)) {
            throw new \RuntimeException(sprintf(
                'Temporary host "%s" was created, but was not found in hosts table.',
                $this->hostName,
            ));
        }

        return $this;
    }

    public function openItemsPage(): ItemsPage
    {
        $hostsPage = $this->openHostsPage();
        $hostsPage->openItemsForHost($this->hostName);

        $itemsPage = new ItemsPage($this->driver);

        if (!$itemsPage->isOpened()) {
            throw new \RuntimeException(sprintf(
                'Items page was not opened for host "%s". Current URL: %s',
                $this->hostName,
                $itemsPage->getCurrentUrl(),
            ));
        }

        return $itemsPage;
    }

    public function delete(): void
    {
        $this->driver->get(rtrim($this->target->url, '/') . '/zabbix.php?action=host.list');

        $hostsPage = new HostsPage($this->driver);

        if ($hostsPage->isOpened()) {
            $hostsPage->deleteHost($this->hostName);
        }
    }

    private function openHostsPage(): HostsPage
    {
        $sidebar = new Sidebar($this->driver);
        $sidebar->openDataCollectionHosts();

        $hostsPage = new HostsPage($this->driver);

        if (!$hostsPage->isOpened()) {
            throw new \RuntimeException(sprintf(
                'Hosts page was not opened. Current URL: %s',
                $hostsPage->getCurrentUrl(),
            ));
        }

        return $hostsPage;
    }
}