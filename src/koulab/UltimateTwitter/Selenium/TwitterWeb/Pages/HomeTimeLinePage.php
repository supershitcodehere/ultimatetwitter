<?php
namespace koulab\UltimateTwitter\Selenium\TwitterWeb\Pages;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use koulab\UltimateTwitter\Exception\UltimateTwitterException;
use koulab\UltimateTwitter\Selenium\TwitterWeb\TwitterWeb;

class HomeTimeLinePage extends TwitterWeb {

    public function __construct(RemoteWebDriver $driver)
    {
        parent::__construct($driver);

        $this->waitWithXpath("//a[@data-testid='SideNav_NewTweet_Button']");
    }

    private function intentAction($url){
        $this->getDriver()->get($url);
        $this
            ->waitWithXpath("//div[@data-testid='confirmationSheetConfirm']")
        ;
        $this
            ->getDriver()
            ->findElement(WebDriverBy::xpath("//div[@data-testid='confirmationSheetConfirm']"))
            ->click()
        ;
        sleep(3);
    }

    public function favorite(string $tweet_id){
        $this->intentAction('https://twitter.com/intent/favorite?tweet_id='.$tweet_id);
    }

    public function follow(string $user_id){
        $this->intentAction('https://twitter.com/intent/follow?user_id='.$user_id);
    }

    public function retweet(string $tweet_id){
        $this->intentAction('https://twitter.com/intent/retweet?tweet_id='.$tweet_id);
    }

    public function tweetWithImages(string $tweet_body,array $images_path) : HomeTimeLinePage{
        $this
            ->getDriver()
            ->findElement(WebDriverBy::xpath("//a[@data-testid='SideNav_NewTweet_Button']"))
            ->click()
        ;
        $this
            ->waitWithXpath("//div[@data-testid='tweetTextarea_0']")
        ;
        $this
            ->getDriver()
            ->findElement(WebDriverBy::xpath("//div[@data-testid='tweetTextarea_0']"))
            ->sendKeys($tweet_body)
        ;

        //fileInput
        foreach($images_path as $path) {
            $this
                ->getDriver()
                ->findElement(WebDriverBy::xpath("//input[@data-testid='fileInput']"))
                ->sendKeys($path);
            sleep(1);
        }


        $this->waitWithXpath("//div[@data-testid='tweetButton']");
        $this
            ->getDriver()
            ->findElement(WebDriverBy::xpath("//div[@data-testid='tweetButton']"))
            ->click()
        ;

        sleep(3);

        return $this;
    }

    public function tweet(string $tweet_body) : HomeTimeLinePage{
        $this
            ->getDriver()
            ->findElement(WebDriverBy::xpath("//a[@data-testid='SideNav_NewTweet_Button']"))
            ->click()
        ;
        $this
            ->waitWithXpath("//div[@data-testid='tweetTextarea_0']")
        ;
        $this
            ->getDriver()
            ->findElement(WebDriverBy::xpath("//div[@data-testid='tweetTextarea_0']"))
            ->sendKeys($tweet_body)
        ;

        $this->waitWithXpath("//div[@data-testid='tweetButton']");
        $this
            ->getDriver()
            ->findElement(WebDriverBy::xpath("//div[@data-testid='tweetButton']"))
            ->click()
        ;

        sleep(3);

        return $this;
    }
}