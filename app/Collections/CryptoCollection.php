<?php

declare(strict_types=1);

namespace App\Collections;

use App\Models\Crypto;

class CryptoCollection
{
    private array $crypto;

    public function add(Crypto $coin): void
    {
        $this->crypto[] = $coin;
    }

    public function get(): array
    {
        return $this->crypto;
    }
}