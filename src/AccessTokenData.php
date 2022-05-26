<?php


namespace Alpa\Icms\Oauth;


class AccessTokenData
{
    public string $access_token;
    public string $resource_owner_id;
    public string $refresh_token;
    public int $expires;
    public int $expires_in;
    public function __construct(array $data)
    {
        $this->init($data);
    }
    protected function init(array $data):void
    {
        foreach($data as $key=>$value){
            if(property_exists($this,$key)){
                $this->$key=$value;
            }
        }
    }
}