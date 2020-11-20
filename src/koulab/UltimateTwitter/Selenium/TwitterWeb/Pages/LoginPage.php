<?php
namespace koulab\UltimateTwitter\Selenium\TwitterWeb\Pages;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use koulab\UltimateTwitter\Selenium\TwitterWeb\TwitterWeb;

class LoginPage extends TwitterWeb {

    public function login(string $screen_name,string $password): HomeTimeLinePage{
        $this->getDriver()->get('https://twitter.com/login');

        $this->waitWithXpath("//input[@name='session[username_or_email]']",10);
        $this->waitWithXpath("//input[@name='session[password]']",10);

        $this
            ->getDriver()
            ->findElement(WebDriverBy::xpath("//input[@name='session[username_or_email]']"))
            ->sendKeys($screen_name)
        ;

        $this
            ->getDriver()
            ->findElement(WebDriverBy::xpath("//input[@name='session[password]']"))
            ->sendKeys($password)
        ;

        $this
            ->getDriver()
            ->findElement(WebDriverBy::xpath("//div[@data-testid='LoginForm_Login_Button']"))
            ->click()
        ;

        return new HomeTimeLinePage($this->getDriver());

    }
}