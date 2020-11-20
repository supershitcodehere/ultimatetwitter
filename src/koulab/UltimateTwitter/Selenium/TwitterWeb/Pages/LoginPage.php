<?php
namespace koulab\UltimateTwitter\Selenium\TwitterWeb\Pages;

use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\TimeoutException;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use koulab\UltimateTwitter\Selenium\TwitterWeb\TwitterWeb;
use Symfony\Component\DomCrawler\Crawler;

class LoginPage extends TwitterWeb {

    public function login(string $screen_name,string $password,string $emailAddress = null,string $phoneNumber = null): HomeTimeLinePage{
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

        //Check "Verify your identity" Page
        try {
            $this->waitWithXpath("//*[@id='login-challenge-form']", 5);
            $type = $this->getDriver()->findElement(WebDriverBy::name('challenge_type'))->getAttribute("value");
            //challenge_response
            $ans = $emailAddress;
            if($type == 'RetypePhoneNumber'){
                $ans = $phoneNumber;
            }
            $this->waitWithXpath("//input[@id='challenge_response']",3);
            $this
                ->getDriver()
                ->findElement(WebDriverBy::id("challenge_response"))
                ->sendKeys($ans)
            ;
            $this
                ->getDriver()
                ->findElement(WebDriverBy::id("email_challenge_submit"))
                ->click()
            ;
        }catch (NoSuchElementException | TimeoutException $e){

        }

        return new HomeTimeLinePage($this->getDriver());

    }
}