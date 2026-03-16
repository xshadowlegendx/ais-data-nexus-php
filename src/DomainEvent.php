<?php declare(strict_types=1);

final class DomainEvent implements JsonSerializable
{
    public function __construct(
        private UniqueEventId $id,
        private string $eventType,
        private string $causationId,
        private string $correlationId,
        private JsonEncoded $payload,
        private ?JsonEncoded $metadata
    )
    {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id->val(),
            'event_type' => $this->eventType,
            'causation_id' => $this->causationId,
            'correlation_id' => $this->correlationId,
            'payload' => $this->payload->val(),
            'metadata' => $this->metadata?->val(),
        ];
    }
}
