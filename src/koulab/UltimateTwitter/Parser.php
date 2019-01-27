<?php
namespace koulab\UltimateTwitter;
use Symfony\Component\DomCrawler\Crawler;

class Parser extends Crawler {

    public function __construct(?mixed $node = null, $uri = null, $baseHref = null)
    {
        parent::__construct($node, $uri, $baseHref);
    }


    public function getAuthenticityToken(){
        return $this->filter('input[name="authenticity_token"]')->attr('value');
    }

    public function getChallengeId(){
        return $this->filter('input[name="challenge_id"]')->attr('value');
    }
    public function getEncUserId(){
        return $this->filter('input[name="enc_user_id"]')->attr('value');
    }
    public function getChallengeType(){
        return $this->filter('input[name="challenge_type"]')->attr('value');
    }
    public function getMessageClassString(){
        $message = "";
        try{
            $message .= $this->filter('.message')->text();
        }catch (\InvalidArgumentException $e){ }
        try{
            $message .= $this->filter('.confirm_title')->text();
        }catch (\InvalidArgumentException $e){ }
        return $message;
    }

}