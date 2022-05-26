<?php


namespace Alpa\Icms\Oauth;


class ProviderData
{

    /** @var string Псевдоним Провайдера, для легкой индетификации
     */
    protected string $alias;
    /**
     * @var string Имя класса провайдера.
     */
    protected string $class;

    /**
     * @var string Индетификатор сервиса на стороне провайдера.
     */
    protected string $clientId;

    /**
     * @var string Секретный ключ сервиса полученный провайдером.
     */
    protected string $clientSecret;

    /**
     * @var string|null Сыллка перенаправления на сайт после регистрации
     */

    protected ?string $redirectUri=null;

    public function __construct(array $data)
    {
        foreach ($data as $key=>$value){
            $method='set'.$key;
            if(method_exists($this,$method)){
                $this->$method($value);
            }
        }
    }
    public function setAlias(string $alias):void
    {
        $this->alias=$alias;
    }
    public function getAlias():string
    {
        return $this->alias;
    }
    public function setClass(string $class):void
    {
        $this->class=$class;
    }
    public function getClass():string
    {
        return $this->class;
    }
    public function setRedirectUri(string $redirectUri):void
    {
        $this->redirectUri=$redirectUri;
    }
    public function getRedirectUri():string
    {
        return $this->redirectUri;
    }
    public function setClientId(string $clientId):void
    {
        $this->clientId=$clientId;
    }
    public function getClientId():string
    {
        return $this->clientId;
    }
    public function setClientSecret(string $clientToken):void
    {
        $this->clientSecret=$clientToken;
    }
    public function getClientSecret():string
    {
        return $this->clientSecret;
    }
}