<?php


namespace Alpa\Icms\Oauth\Tests\fixtures;


use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class ResourceOwner implements ResourceOwnerInterface
{

    public function getId()
    {
        return 'resource_owner_id';
    }

    public function toArray()
    {
        return ['test_one'=>1,'test_two'=>2];
    }
}