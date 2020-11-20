<?php

namespace koulab\UltimateTwitter\Selenium\TwitterWeb\Pages;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use koulab\UltimateTwitter\Selenium\TwitterWeb\TwitterWeb;

class AccountLocked extends TwitterWeb{

    /*
     * If account locked get redirect to https://twitter.com/account/access
     */
    public function __construct(RemoteWebDriver $driver)
    {
        parent::__construct($driver);

        $this->waitWithXpath("//form[@action='/account/access']/input[@type='submit']",5);
    }

    public function start(string $gRecaptchaResponse) : HomeTimeLinePage{

        $this
            ->getDriver()
            ->findElement(WebDriverBy::xpath("//form[@action='/account/access']/input[@type='submit']"))
            ->click()
        ;

        // captcha site key=  ??

        $captcha = $this->getDriver()
            ->findElement(WebDriverBy::id('g-recaptcha-response'))
        ;
        $this
            ->getDriver()
            ->executeScript('arguments[0].value = "{'.$gRecaptchaResponse.'}";',[$captcha])
        ;

        $this->waitWithXpath(WebDriverBy::cssSelector("#continue_button"),30);
        $this
            ->getDriver()
            ->findElement(WebDriverBy::xpath("#continue_button"))
            ->click()
        ;

        $this->waitWithXpath("//form/input[@type='submit']",5);
        $this
            ->getDriver()
            ->findElement(WebDriverBy::xpath("//form/input[@type='submit']"))
            ->click()
        ;

        return new HomeTimeLinePage($this->getDriver());
    }
}