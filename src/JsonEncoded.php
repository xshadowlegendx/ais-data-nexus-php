<?php declare(strict_types=1);

namespace Shadowlegend;

final class JsonEncoded
{
    public function __construct(private string $val)
    {
    }

    public function val(): mixed
    {
        return json_decode($this->val);
    }
}
