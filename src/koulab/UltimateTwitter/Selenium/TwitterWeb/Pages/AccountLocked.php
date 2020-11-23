<?php

namespace koulab\UltimateTwitter\Selenium\TwitterWeb\Pages;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use koulab\UltimateTwitter\Selenium\TwitterWeb\TwitterWeb;

class AccountLocked extends TwitterWeb{

    /*
     * If account locked get redirect to https://twitter.com/account/access
     */
    public function __construct(RemoteWebDriver $driver)
    {
        parent::__construct($driver);

        $this->getDriver()->wait(5,500)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(
                WebDriverBy::xpath("//form[@action='/account/access']/input[@type='submit']")
            )
        );
    }

    public function start(string $gRecaptchaResponse) : HomeTimeLinePage{
        try {
            $this
                ->getDriver()
                ->findElement(WebDriverBy::xpath("//form[@action='/account/access']/input[@type='submit']"))
                ->click();
        }catch (\Exception $e){ }

        $this->getDriver()
            ->executeScript('var element=document.getElementById("g-recaptcha-response"); element.style.display="";')
        ;
        $this->getDriver()
            ->executeScript('var cb=document.getElementById("continue_button"); cb.style.display="";')
        ;
        $this->getDriver()
            ->executeScript('var vs=document.getElementById("verification_string"); vs.value="'.$gRecaptchaResponse.'";')
        ;


        sleep(1);

        $this->getDriver()
            ->findElement(WebDriverBy::id('g-recaptcha-response'))
            ->sendKeys(trim($gRecaptchaResponse))
        ;
        sleep(1);

        $this->getDriver()->wait(10,500)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(
                WebDriverBy::id("continue_button")
            )
        );

        $this
            ->getDriver()
            ->findElement(WebDriverBy::id("continue_button"))
            ->click()
        ;

        try {
            $this->getDriver()->wait(10, 500)->until(
                WebDriverExpectedCondition::presenceOfElementLocated(
                    WebDriverBy::xpath("//form/input[@type='submit']")
                )
            );

            $this
                ->getDriver()
                ->findElement(WebDriverBy::xpath("//form/input[@type='submit']"))
                ->click()
            ;
        }catch (\Exception $e){ }

        sleep(3);
        $this
            ->getDriver()
            ->get('https://twitter.com/home')
        ;

        return new HomeTimeLinePage($this->getDriver());
    }
}