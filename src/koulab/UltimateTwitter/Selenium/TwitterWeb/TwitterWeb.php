<?php
namespace koulab\UltimateTwitter\Selenium\TwitterWeb;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

abstract class TwitterWeb{
    protected $driver;

    public function __construct(RemoteWebDriver $driver = null){
        if(!isset($driver)){
            $driver = self::getDefaultDriverProfile();
        }
        $this->driver = $driver;
    }

    /**
     * @param RemoteWebDriver $driver
     */
    public function setDriver(RemoteWebDriver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @return RemoteWebDriver
     */
    public function getDriver(): RemoteWebDriver
    {
        return $this->driver;
    }

    public function waitWithXpath(string $xpath, int $sec = 15){
        $this->getDriver()->wait($sec,500)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(
                WebDriverBy::xpath($xpath)
            )
        );
    }

    public function contains($body,$search){
        if(strpos($body,$search) !== false){
            return true;
        }
        return false;
    }

    public static function getDefaultDriverProfile($host = 'http://127.0.0.1:4444'){
        $options = new ChromeOptions();
        $options->addArguments([
            //'--headless',
            '--window-size=1920,1080',
            '--ignore-certificate-errors',
            '--disable-popup-blocking',
            '--disable-web-security',
            '--start-maximized',
            '--incognito',
            '--no-sandbox',
            '--disable-infobars',
            '--disable-dev-shm-usage',
            '--disable-browser-side-navigation',
            '--disable-gpu',
            '--disable-features=VizDisplayCompositor',
            //'--user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36',
        ]);


        $options->setExperimentalOption('excludeSwitches', [
            'enable-automation',
        ]);

        $caps = DesiredCapabilities::chrome();

        $caps->setCapability('pageLoadStrategy', 'none');
        $caps->setCapability(ChromeOptions::CAPABILITY, $options);

        $driver = RemoteWebDriver::create($host, $caps);

        return $driver;
    }
}
