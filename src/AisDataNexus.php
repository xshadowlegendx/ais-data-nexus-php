<?php declare(strict_types=1);

use GuzzleHttp\RequestOptions;

final class AisDataNexus
{
    private GuzzleHttp\Client $httpClient;

    public function __construct(
        private string $serverUrl,
        private string $instance,
        private string $clientClass,
        private string $clientSubsystem,
        private string $clientMemberCode,
        private string $targetClass,
        private string $targetSubsystem,
        private string $targetMemberCode,
        private string $targetService,
        private string $repoName
    )
    {
        $this->httpClient = new GuzzleHttp\Client(['base_uri' => "$serverUrl/"]);
    }

    public function endpoint(): string
    {
        return "r1/$this->instance/$this->targetClass/$this->targetMemberCode/$this->targetSubsystem/$this->targetService/$this->repoName";
    }

    public function headers(): array
    {
        return [
            'x-road-client' => "$this->instance/$this->clientClass/$this->clientMemberCode/$this->clientSubsystem"
        ];
    }

    public function send(DomainEvent $domainEvent): void
    {
        $res = $this->httpClient->post(
            $this->endpoint(),
            [
                RequestOptions::JSON => $domainEvent,
                'headers' => $this->headers()
            ]
        );

        switch ($res->getStatusCode()) {
            case 200:
            case 204:
                return;

            case 401:
                throw new Exception('unauthenticated');

            case 403:
                throw new Exception('forbidden');

            default:
                throw new Exception("unknown error - $res->getStatusCode()");
        }
    }
}
