<?php declare(strict_types=1);

namespace Shadowlegend;

use PHPUnit\Framework\TestCase;

final class AisDataNexusTest extends TestCase
{
    public function testCorrectEndpointConstruction(): void
    {
        $dn = new AisDataNexus(
            "http://sec0.xroad.acme.org",
            "acme.org",
            "client-class",
            "client-sub",
            "client-member",
            "target-class",
            "target-sub",
            "target-member",
            "target-svc",
            "repo"
        );

        $this->assertSame($dn->endpoint(), "r1/acme.org/target-class/target-member/target-sub/target-svc/repo");
    }

    public function testCorrectHeadersConstruction(): void
    {
        $dn = new AisDataNexus(
            "http://sec0.xroad.acme.org",
            "acme.org",
            "client-class",
            "client-sub",
            "client-member",
            "target-class",
            "target-sub",
            "target-member",
            "target-svc",
            "repo"
        );

        $this->assertSame($dn->headers(), ['x-road-client' => 'acme.org/client-class/client-member/client-sub']);
    }

    public function testSend(): void
    {
        $dn = new AisDataNexus(
            "https://webhook.site/730db849-0661-4f82-a76f-52c014972f28",
            "acme.org",
            "client-class",
            "client-sub",
            "client-member",
            "target-class",
            "target-sub",
            "target-member",
            "target-svc",
            "repo"
        );

        $dn->send(new DomainEvent(
            new UniqueEventId('ref123'),
            'OrderPlaced',
            'ref456',
            'ref789',
            new JsonEncoded('{"fa":12,"lua":[null,2,"as"],"fu":{}}'),
            null
        ));

        $this->assertSame($dn->headers(), ['x-road-client' => 'acme.org/client-class/client-member/client-sub']);
    }
}
