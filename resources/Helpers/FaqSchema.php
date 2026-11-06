<?php

namespace Theme\Helpers;

/**
 * Verzamelt de vragen van alle FAQ-blokken op een pagina en zet ze in één
 * FAQPage-node. Google staat maar één FAQPage per pagina toe; voorheen kwam
 * alleen het eerste blok in de schema en vielen de vragen uit volgende blokken weg.
 */
class FaqSchema
{
    protected static array $questions = [];

    protected static bool $registered = false;

    /**
     * @param array $questionsAndAnswers ACF-repeater van het FAQ-blok.
     */
    public static function add(array $questionsAndAnswers): void
    {
        foreach ($questionsAndAnswers as $faq) {
            $question = trim(strip_tags($faq['question_and_answer']['question'] ?? ''));
            $answer = trim(wp_kses($faq['question_and_answer']['answer'] ?? '', [
                'p' => [], 'br' => [], 'ul' => [], 'ol' => [], 'li' => [],
                'a' => ['href' => []], 'strong' => [], 'b' => [], 'em' => [], 'i' => [],
                'h2' => [], 'h3' => [], 'h4' => [],
            ]));

            if ($question === '' || $answer === '') {
                continue;
            }

            // Dezelfde vraag maar één keer opnemen (de eerste telt).
            $key = mb_strtolower($question);
            if (isset(static::$questions[$key])) {
                continue;
            }

            static::$questions[$key] = [
                '@type' => 'Question',
                'name' => $question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $answer,
                ],
            ];
        }

        static::register();
    }

    protected static function register(): void
    {
        if (static::$registered) {
            return;
        }
        static::$registered = true;

        add_filter('rank_math/json_ld', function ($data) {
            if (empty(static::$questions)) {
                return $data;
            }

            // Een handmatig ingesteld FAQPage-schema uit Rank Math heeft voorrang.
            foreach ((array) $data as $node) {
                if (is_array($node) && ($node['@type'] ?? '') === 'FAQPage') {
                    return $data;
                }
            }

            $data['faq_page'] = [
                '@type' => 'FAQPage',
                'mainEntity' => array_values(static::$questions),
            ];

            return $data;
        }, 99, 1);
    }
}
