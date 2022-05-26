<?php


namespace Alpa\Icms\Oauth\Tests\fixtures;


use Alpa\Icms\Oauth\Tests\fixtures\ResourceOwner;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Psr\Http\Message\ResponseInterface;

class Provider extends AbstractProvider
{
    /**
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return 'https://authorization_url';
    }

    /**
     * @param array $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params): string
    {
        return 'https://access_token_url';
    }

    /**
     * @param AccessToken $token
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        return 'resource_owner_details_url';
    }
    public function checkResponse(ResponseInterface $response, $data):string
    {

    }
    /**
     * Requests an access token using a specified grant and option set.
     *
     * @param  mixed $grant
     * @param  array $options
     * @return AccessTokenInterface
     */
    public function getAccessToken($grant, array $options = []):AccessTokenInterface
    {
        return new AccessToken([
            'access_token'=>$grant==='refresh_token'?'refresh_token':'access_token',
            'resource_owner_id'=>'resource_owner_id',
            'refresh_token'=>'refresh_token',
            'expires'=>time()-1,
            'redundant_field'=>'redundant_field'
        ]);
    }
    public function getResourceOwner(AccessToken $token):ResourceOwnerInterface
    {
        return new ResourceOwner();
    }
    protected function getDefaultScopes():array
    {
        // TODO: Implement getDefaultScopes() method.
        return ['default scopes'];
    }

    protected function createResourceOwner(array $response, AccessToken $token):ResourceOwnerInterface
    {
        return new ResourceOwner();
    }
}