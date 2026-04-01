<?php

namespace App\Domain\Settings\UseCases;

use App\Models\User;

final class DeleteAccount
{
    public function __invoke(User $user): void
    {
        $user->delete();
    }
}
