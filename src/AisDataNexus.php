<?php declare(strict_types=1);

namespace Shadowlegend;

use Exception;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

final class AisDataNexus
{
    private Client $httpClient;

    private string $serverUrl;
    private string $instance;
    private string $clientClass;
    private string $clientSubsystem;
    private string $clientMemberCode;
    private string $targetClass;
    private string $targetSubsystem;
    private string $targetMemberCode;
    private string $targetService;
    private string $repoName;

    public function __construct(
        string $serverUrl,
        string $instance,
        string $clientClass,
        string $clientSubsystem,
        string $clientMemberCode,
        string $targetClass,
        string $targetSubsystem,
        string $targetMemberCode,
        string $targetService,
        string $repoName
    ) {
        $this->serverUrl = $serverUrl;
        $this->instance = $instance;
        $this->clientClass = $clientClass;
        $this->clientSubsystem = $clientSubsystem;
        $this->clientMemberCode = $clientMemberCode;
        $this->targetClass = $targetClass;
        $this->targetSubsystem = $targetSubsystem;
        $this->targetMemberCode = $targetMemberCode;
        $this->targetService = $targetService;
        $this->repoName = $repoName;

        $this->httpClient = new Client(['base_uri' => $this->serverUrl . "/"]);
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
