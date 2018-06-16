<?php
namespace koulab\UltimateTwitter\Proxy;
class Proxy{
    private $address = [];

    public function addAddress(string $address) : void{
        $this->address[$address] = 0;
    }

    public function getAddress() : string{
        if(count($this->address) == 0){ return ''; }
        asort($this->address,SORT_NUMERIC);
        foreach ($this->address as $address=>$count){
            $this->address[$address] = $count + 1;
            return $address;
        }
    }

    public function getAddresses() : array{
        return $this->address;
    }

}