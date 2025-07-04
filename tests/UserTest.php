<?php
namespace Tests;

use Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testJsonSerialize()
    {
        $user = new User(1, 'Test User', 'test@example.com', 25);
        $json = json_encode($user);

        $this->assertStringContainsString('"name":"Test User"', $json);
        $this->assertStringContainsString('"email":"test@example.com"', $json);
        $this->assertStringContainsString('"age":25', $json);
    }
}
