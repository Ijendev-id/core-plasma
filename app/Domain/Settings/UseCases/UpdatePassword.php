<?php

namespace App\Domain\Settings\UseCases;

use App\Models\User;

final class UpdatePassword
{
    public function __invoke(User $user, string $plainPassword): void
    {
        $user->update([
            'password' => $plainPassword,
        ]);
    }
}
