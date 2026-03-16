<?php declare(strict_types=1);

namespace Shadowlegend;

final class UniqueEventId
{
    public function __construct(private string $val)
    {
    }

    public function val(): string
    {
        return $this->val;
    }
}
