<?php

namespace App\Domain\Settings\UseCases;

use App\Models\User;
use Laravel\Fortify\Features;

final class GetSecuritySettings
{
    /**
     * @return array{canManageTwoFactor: bool, twoFactorEnabled?: bool, requiresConfirmation?: bool}
     */
    public function __invoke(User $user): array
    {
        $props = [
            'canManageTwoFactor' => Features::canManageTwoFactorAuthentication(),
        ];

        if ($props['canManageTwoFactor']) {
            $props['twoFactorEnabled'] = $user->hasEnabledTwoFactorAuthentication();
            $props['requiresConfirmation'] = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm');
        }

        return $props;
    }
}
