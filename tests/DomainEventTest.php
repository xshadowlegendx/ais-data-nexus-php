<?php declare(strict_types=1);

namespace Shadowlegend;

use DateTime;

use PHPUnit\Framework\TestCase;

final class DomainEventTEst extends TestCase
{
    public function testJsonSerialization()
    {
        $de = new DomainEvent(
            new UniqueEventId('ref123'),
            'OrderPlaced',
            new DateTime('2026-06-17T22:00:00Z'),
            'ref456',
            'ref789',
            new JsonEncoded('{"fa":12,"lua":[null,2,"as"],"fu":{}}'),
            null
        );

        $this->assertSame(json_encode(
            $de->jsonSerialize()),
            '{"id":"ref123","timestamp":"2026-06-17T22:00:00+00:00","event_type":"OrderPlaced","causation_id":"ref456","correlation_id":"ref789","payload":{"fa":12,"lua":[null,2,"as"],"fu":{}},"metadata":null}'
        );
    }
}
