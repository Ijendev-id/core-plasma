<?php

namespace App\Domain\Settings\Data;

final readonly class ProfileData
{
    public function __construct(
        public string $name,
        public string $email,
    ) {}

    /**
     * @param  array{name: string, email: string}  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
        );
    }
}
