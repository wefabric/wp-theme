<?php

namespace Theme\Helpers;

use Wefabric\WPSupport\Schema\JsonLd;

/**
 * Person-/ProfilePage-schema voor werknemers.
 *
 * - Op gewone pagina's (werknemersblok): een losse Person per medewerker.
 * - Op de eigen, indexeerbare medewerkerspagina: een ProfilePage met die
 *   Person als mainEntity — ook als daar geen werknemersblok op staat.
 */
class EmployeeSchema
{
    public static function key(int $employeeId): string
    {
        return 'employee_' . $employeeId;
    }

    /**
     * Registreer de markup voor een medewerker die in een werknemersblok staat.
     */
    public static function register(int $employeeId, ?string $url = null): void
    {
        if (static::isOwnProfilePage($employeeId)) {
            static::registerProfilePage($employeeId);
            return;
        }

        // Op de eigen (noindex) pagina geen markup; elders een losse Person.
        if (is_singular('werknemers') && get_the_ID() === $employeeId) {
            return;
        }

        JsonLd::addSchema(static::key($employeeId), static::person($employeeId, $url));
    }

    /**
     * ProfilePage voor de eigen medewerkerspagina (ook gebruikt als fallback
     * vanuit functions.php).
     */
    public static function registerProfilePage(int $employeeId): void
    {
        if (!static::isOwnProfilePage($employeeId)) {
            return;
        }

        $post = get_post($employeeId);

        JsonLd::addSchema(static::key($employeeId), array_filter([
            '@type' => 'ProfilePage',
            'url' => get_permalink($employeeId),
            'dateCreated' => $post ? get_post_time('c', true, $post) : null,
            'dateModified' => $post ? get_post_modified_time('c', true, $post) : null,
            'mainEntity' => static::person($employeeId, get_permalink($employeeId)),
        ]));
    }

    public static function person(int $employeeId, ?string $url = null): array
    {
        $fields = get_fields($employeeId) ?: [];

        $firstName = $fields['first_name'] ?? '';
        $lastName = $fields['last_name'] ?? '';
        $fullName = (!empty($firstName) || !empty($lastName))
            ? trim(preg_replace('/\s+/', ' ', $firstName . ' ' . $lastName))
            : get_the_title($employeeId);

        $socials = $fields['socials'] ?? [];

        $person = [
            '@type' => 'Person',
            'name' => strip_tags($fullName),
            'jobTitle' => strip_tags($fields['function'] ?? ''),
            'description' => trim(strip_tags($fields['overview_text'] ?? '')),
            'image' => !empty($fields['image']) ? wp_get_attachment_image_url($fields['image'], 'full') : '',
            // Geen e-mail, telefoon of WhatsApp van medewerkers: levert geen rich result op en zou
            // de contact-obfuscatie omzeilen. Bedrijfsgegevens (Organization) blijven wel leesbaar.
            'url' => $url ?? '',
            'sameAs' => is_array($socials) ? array_values(array_filter(
                array_column($socials, 'url'),
                fn ($url) => is_string($url) && $url !== '' && ! ContactObfuscator::isSensitiveUrl($url),
            )) : [],
        ];

        $person = array_filter($person);

        $person['worksFor'] = [
            '@type' => 'Organization',
            'name' => get_bloginfo('name'),
            'url' => home_url('/'),
        ];

        return $person;
    }

    /**
     * Is dit de eigen medewerkerspagina, en mag Google die indexeren?
     * Op noindex-pagina's (of sites zonder medewerkerspagina's) geen ProfilePage.
     */
    protected static function isOwnProfilePage(int $employeeId): bool
    {
        if (!$employeeId || !is_singular('werknemers') || get_the_ID() !== $employeeId) {
            return false;
        }

        if (!get_option('blog_public')) {
            return false;
        }

        if (class_exists('\RankMath\Helper') && method_exists('\RankMath\Helper', 'is_post_indexable')) {
            return \RankMath\Helper::is_post_indexable($employeeId, false);
        }

        return true;
    }
}
