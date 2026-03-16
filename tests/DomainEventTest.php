<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class DomainEventTEst extends TestCase
{
    public function testJsonSerialization()
    {
        $de = new DomainEvent(
            new UniqueEventId('ref123'),
            'OrderPlaced',
            'ref456',
            'ref789',
            new JsonEncoded('{"fa":12,"lua":[null,2,"as"],"fu":{}}'),
            null
        );

        $this->assertSame(json_encode(
            $de->jsonSerialize()),
            '{"id":"ref123","event_type":"OrderPlaced","causation_id":"ref456","correlation_id":"ref789","payload":{"fa":12,"lua":[null,2,"as"],"fu":{}},"metadata":null}'
        );
    }
}
