<?php

namespace Dothcom\FrontReader\Services;

class ContentType
{
    public function __construct(
        private readonly string $value
    ) {
    }

    public function toString(): string
    {
        return $this->value;
    }
}
