<?php

namespace Tests\Pages;

use Facebook\WebDriver\Exception\TimeoutException;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;

class HostsPage extends BasePage
{
    private WebDriverBy $pageTitle;
    private WebDriverBy $createHostButton;

    private WebDriverBy $hostNameInput;
    private WebDriverBy $hostGroupInput;

    private WebDriverBy $addInterfaceButton;
    private WebDriverBy $agentInterfaceButton;
    private WebDriverBy $dnsRadioButton;
    private WebDriverBy $dnsInput;

    private WebDriverBy $addButton;

    private WebDriverBy $hostAddedMessage;
    private WebDriverBy $hostDeletedMessage;
    private WebDriverBy $formErrorMessages;

    public function __construct(RemoteWebDriver $driver)
    {
        parent::__construct($driver);

        $this->pageTitle = WebDriverBy::id('page-title-general');
        $this->createHostButton = WebDriverBy::xpath("//button[normalize-space(text())='Create host']");

        $this->hostNameInput = WebDriverBy::id('host');
        $this->hostGroupInput = WebDriverBy::id('groups__ms');

        $this->addInterfaceButton = WebDriverBy::xpath("//button[@aria-label='Add new interface']");
        $this->agentInterfaceButton = WebDriverBy::xpath("//a[@aria-label='Agent']");
        $this->dnsInput = WebDriverBy::id('interfaces_1_dns');
        $this->dnsRadioButton = WebDriverBy::xpath("//ul[@id='interfaces_1_useip']//label[text()='DNS']");

        $this->addButton = WebDriverBy::xpath("//div[@class='overlay-dialogue-footer']//button[normalize-space(text())='Add']");

        $this->hostAddedMessage = WebDriverBy::xpath(
            "//*[contains(@class, 'msg-good') and contains(., 'Host added')]"
        );

        $this->hostDeletedMessage = WebDriverBy::xpath(
            "//*[contains(@class, 'msg-good') and contains(., 'Host deleted')]"
        );

        $this->formErrorMessages = WebDriverBy::xpath(
            "//*[contains(@class, 'msg-bad') or contains(@class, 'error') or contains(@class, 'red')]"
        );
    }

    public function isOpened(): bool
    {
        $this->waitForVisibility($this->pageTitle);
        $this->waitForVisibility($this->createHostButton);

        return str_contains($this->driver->getCurrentURL(), 'action=host.list');
    }

    public function getCurrentUrl(): string
    {
        return $this->driver->getCurrentURL();
    }

    public function createHost(
        string $hostName,
        string $hostGroup = 'Test',
        ?string $agentDnsName = null,
    ): self {
        $this->waitForClickable($this->createHostButton)->click();

        $this->setHostName($hostName);
        $this->setHostGroup($hostGroup);

        if ($agentDnsName !== null) {
            $this->addAgentInterfaceWithDns($agentDnsName);
        }

        $this->waitForClickable($this->addButton)->click();

        return $this;
    }

    public function isHostCreatedMessageVisible(): bool
    {
        try {
            $this->waitForVisibility($this->hostAddedMessage, 20);
            return true;
        } catch (TimeoutException) {
            return false;
        }
    }

    public function hasExactlyOneHost(string $hostName): bool
    {
        return count($this->driver->findElements($this->hostRow($hostName))) === 1;
    }

    public function openItemsForHost(string $hostName): void
    {
        $row = $this->waitForPresence($this->hostRow($hostName));

        $row
            ->findElement(WebDriverBy::xpath(".//a[text()='Items']"))
            ->click();

        $this->driver
            ->wait(15, 250)
            ->until(fn() => str_contains($this->driver->getCurrentURL(), 'action=item.list'));
    }

    public function deleteHost(string $hostName): self
    {
        if (!$this->hasExactlyOneHost($hostName)) {
            return $this;
        }

        $this->selectHost($hostName);

        $deleteButton = WebDriverBy::xpath("//button[normalize-space(text())='Delete']");
        $this->waitForClickable($deleteButton)->click();

        $this->acceptAlertIfPresent();
        $this->waitForVisibility($this->hostDeletedMessage, 20);

        return $this;
    }

    public function getFormErrors(): string
    {
        $errors = $this->driver->findElements($this->formErrorMessages);

        return trim(implode("\n", array_map(
            fn($element) => $element->getText(),
            $errors,
        )));
    }

    private function setHostName(string $hostName): void
    {
        $input = $this->waitForVisibility($this->hostNameInput);
        $input->clear();
        $input->sendKeys($hostName);
    }

    private function setHostGroup(string $hostGroup): void
    {
        $input = $this->waitForVisibility($this->hostGroupInput);
        $input->click();
        $input->clear();
        $input->sendKeys($hostGroup);

        $option = WebDriverBy::xpath(
            sprintf(
                "//li[.='%s'] | //*[contains(@class, 'multiselect')]//*[.='%s']",
                $hostGroup,
                $hostGroup,
            )
        );

        try {
            $this->waitForClickable($option, 5)->click();
        } catch (TimeoutException) {
            $input->sendKeys(WebDriverKeys::ENTER);
        }
    }

    private function addAgentInterfaceWithDns(string $dnsName): void
    {
        $this->waitForClickable($this->addInterfaceButton)->click();

        if (count($this->driver->findElements($this->agentInterfaceButton)) > 0) {
            $this->waitForClickable($this->agentInterfaceButton)->click();
        }

        $this->waitForClickable($this->dnsRadioButton)->click();

        $dnsInput = $this->waitForClickable($this->dnsInput, 5);
        $dnsInput->clear();
        $dnsInput->sendKeys($dnsName);
    }

    private function selectHost(string $hostName): void
    {
        $row = $this->waitForPresence($this->hostRow($hostName));

        $checkbox = $row->findElement(
            WebDriverBy::xpath(".//input[starts-with(@id, 'hostids_')]")
        );

        $this->driver->executeScript(
            'arguments[0].scrollIntoView({block: "center"});',
            [$checkbox],
        );

        if (!$checkbox->isSelected()) {
            $this->driver->executeScript(
                'arguments[0].click();',
                [$checkbox],
            );
        }
    }

    private function hostRow(string $hostName): WebDriverBy
    {
        return WebDriverBy::xpath(
            sprintf(
                "//table[contains(@class, 'list-table')]//tr[.//td[contains(@class, 'nowrap')]//a[text()='%s']]",
                $hostName,
            )
        );
    }

    private function acceptAlertIfPresent(): void
    {
        try {
            $this->driver->switchTo()->alert()->accept();
        } catch (\Throwable) {
            // No browser alert.
        }
    }
}