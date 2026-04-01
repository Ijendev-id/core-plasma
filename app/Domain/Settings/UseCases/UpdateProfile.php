<?php

namespace App\Domain\Settings\UseCases;

use App\Domain\Settings\Data\ProfileData;
use App\Models\User;

final class UpdateProfile
{
    public function __invoke(User $user, ProfileData $profileData): void
    {
        $user->fill([
            'name' => $profileData->name,
            'email' => $profileData->email,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
    }
}
