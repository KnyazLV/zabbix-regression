<?php

namespace Tests\Pages;

use Facebook\WebDriver\Exception\TimeoutException;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Tests\Core\ItemData;

class ItemsPage extends BasePage
{
    private string $dialogXpath;

    private WebDriverBy $pageTitle;
    private WebDriverBy $createItemButton;
    private WebDriverBy $itemForm;

    private WebDriverBy $nameInput;
    private WebDriverBy $typeSelect;
    private WebDriverBy $keyInput;
    private WebDriverBy $typeOfInformationSelect;
    private WebDriverBy $unitsInput;
    private WebDriverBy $updateIntervalInput;

    private WebDriverBy $urlInput;
    private WebDriverBy $requestMethodSelect;
    private WebDriverBy $requiredStatusCodesInput;
    private WebDriverBy $retrieveModeSelect;

    private WebDriverBy $preprocessingTab;
    private WebDriverBy $addPreprocessingStepButton;
    private WebDriverBy $preprocessingTypeSelect;
    private WebDriverBy $preprocessingFirstParameterInput;
    private WebDriverBy $preprocessingSecondParameterInput;

    private WebDriverBy $addButton;

    private WebDriverBy $itemAddedMessage;
    private WebDriverBy $formErrorMessages;

    public function __construct(RemoteWebDriver $driver)
    {
        parent::__construct($driver);

        $this->dialogXpath = "//div[contains(@class, 'overlay-dialogue') and .//*[contains(text(), 'New item')]]";

        $this->pageTitle = WebDriverBy::id('page-title-general');
        $this->createItemButton = WebDriverBy::xpath("//button[text()='Create item']");
        $this->itemForm = WebDriverBy::xpath($this->dialogXpath);

        $this->nameInput = WebDriverBy::xpath($this->dialogXpath . "//input[@id='name']");
        $this->typeSelect = WebDriverBy::xpath($this->dialogXpath . "//z-select[@id='type']");
        $this->keyInput = WebDriverBy::xpath($this->dialogXpath . "//input[@id='key']");
        $this->typeOfInformationSelect = WebDriverBy::xpath($this->dialogXpath . "//z-select[@id='value_type']");
        $this->unitsInput = WebDriverBy::xpath($this->dialogXpath . "//input[@id='units']");
        $this->updateIntervalInput = WebDriverBy::xpath($this->dialogXpath . "//input[@id='delay']");

        $this->urlInput = WebDriverBy::xpath($this->dialogXpath . "//div[@id='js-item-url-field']//input[@id='url']");
        $this->requestMethodSelect = WebDriverBy::xpath($this->dialogXpath . "//z-select[@id='request_method']");
        $this->requiredStatusCodesInput = WebDriverBy::xpath($this->dialogXpath . "//input[@id='status_codes']");
        $this->retrieveModeSelect = WebDriverBy::xpath($this->dialogXpath . "//z-select[@id='retrieve_mode']");

        $this->preprocessingTab = WebDriverBy::xpath($this->dialogXpath . "//*[@id='tab_processing-tab']");
        $this->addPreprocessingStepButton = WebDriverBy::xpath($this->dialogXpath . "//*[@id='param_add']");
        $this->preprocessingTypeSelect = WebDriverBy::xpath($this->dialogXpath . "//z-select[@id='preprocessing_0_type']");
        $this->preprocessingFirstParameterInput = WebDriverBy::xpath($this->dialogXpath . "//*[@id='preprocessing_0_params_0']");
        $this->preprocessingSecondParameterInput = WebDriverBy::xpath($this->dialogXpath . "//*[@id='preprocessing_0_params_1']");

        $this->addButton = WebDriverBy::xpath($this->dialogXpath . "//div[contains(@class, 'overlay-dialogue-footer')]//button[text()='Add']");

        $this->itemAddedMessage = WebDriverBy::xpath(
            "//*[contains(@class, 'msg-good') and contains(., 'Item added')]"
        );

        $this->formErrorMessages = WebDriverBy::xpath(
            "//*[contains(@class, 'msg-bad') or contains(@class, 'error') or contains(@class, 'red')]"
        );
    }

    public function isOpened(): bool
    {
        $this->waitForVisibility($this->pageTitle);
        $this->waitForVisibility($this->createItemButton);

        return str_contains($this->driver->getCurrentURL(), 'action=item.list');
    }

    public function getCurrentUrl(): string
    {
        return $this->driver->getCurrentURL();
    }

    // #region CreateItem

    public function createItem(ItemData $item): self
    {
        $this->openCreateItemForm();

        $this->setInput($this->nameInput, $item->name);
        $this->selectZSelectByTitle($this->typeSelect, $item->type);

        $this->setInput($this->keyInput, $item->key);
        $this->selectZSelectByTitle($this->typeOfInformationSelect, $item->typeOfInformation);
        $this->setInput($this->updateIntervalInput, $item->updateInterval);

        if ($item->units !== null) {
            $this->setInput($this->unitsInput, $item->units);
        }

        if ($item->url !== null) {
            $this->setInput($this->urlInput, $item->url);
        }

        if ($item->requestMethod !== null) {
            $this->selectZSelectByTitle($this->requestMethodSelect, $item->requestMethod);
        }

        if ($item->requiredStatusCodes !== null) {
            $this->setInput($this->requiredStatusCodesInput, $item->requiredStatusCodes);
        }

        if ($item->retrieveMode !== null && $this->isElementPresent($this->retrieveModeSelect)) {
            $this->selectZSelectByTitle($this->retrieveModeSelect, $item->retrieveMode);
        }

        return $this;
    }

    public function addJsonPathPreprocessing(string $jsonPath): self
    {
        return $this->addPreprocessing(
            type: 'JSONPath',
            firstParameter: $jsonPath,
        );
    }

    public function addPreprocessing(
        string $type,
        string $firstParameter,
        ?string $secondParameter = null,
    ): self {
        $this->waitForClickable($this->preprocessingTab)->click();
        $this->waitForClickable($this->addPreprocessingStepButton)->click();

        $this->selectZSelectByTitle($this->preprocessingTypeSelect, $type);
        $this->setInput($this->preprocessingFirstParameterInput, $firstParameter);

        if ($secondParameter !== null) {
            $this->setInput($this->preprocessingSecondParameterInput, $secondParameter);
        }

        return $this;
    }

    public function submitItemForm(): self
    {
        $this->waitForClickable($this->addButton, 5)->click();
        $this->waitForVisibility($this->itemAddedMessage, 10);

        return $this;
    }


    private function openCreateItemForm(): void
    {
        $this->waitForClickable($this->createItemButton)->click();
        $this->waitForVisibility($this->itemForm, 10);
    }

    private function setInput(WebDriverBy $locator, string $value): void
    {
        $input = $this->waitForVisibility($locator, 10);
        $input->clear();
        $input->sendKeys($value);
    }

    private function selectZSelectByTitle(WebDriverBy $locator, string $title): void
    {
        $select = $this->waitForPresence($locator, 10);

        $result = $this->driver->executeScript(
            "
            const select = arguments[0];
            const title = arguments[1];

            const option = Array.from(select.querySelectorAll('li')).find((item) => {
                return item.getAttribute('title') === title || item.textContent.trim() === title;
            });

            if (!option) {
                return false;
            }

            const value = option.getAttribute('value');
            const text = option.textContent.trim();

            const button = select.querySelector('button');
            const input = select.querySelector('input[type=\"hidden\"]');

            select.setAttribute('value', value);

            if (input) {
                input.value = value;
                input.dispatchEvent(new Event('input', { bubbles: true }));
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }

            if (button) {
                button.innerText = text;
            }

            select.dispatchEvent(new Event('input', { bubbles: true }));
            select.dispatchEvent(new Event('change', { bubbles: true }));

            return true;
            ",
            [$select, $title],
        );

        if ($result !== true) {
            throw new \RuntimeException(sprintf('Option "%s" was not found.', $title));
        }
    }

    // #region TestItem

    public function testItem(): self
    {
        $testButton = WebDriverBy::xpath(
            $this->dialogXpath . "//div[contains(@class, 'overlay-dialogue-footer')]//button[text()='Test']"
        );

        $this->waitForClickable($testButton, 5)->click();

        $getValueAndTestButton = WebDriverBy::xpath(
            "//div[contains(@class, 'overlay-dialogue-footer')]//button[text()='Get value and test']"
        );

        $this->waitForClickable($getValueAndTestButton, 5)->click();
        $this->waitForAnyTestResult();

        return $this;
    }

    public function getTestResultText(): string
    {
        $compactResult = $this->driver->findElements(
            WebDriverBy::xpath(
                "//div[contains(@class, 'final-result-row')]"
                . "/span[not(contains(@class, 'final-result-action'))]"
            )
        );

        if (count($compactResult) > 0) {
            return trim($compactResult[0]->getText());
        }

        $ellipsisResult = $this->driver->findElements(
            WebDriverBy::xpath(
                "//*[contains(@class, 'item-test-result')]"
            )
        );

        if (count($ellipsisResult) > 0) {
            $hintResult = $ellipsisResult[0]->findElements(
                WebDriverBy::xpath(".//*[@data-hintbox-contents]")
            );

            if (count($hintResult) > 0) {
                $hint = trim((string) $hintResult[0]->getAttribute('data-hintbox-contents'));

                if ($hint !== '') {
                    return trim(html_entity_decode($hint, ENT_QUOTES | ENT_HTML5));
                }
            }

            $visibleText = trim($ellipsisResult[0]->getText());

            if ($visibleText !== '') {
                return $visibleText;
            }
        }

        $plainLegacyResult = $this->driver->findElements(
            WebDriverBy::xpath(
                "//div[contains(@class, 'table-forms-separator')]"
                . "/div/span[not(contains(@class, 'grey'))]"
            )
        );

        if (count($plainLegacyResult) > 0) {
            return trim($plainLegacyResult[0]->getText());
        }

        return '';
    }

    private function waitForAnyTestResult(): void
    {
        $this->driver
            ->wait(8, 250)
            ->until(function () {
                return $this->getTestResultText() !== '';
            });
    }

    public function closeTestDialog(): self
    {
        $cancelButton = WebDriverBy::xpath(
            "//form[@id='preprocessing-test-form']"
            . "/ancestor::div[contains(@class, 'overlay-dialogue')]"
            . "//div[contains(@class, 'overlay-dialogue-footer')]"
            . "//button[contains(@class, 'js-cancel') and text()='Cancel']"
        );

        $this->waitForClickable($cancelButton, 5)->click();

        return $this;
    }
    // #region ItemTable

    public function hasEnabledItem(string $itemName): bool
    {
        try {
            $this->driver
                ->wait(10, 250)
                ->until(function () use ($itemName) {
                    $rows = $this->driver->findElements($this->itemRow($itemName));

                    if (count($rows) !== 1) {
                        return false;
                    }

                    $enabledStatus = $rows[0]->findElements(
                        WebDriverBy::xpath(".//a[contains(@class, 'js-disable-item') and normalize-space(text())='Enabled']")
                    );

                    return count($enabledStatus) === 1;
                });

            return true;
        } catch (TimeoutException) {
            return false;
        }
    }


    private function isElementPresent(WebDriverBy $locator): bool
    {
        return count($this->driver->findElements($locator)) > 0;
    }

    private function itemRow(string $itemName): WebDriverBy
    {
        return WebDriverBy::xpath(
            sprintf(
                "//table[contains(@class, 'list-table')]//tr[.//td[contains(@class, 'wordbreak')]//a[text()='%s']]",
                $itemName,
            )
        );
    }
}