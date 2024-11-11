<?php

namespace App\Provider;

use League\OAuth2\Client\Provider\GenericProvider;

class DiscordProvider extends GenericProvider
{
    public function __construct(array $options = [])
    {
        $options = array_merge([
            'clientId'                => '%env(DISCORD_CLIENT_ID)%',
            'clientSecret'            => '%env(DISCORD_CLIENT_SECRET)%',
            'redirectUri'             => 'http://localhost:8000/discord/callback',
            'urlAuthorize'            => 'https://discord.com/api/oauth2/authorize',
            'urlAccessToken'          => 'https://discord.com/api/oauth2/token',
            'urlResourceOwnerDetails' => 'https://discord.com/api/users/@me',
        ], $options);

        parent::__construct($options);
    }
}
