<?php


namespace Alpa\Icms\Oauth;


use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;

class ProviderManager
{
    protected AbstractProvider $provider;
    protected ProviderData $providerData;
    protected AccessToken $accessToken;

    /**
     * ProviderManager constructor.
     * @param ProviderData|null $data Если null, то процедура инициализации не будет запущена.
     * Тогда Парраметры необходимо будет инициализировать вручную.
     * @param null $options если null, то токен доступа ($accessToken) необходимо инициализировать/устанавливать вручную
     */
    public function __construct(?ProviderData $data=null, $options=null)
    {
        if($data!==null){
            $this->init($data,$options);
        }
    }

    /**
     * @param ProviderData $data
     * @param null $options
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    protected function init(ProviderData $data, $options=null)
    {
        $this->initProviderData($data);
        $this->initProvider();
        if($options!==null){
            $this->initAccessToken($options);
        }
    }

    /**
     * @param ProviderData $data
     */
    public function initProviderData(ProviderData $data):void
    {
        $this->providerData=$data;
    }

    /**
     *
     */
    public function initProvider():void
    {
        $data=$this->providerData;
        $class=$data->getClass();
        $requestData=[
            'clientId'=>$data->getClientId(),
            'clientSecret'=>$data->getClientSecret()
        ];
        if($data->getRedirectUri()!==null){
            $requestData['redirectUri']=$data->getRedirectUri();
        }
        $this->provider= new $class($requestData);
    }

    /**
     * @param array|string $options
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function initAccessToken($options):void
    {
        if(is_string($options)){
            $options=['code'=>$options];
        }
        $this->accessToken = $this->provider->getAccessToken('authorization_code', $options);// or grant=AuthorizationCode
    }

    /**
     * @param AccessToken $accessToken
     */
    public function setAccessToken(AccessToken $accessToken):void
    {
        $this->accessToken=$accessToken;
    }

    /**
     * @return AccessToken
     */
    public function getAccessToken():AccessToken
    {
        return $this->accessToken;
    }

    /**
     * @param array|AccessTokenData $accessTokenData
     * @return AccessToken
     */
    public function newAccessToken($accessTokenData):AccessToken
    {
        if ($accessTokenData instanceof  AccessTokenData){
            $accessTokenData=(array)$accessTokenData;
        }
        return new AccessToken($accessTokenData);
    }

    /**
     * @return AbstractProvider
     */
    public function getProvider():AbstractProvider
    {
        return $this->provider;
    }

    /**
     * @param AbstractProvider $provider
     */
    public function setProvider(AbstractProvider $provider):void
    {
        $this->provider=$provider;
    }

    /**
     * @param array|null $bind_fields
     * @return UserData
     */
    public function getResourceOwner(?array $flip_fields=null):UserData
    {
        $resource_data=$this->provider->getResourceOwner($this->accessToken)->toArray();
        $token_data=$this->accessToken->getValues();
        $data=array_replace($token_data,$resource_data);
        return new UserData($data,$flip_fields);
    }
    public function refreshAccessToken(bool $force=false):bool
    {
        if($this->accessToken->hasExpired() || $force){
            $newAccessToken = $this->provider->getAccessToken('refresh_token', [
                'refresh_token' => $this->accessToken->getRefreshToken()
            ]);
            $this->setAccessToken($newAccessToken);
            return true;
        }
        return false;
    }
}