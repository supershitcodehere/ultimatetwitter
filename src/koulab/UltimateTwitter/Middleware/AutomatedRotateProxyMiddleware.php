<?php
namespace koulab\UltimateTwitter\Middleware;

use Psr\Http\Message\RequestInterface;

class AutomatedRotateProxyMiddleware{
    private $proxy = null;


    public function __construct(Proxy $proxy = null)
    {
        if(!is_null($proxy)) {
            $this->proxy = $proxy;
        }
    }

    public function setProxy(Proxy $proxy){
        $this->proxy = $proxy;
    }

    public function __invoke(callable $handler)
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            if(!is_null($this->proxy)) {
                $proxy = $this->proxy->getAddress();
                $options['proxy'] = $proxy;
            }
            return $handler($request, $options);
        };
    }


}