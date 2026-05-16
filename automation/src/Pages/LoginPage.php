<?php

namespace Tests\Pages;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

class LoginPage extends BasePage
{
    private string $url;

    private WebDriverBy $username;
    private WebDriverBy $password;
    private WebDriverBy $submitButton;

    public function __construct(RemoteWebDriver $driver, string $baseUrl)
    {
        parent::__construct($driver);

        $this->url = rtrim($baseUrl, '/') . '/index.php';

        $this->username = WebDriverBy::id('name');
        $this->password = WebDriverBy::id('password');
        $this->submitButton = WebDriverBy::id('enter');
    }

    public function open(): self
    {
        $this->driver->get($this->url);
        return $this;
    }

    public function login(string $username, string $password): self
    {
        $this->waitForVisibility($this->username)->sendKeys($username);
        $this->driver->findElement($this->password)->sendKeys($password);
        $this->driver->findElement($this->submitButton)->click();

        return $this;
    }
}