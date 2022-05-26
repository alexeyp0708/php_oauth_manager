<?php

namespace Alpa\Icms\Oauth\Tests;

use Alpa\Icms\Oauth\ProviderData;
use PHPUnit\Framework\TestCase;

class ProviderDataTest extends TestCase
{
    public function testConstruct()
    {
        $data=[
            'alias'=>'test',
            'class'=>'TestClass',
            'clientId'=>'1234',
            'clientSecret'=>'qwerty',
            'redirectUri'=>'https://test.site'
        ];
        $pd=new ProviderData($data);
        $this->assertTrue($pd->getAlias()===$data['alias']);
        $this->assertTrue($pd->getClass()===$data['class']);
        $this->assertTrue($pd->getClientId()===$data['clientId']);
        $this->assertTrue($pd->getClientSecret()===$data['clientSecret']);
        $this->assertTrue($pd->getRedirectUri()===$data['redirectUri']);
    }
}