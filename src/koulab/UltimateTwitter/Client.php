<?php
namespace koulab\UltimateTwitter;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use koulab\UltimateTwitter\Handler\AutomatedRotateProxyMiddleware;
use koulab\UltimateTwitter\Proxy\Proxy;

class Client{
    private $client;
    private $proxy;

    /**
     * @return array|Proxy
     */
    public function getProxy() : Proxy
    {
        return $this->proxy;
    }

    /**
     * @param array|Proxy $proxy
     */
    public function setProxy(Proxy $proxy): void
    {
        $this->proxy = $proxy;
    }


    public function setClient(\GuzzleHttp\ClientInterface $client)
    {
        $this->client = $client;
    }

    public function getClient() : \GuzzleHttp\ClientInterface
    {
        return $this->client;
    }

    public function __construct(Proxy $proxy = null,\GuzzleHttp\ClientInterface $client = null)
    {
        $this->parser = new \Parser();
        if(is_null($client) || !($client instanceof \GuzzleHttp\ClientInterface)){
            $stack = HandlerStack::create();
            $stack->after('cookies',new AutomatedRotateProxyMiddleware($proxy));
            $stack->push(\GuzzleHttp\Middleware::retry(
                function ($retries,\GuzzleHttp\Psr7\Request $request,$response,$exception){
                    if($retries >= 5){ return false; }
                    if($exception instanceof  \GuzzleHttp\Exception\RequestException || $exception instanceof \GuzzleHttp\Exception\BadResponseException){
                        return true;
                    }

                }
            ));

            $this->setClient(
                new \GuzzleHttp\Client([
                    'debug'=>true,
                    'cookies'=>true,
                    'handler'=>$stack,
                    'headers'=>[
                        'User-Agent'=>'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36',
                    ]
                ])
            );
        }
    }

    public function login($usernameOrEmail,$password){
        $response = $this->getClient()->request('GET','https://twitter.com/login');
        $this->parser->clear();
        $this->parser->addHtmlContent($response->getBody()->getContents(),'UTF-8');

        $response = $this->getClient()->request('POST','https://twitter.com/sessions',[
            'headers'=>[
                'Referer'=>'https://twitter.com/login',

            ],
            'form_params'=>[
                'session'=>[
                    'username_or_email'=>$usernameOrEmail,
                    'password'=>$password,
                ],
                //'session[username_or_email]'=>$usernameOrEmail,
                //'session[password]'=>$password,
                'scribe_log'=>'',
                'redirect_after_login'=>'',
                'authenticity_token'=>$this->parser->getAuthenticityToken(),
            ]
        ]);
        if($response->getStatusCode() === 302 && strpos($response->getBody()->getContents(),'/error') !== FALSE){
            throw new \UltimateTwitterException("Invalid credentials");
        }

        return $response->getBody()->getContents();

    }


}