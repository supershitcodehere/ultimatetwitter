<?php

namespace koulab\UltimateTwitter\Tests;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use koulab\UltimateTwitter\Selenium\TwitterWeb\Pages\LoginPage;
use koulab\UltimateTwitter\Selenium\TwitterWeb\TwitterWeb;
use PHPUnit\Framework\TestCase;

class SeleniumTest extends TestCase
{
    private $driver;

    public function setUp(): void
    {

        $this->driver = TwitterWeb::getDefaultDriverProfile();
    }

    public function tearDown(): void
    {
        $this->driver->quit();
    }

    public function testLogin(){
        $login = new LoginPage($this->driver);
        $login->login(getenv('TWITTER_USERNAME'),getenv('TWITTER_PASSWORD'));
        $this->driver->takeScreenshot('login.png');
    }

    public function testTweet(){
        $login = new LoginPage($this->driver);
        $ht = $login->login(getenv('TWITTER_USERNAME'),getenv('TWITTER_PASSWORD'));
        $ht->tweet('テスト'.time());
        $this->driver->takeScreenshot('tweet.png');
    }

    public function testTweetWithImages(){
        $login = new LoginPage($this->driver);
        $ht = $login->login(getenv('TWITTER_USERNAME'),getenv('TWITTER_PASSWORD'));
        $ht->tweetWithImages('テスト'.time(),[
            'C:\\test.jpg',
            'C:\\test2.jpg',
            'C:\\test3.jpg',
        ]);
        $this->driver->takeScreenshot('tweet_with_images.png');
    }

    public function testReTweet(){
        $login = new LoginPage($this->driver);
        $ht = $login->login(getenv('TWITTER_USERNAME'),getenv('TWITTER_PASSWORD'));
        $ht->retweet('1329661028745973763');
        $this->driver->takeScreenshot('retweet.png');
    }

}
