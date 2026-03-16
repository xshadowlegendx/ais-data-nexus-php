<?php declare(strict_types=1);

namespace Shadowlegend;

final class JsonEncoded
{
    private string $val;

    public function __construct(string $val)
    {
        $this->val = $val;
    }

    public function val()
    {
        return json_decode($this->val);
    }
}
