<?php declare(strict_types=1);

namespace Shadowlegend;

final class UniqueEventId
{
    private string $val;

    public function __construct(string $val)
    {
        $this->val = $val;
    }

    public function val()
    {
        return $this->val;
    }
}
