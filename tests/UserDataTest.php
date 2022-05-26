<?php

namespace Alpa\Icms\Oauth\Tests;

use Alpa\Icms\Oauth\ProviderData;
use Alpa\Icms\Oauth\UserData;
use PHPUnit\Framework\TestCase;

class UserDataTest extends TestCase
{
    public function test()
    {
        $data=[
            'user_id'=>'1234',
            'user_name'=>'Name',
            'user_desc'=>'user_desc'
        ];
        $flip_fields=[
            'id'=>'user_id',
            'name'=>'user_name'
        ];
        $user=new UserData($data,$flip_fields);
        $user2=new UserData($data);

        $this->assertTrue($user->get('id')===$data['user_id']);
        $this->assertTrue($user2->get('user_id')===$data['user_id']);
        $this->assertTrue($user->get('name')===$data['user_name']);
        $this->assertTrue($user2->get('user_name')===$data['user_name']);
        $this->assertTrue($user2->get('user_desc')===$data['user_desc']);
        $this->assertSame($user->toArray(),['id'=>$data['user_id'],'name'=>$data['user_name'],'user_desc'=>'user_desc']);
    }
}