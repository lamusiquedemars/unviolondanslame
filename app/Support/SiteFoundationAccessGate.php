<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maracuja\SiteCore\Foundation\Contracts\FoundationAccessGate;

final class SiteFoundationAccessGate implements FoundationAccessGate
{
    public function allows(string $ability): bool
    {
        $user = Auth::user();
        $permission = match ($ability) {
            'media.manage' => 'media',
            'gallery.manage' => 'gallery',
            default => $ability,
        };

        return $user instanceof User && $user->canAccessContent($permission);
    }
}
