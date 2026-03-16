<?php declare(strict_types=1);

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
}
