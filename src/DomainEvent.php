<?php declare(strict_types=1);

namespace Shadowlegend;

use JsonSerializable;

final class DomainEvent implements JsonSerializable
{
    private $id;
    private $eventType;
    private $causationId;
    private $correlationId;
    private $payload;
    private $metadata;

    public function __construct(
        UniqueEventId $id,
        string $eventType,
        string $causationId,
        string $correlationId,
        JsonEncoded $payload,
        ?JsonEncoded $metadata
    ) {
        $this->id = $id;
        $this->eventType = $eventType;
        $this->causationId = $causationId;
        $this->correlationId = $correlationId;
        $this->payload = $payload;
        $this->metadata = $metadata;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'id' => $this->id->val(),
            'event_type' => $this->eventType,
            'causation_id' => $this->causationId,
            'correlation_id' => $this->correlationId,
            'payload' => $this->payload->val(),
            'metadata' => $this->metadata ? $this->metadata->val() : null,
        ];
    }
}
