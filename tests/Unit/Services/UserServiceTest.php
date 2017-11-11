<?php

namespace Tests\Unit\Services;

use App\Services\UserService;
use TestCase;

class UserServiceTest extends TestCase
{
    private $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = new UserService();
    }

    public function testServiceCanSubscribeAUserWithEmail()
    {
        $email = 'new@email.com';
        $token = 'b3137db173c3ec9e87053c6fa961ea08c455078713640442aed4e72fbcf1d666';
        $message = 'Subscription successful. Ensure to copy and store the generated token.';

        $response = $this->service->Subscribe($email);
        
        $this->assertEquals(201, $response['status']);

        $body = $response['body'];

        $this->assertEquals($email, $body['email']);
        $this->assertEquals($token, $body['token']);
        $this->assertEquals($message, $body['message']);
    }

    public function testServiceCanUpdateAUserProfile()
    {
        $oldEmail = 'test-account@email.com';
        $newEmail = 'new-test-account@email.com';
        $testToken = '2ba135fbbd41ea0ae84e8c6ef122793106adfa25ae10a4879bbaeb8a238bfd8f';

        $response = $this->service->UpdateProfile($oldEmail, $newEmail, $testToken);
        
        $this->assertEquals(200, $response['status']);

        $body = $response['body'];

        $newToken = 'd064dc11336c4c74ce0e3d8de464e31ad134eb579734546f634c9b0e7df7673b';

        $this->assertEquals($newEmail, $body['email']);
        $this->assertEquals($newToken, $body['token']);
        $this->assertEquals('Profile updated successful. Ensure to copy and store the generated token.', $body['message']);
    }

    public function testServiceReturnsUnavailableEmailAddress()
    {
        $oldEmail = 'unavailable@email.com';
        $newEmail = 'new-test-account@email.com';
        $testToken = '2ba135fbbd41ea0ae84e8c6ef122793106adfa25ae10a4879bbaeb8a238bfd8f';
        $message = 'Account with provided email address does not exist';
        $response = $this->service->UpdateProfile($oldEmail, $newEmail, $testToken);
        
        $this->assertEquals(404, $response['status']);

        $body = $response['body'];

        $this->assertEquals($oldEmail, $body['email']);
        $this->assertEquals($message, $body['message']);
    }

    public function testServiceReturnsInvalidToken()
    {
        $oldEmail = 'test-account@email.com';
        $newEmail = 'new-test-account@email.com';
        $testToken = 'invalid_token';
        $message = 'Invalid Token. Please enter your subscription token.';
        $response = $this->service->UpdateProfile($oldEmail, $newEmail, $testToken);
        
        $this->assertEquals(400, $response['status']);

        $body = $response['body'];

        $this->assertEquals($testToken, $body['token']);
        $this->assertEquals($message, $body['message']);
    }
}
