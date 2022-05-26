<?php


namespace Alpa\Icms\Oauth\Tests;


use Alpa\Icms\Oauth\ProviderData;
use Alpa\Icms\Oauth\ProviderManager;
use Alpa\Icms\Oauth\Tests\fixtures\Provider;
use League\OAuth2\Client\Token\AccessToken;
use PHPUnit\Framework\TestCase;
class ProviderManagerTest extends TestCase
{
    protected ProviderManager $pm;

    protected function setUp(): void
    {
        $pmd=new ProviderData([
            'alias'=>'TestProvider',
            'class'=> Provider::class,
            'clientId'=>'1234',
            'clientSecret'=>'secret',
            'redirectUri'=>'https://test.site'
        ]);
        $this->pm=new ProviderManager($pmd,[]);

    }
    public function testInit()
    {
        $provider=$this->pm->getProvider();
        $this->assertTrue($provider instanceof Provider);
        $token=$this->pm->getAccessToken();
        $this->assertTrue($token instanceof AccessToken);
        $this->assertTrue($token->getToken()==='access_token');
        $this->assertTrue($token->getResourceOwnerId()==='resource_owner_id');
        $this->assertTrue($token->getResourceOwnerId()==='resource_owner_id');
        $this->assertTrue($token->getRefreshToken()==='refresh_token');
        $this->assertTrue(is_numeric($token->getExpires()));
    }
    public function testGetResourceOwner()
    {
        $result=$this->pm->getResourceOwner(['one'=>'test_one','two'=>'test_two']);
        $this->assertSame($result->toArray(),['redundant_field'=>'redundant_field','one'=>1,'two'=>2]);
    }
    public function testRefreshAccessToken()
    {
        $this->assertTrue($this->pm->refreshAccessToken()->getAccessToken()->getToken()==='refresh_token');

    }
}