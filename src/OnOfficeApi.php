<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi;

use Kauffinger\OnOfficeApi\Authenticators\OnOfficeAuthenticator;
use Saloon\Contracts\Authenticator;
use Saloon\Http\Connector;

class OnOfficeApi extends Connector
{
    public function __construct(
        private readonly string $token,
        private readonly string $secret,
    ) {
    }

    public function resolveBaseUrl(): string
    {
        return 'https://api.onoffice.de/api/stable/api.php';
    }

    /**
     * Define default headers
     *
     * @return string[]
     */
    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    protected function defaultAuth(): ?Authenticator
    {
        return new OnOfficeAuthenticator($this->token, $this->secret);
    }

    public static function for(string $token, string $secret)
    {
        return new OnOfficeApi($token, $secret);
    }
}
