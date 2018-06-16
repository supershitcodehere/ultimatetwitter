<?php

class Parser extends Symfony\Component\DomCrawler\Crawler {

    public function __construct(?mixed $node = null, $uri = null, $baseHref = null)
    {
        parent::__construct($node, $uri, $baseHref);
    }


    public function getAuthenticityToken(){
        return $this->filter('input[name="authenticity_token"]')->attr('value');
    }

}