<?php

namespace Theme\Helpers;

use Wefabric\WPSupport\Schema\JsonLd;

/**
 * Bouwt het JobPosting-schema voor een vacature en zorgt dat er per pagina
 * maximaal één JobPosting in de Rank Math-graph staat.
 */
class VacancySchema
{
    /**
     * Blokken waarvan de tekst niet bij de vacatureomschrijving hoort.
     */
    protected const SKIP_BLOCKS = [
        'wefabric/header',
        'wefabric/formulier',
        'wefabric/werknemers',
        'wefabric/vacatures',
        'wefabric/cta-button',
        'wefabric/cta-contact',
        'wefabric/cta-werknemer',
        'wefabric/cta-whitepaper',
        'wefabric/delen',
        'wefabric/sticky-balk',
        'wefabric/modal',
    ];

    /**
     * Tags die Google toestaat in een JobPosting-description.
     */
    protected const ALLOWED_HTML = [
        'p' => [], 'br' => [], 'ul' => [], 'ol' => [], 'li' => [],
        'strong' => [], 'b' => [], 'em' => [], 'i' => [],
        'h2' => [], 'h3' => [], 'h4' => [],
    ];

    protected static bool $dedupeRegistered = false;

    /**
     * Registreer het JobPosting-schema van een vacature, alleen op de eigen
     * vacaturepagina (Google keurt JobPosting op overzichtspagina's af).
     */
    public static function register(int $vacancyId): void
    {
        if (!is_singular('vacatures') || get_the_ID() !== $vacancyId) {
            return;
        }

        if (array_key_exists('vacancy_' . $vacancyId, JsonLd::getSchemas())) {
            return;
        }

        JsonLd::addSchema('vacancy_' . $vacancyId, static::build($vacancyId));
        static::registerDedupe();
    }

    public static function build(int $vacancyId): array
    {
        $fields = get_fields($vacancyId) ?: [];
        $title = strip_tags(get_the_title($vacancyId));

        $schema = [
            '@type' => 'JobPosting',
            'title' => $title,
            'datePosted' => get_the_date('Y-m-d', $vacancyId),
            'description' => static::description($vacancyId, $fields['excerpt'] ?? '') ?: $title,
            'hiringOrganization' => array_filter([
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'sameAs' => home_url('/'),
                'logo' => str_replace('//content', '/content', get_site_icon_url()),
            ]),
            'jobLocation' => [
                '@type' => 'Place',
                'address' => static::address($fields['location'] ?? ''),
            ],
        ];

        $employmentType = static::employmentType($fields['working_hours'] ?? '');
        if ($employmentType) {
            $schema['employmentType'] = $employmentType;
        }

        $baseSalary = static::baseSalary($fields['salary'] ?? '');
        if ($baseSalary) {
            $schema['baseSalary'] = $baseSalary;
        }

        $thumbnailId = get_post_thumbnail_id($vacancyId);
        if ($thumbnailId) {
            $schema['image'] = str_replace('//content', '/content', wp_get_attachment_image_url($thumbnailId, 'job-thumbnail'));
        }

        // Alleen claimen dat je direct kunt solliciteren als er een formulier op de pagina staat.
        if (has_block('wefabric/formulier', $vacancyId)) {
            $schema['directApply'] = true;
        }

        return $schema;
    }

    /**
     * Volledige vacaturetekst: samenvatting + titels/teksten/USP's uit de blokken.
     */
    protected static function description(int $vacancyId, string $excerpt): string
    {
        $parts = [];

        if (trim(strip_tags($excerpt)) !== '') {
            $parts[] = wpautop(trim($excerpt));
        }

        $post = get_post($vacancyId);
        if ($post) {
            static::collectBlockText(parse_blocks($post->post_content), $parts);
        }

        $html = wp_kses(implode("\n", $parts), static::ALLOWED_HTML);

        return trim(preg_replace('/\s+/', ' ', $html));
    }

    protected static function collectBlockText(array $blocks, array &$parts): void
    {
        foreach ($blocks as $block) {
            $name = $block['blockName'] ?? '';
            if (!$name || in_array($name, static::SKIP_BLOCKS, true)) {
                continue;
            }

            $data = $block['attrs']['data'] ?? [];

            if (!empty($data['title']) && is_string($data['title'])) {
                $parts[] = '<h3>' . strip_tags($data['title']) . '</h3>';
            }

            if (!empty($data['text']) && is_string($data['text'])) {
                $parts[] = wpautop($data['text']);
            }

            $usps = [];
            foreach ($data as $key => $value) {
                if (is_string($value) && $value !== '' && preg_match('/^usps_\d+_usp_title$/', $key)) {
                    $usps[] = '<li>' . strip_tags($value) . '</li>';
                }
            }
            if ($usps) {
                $parts[] = '<ul>' . implode('', $usps) . '</ul>';
            }

            // Core-blokken (paragraaf, lijst, kop) bevatten hun tekst als HTML.
            if (str_starts_with($name, 'core/') && !empty($block['innerHTML'])) {
                $parts[] = $block['innerHTML'];
            }

            if (!empty($block['innerBlocks'])) {
                static::collectBlockText($block['innerBlocks'], $parts);
            }
        }
    }

    /**
     * Vul straat/postcode aan vanuit het Rank Math-bedrijfsadres als de
     * vacaturelocatie daarmee overeenkomt (of leeg is).
     */
    protected static function address(string $location): array
    {
        $location = trim(strip_tags($location));
        $address = [
            '@type' => 'PostalAddress',
            'addressLocality' => $location,
            'addressCountry' => 'NL',
        ];

        $titles = get_option('rank-math-options-titles');
        $local = is_array($titles) ? ($titles['local_address'] ?? []) : [];
        $localCity = trim($local['addressLocality'] ?? '');

        if ($localCity && ($location === '' || strcasecmp($location, $localCity) === 0)) {
            $address['streetAddress'] = $local['streetAddress'] ?? '';
            $address['postalCode'] = $local['postalCode'] ?? '';
            $address['addressRegion'] = $local['addressRegion'] ?? '';
            $address['addressLocality'] = $localCity;
        }

        return array_filter($address);
    }

    /**
     * @return string|array|null
     */
    protected static function employmentType(string $workingHours)
    {
        $lower = strtolower($workingHours);
        $full = str_contains($lower, 'fulltime') || str_contains($lower, 'full-time');
        $part = str_contains($lower, 'parttime') || str_contains($lower, 'part-time');

        if ($full && $part) {
            return ['FULL_TIME', 'PART_TIME'];
        }
        if ($part) {
            return 'PART_TIME';
        }
        if ($full) {
            return 'FULL_TIME';
        }

        return null;
    }

    /**
     * Alleen een baseSalary als er echte bedragen in staan; tekst als
     * 'marktconform' levert anders een ongeldige waarde op.
     */
    protected static function baseSalary(string $salary): ?array
    {
        $salary = strtolower(strip_tags($salary));
        if (trim($salary) === '') {
            return null;
        }

        // Nederlandse notatie: "€ 2.800" → 2800, "€ 18,50" → 18.5.
        preg_match_all('/\d[\d.]*(?:,\d{1,2})?/', $salary, $matches);
        $amounts = array_values(array_filter(array_map(function ($amount) {
            $amount = (float) str_replace(',', '.', str_replace('.', '', $amount));
            return floor($amount) == $amount ? (int) $amount : $amount;
        }, $matches[0])));

        if (!$amounts) {
            return null;
        }

        if (str_contains($salary, 'uur')) {
            $unit = 'HOUR';
        } elseif (str_contains($salary, 'jaar')) {
            $unit = 'YEAR';
        } elseif (str_contains($salary, 'week')) {
            $unit = 'WEEK';
        } else {
            $unit = 'MONTH';
        }

        $value = ['@type' => 'QuantitativeValue', 'unitText' => $unit];
        if (count($amounts) >= 2) {
            $value['minValue'] = min($amounts[0], $amounts[1]);
            $value['maxValue'] = max($amounts[0], $amounts[1]);
        } else {
            $value['value'] = $amounts[0];
        }

        return [
            '@type' => 'MonetaryAmount',
            'currency' => 'EUR',
            'value' => $value,
        ];
    }

    /**
     * Als Rank Math zelf al een JobPosting levert (Schema Generator-template),
     * dan die laten staan en de automatische van het thema weghalen. Zo komen
     * er nooit twee tegenstrijdige JobPosting-nodes op één pagina.
     */
    protected static function registerDedupe(): void
    {
        if (static::$dedupeRegistered) {
            return;
        }
        static::$dedupeRegistered = true;

        add_filter('rank_math/json_ld', function ($data) {
            if (!is_array($data)) {
                return $data;
            }

            $hasRankMathJob = false;
            foreach ($data as $key => $node) {
                if (is_array($node) && ($node['@type'] ?? '') === 'JobPosting' && !str_starts_with((string) $key, 'vacancy_')) {
                    $hasRankMathJob = true;
                    break;
                }
            }

            if ($hasRankMathJob) {
                foreach (array_keys($data) as $key) {
                    if (str_starts_with((string) $key, 'vacancy_')) {
                        unset($data[$key]);
                    }
                }
            }

            return $data;
        }, 100, 1);
    }
}
