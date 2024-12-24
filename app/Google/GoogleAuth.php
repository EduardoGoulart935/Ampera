<?php

namespace App\Google;

use Google\Client;

class GoogleAuth 
{
    private $client;

    public function __construct() 
    {
        $this->client = new Client();
        $this->client->setClientId('seuID');
        $this->client->setClientSecret('seuClient');
        $this->client->setRedirectUri('http://localhost/Ampera/autenticarGoogleCallback');
        $this->client->addScope(['email', 'profile']);
    }

    public function getLoginUrl(): string 
    {
        return $this->client->createAuthUrl();
    }

    public function authenticate(string $code)
    {
        $token = $this->client->fetchAccessTokenWithAuthCode($code);
        $this->client->setAccessToken($token);

        $oauth = new \Google\Service\Oauth2($this->client);
        return $oauth->userinfo->get();
    }
}

