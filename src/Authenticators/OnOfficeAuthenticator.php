<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Authenticators;

use Saloon\Contracts\Authenticator;
use Saloon\Http\PendingRequest;

readonly class OnOfficeAuthenticator implements Authenticator
{
    public function __construct(
        private string $token,
        private string $secret,
    ) {
    }

    public function set(PendingRequest $pendingRequest): void
    {
        $pendingRequest
            ->body()
            ->set(
                [
                    'token' => $this->token,
                    'request' => [
                        'actions' => [
                            ...$this->buildAll(
                                $pendingRequest
                                    ->body()
                                    ->all()
                            ),
                        ],
                    ],
                ]
            );
    }

    private function buildAll(mixed $body): mixed
    {
        foreach ($body['request']['actions'] as &$action) {
            $action = $this->build(
                $action['actionid'],
                $action['resourceid'],
                $action['resourcetype'],
                $action['parameters'],
            );
        }

        return $body['request']['actions'];
    }

    private function build(string $actionId, string|int $resourceId, string $resourceType, array $parameters): array
    {
        $timestamp = time();

        return [
            'actionid' => $actionId,
            'resourceid' => (string) $resourceId,
            'identifier' => '',
            'resourcetype' => $resourceType,
            'timestamp' => $timestamp,
            'hmac' => $this->createHmac2($timestamp, $resourceType, $actionId),
            'parameters' => $parameters,
            'hmac_version' => '2',
        ];
    }

    private function createHmac2($timestamp, $type, $actionId): string
    {
        $fields = [
            'timestamp' => $timestamp,
            'token' => $this->token,
            'resourcetype' => $type,
            'actionid' => $actionId,
        ];

        return base64_encode(hash_hmac('sha256', implode('', $fields), $this->secret, true));
    }
}
