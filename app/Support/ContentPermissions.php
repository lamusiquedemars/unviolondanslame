<?php

namespace App\Support;

use App\Models\User;
use App\Modules\Appointments\Models\AppointmentSetting;
use App\Modules\Articles\Models\Article;
use App\Modules\Audience\Models\AudienceBrevoSetting;
use App\Modules\Audience\Models\AudienceContact;
use App\Modules\Audience\Models\AudienceSegment;
use App\Modules\Audience\Models\SegmentMessage;
use App\Modules\Contacts\Models\Contact;
use App\Modules\ContentSlots\Models\ContentSlot;
use App\Modules\Conversations\Models\Conversation;
use App\Modules\Conversations\Models\ConversationSetting;
use App\Modules\Events\Models\Event;
use App\Modules\Inquiries\Models\Inquiry;
use App\Modules\News\Models\NewsPost;
use App\Modules\Notices\Models\SiteNotice;
use App\Modules\Pages\Models\Page;
use App\Modules\SiteSettings\Models\SiteSetting;
use App\Modules\Venues\Models\Venue;
use Illuminate\Database\Eloquent\Model;
use Maracuja\SiteCore\Catalogue\Models\CatalogueCategory;
use Maracuja\SiteCore\Catalogue\Models\CatalogueCollection;
use Maracuja\SiteCore\Catalogue\Models\CatalogueItem;
use Maracuja\SiteCore\Gallery\Models\Gallery;
use Maracuja\SiteCore\Media\Models\MediaAsset;

class ContentPermissions
{
    /** @return array<string, string> */
    public static function labels(): array
    {
        return [
            'pages' => 'Pages',
            'notices' => 'Annonces courtes',
            'content_slots' => 'Contenus courts',
            'news' => 'Actualités',
            'articles' => 'Articles',
            'inquiries' => 'Demandes reçues',
            'contacts' => 'Contacts',
            'media' => 'Médias',
            'gallery' => 'Galeries',
            'events' => 'Événements',
            'venues' => 'Lieux',
            'conversations' => 'Conversations',
            'audience' => 'Audience et campagnes',
            'catalogue' => 'Catalogue',
        ];
    }

    public static function keyForModel(?string $model): ?string
    {
        return match ($model) {
            Page::class => 'pages',
            SiteNotice::class => 'notices',
            ContentSlot::class => 'content_slots',
            NewsPost::class => 'news',
            Article::class => 'articles',
            Inquiry::class => 'inquiries',
            Contact::class => 'contacts',
            MediaAsset::class => 'media',
            Gallery::class => 'gallery',
            Event::class => 'events',
            Venue::class => 'venues',
            AppointmentSetting::class => 'appointments',
            Conversation::class, ConversationSetting::class => 'conversations',
            AudienceContact::class, AudienceSegment::class, SegmentMessage::class, AudienceBrevoSetting::class => 'audience',
            CatalogueCollection::class, CatalogueCategory::class, CatalogueItem::class => 'catalogue',
            SiteSetting::class => 'site_settings',
            default => null,
        };
    }

    public static function labelsForForm(): array
    {
        $labels = self::labels();
        $modules = [];

        foreach ($labels as $key => $label) {
            // Older sites provide media permanently without a module flag.
            if ($key === 'media' && ! isset($modules[$key]) && config('maracuja.modules.media') === null) {
                continue;
            }

            if (! Modules::enabled($modules[$key] ?? $key)) {
                $labels[$key] = $label.' (module inactif)';
            }
        }

        return $labels;
    }

    public static function allows(User $user, ?string $model): bool
    {
        $permission = self::keyForModel($model);

        // These screens contain custom write actions that are not yet
        // available in a read-only form. Never expose them to a reader.
        if (! $user->isAdministrator() && $user->role === User::ROLE_VIEWER && in_array($permission, ['inquiries', 'audience', 'conversations'], true)) {
            return false;
        }

        if ($permission !== null) {
            return $user->canAccessContent($permission);
        }

        return $user->isAdministrator() || $user->content_permissions === null
            || ! $model || ! is_a($model, Model::class, true);
    }
}
