<?php

namespace Theme\Actions;

use WP_Query;

class ExportVacanciesAction
{
    const POST_TYPE = 'vacatures';

    /**
     * Export vacancies data.
     *
     * @return array
     */
    public function execute(): array
    {
        if (!post_type_exists(self::POST_TYPE)) {
            return [
                'error' => 'Post type "vacatures" not found.',
                'status' => 404
            ];
        }

        $args = [
            'post_type' => self::POST_TYPE,
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ];

        $query = new WP_Query($args);
        $posts = $query->posts;

        $data = [];
        $header = [
            'salary.value',
            'salary.currency',
            'salary.unitText',
            'workHours',
            'jobLocationType',
            'applicantLocationRequirements',
            'educationRequirements',
            'experienceRequirements',
            'industry',
            'occupationalCategory',
            'responsibilities',
            'skills',
            'qualifications',
            'benefits'
        ];

        foreach ($posts as $post) {
            $fields = get_fields($post->ID);
            
            $categories = get_the_terms($post->ID, 'vacature_categories');
            $categoryNames = [];
            if ($categories && !is_wp_error($categories)) {
                foreach ($categories as $category) {
                    $categoryNames[] = $category->name;
                }
            }

            $workingHours = $fields['working_hours'] ?? '';
            if (is_array($workingHours)) {
                $labels = [];
                foreach ($workingHours as $wh) {
                    $labels[] = match ($wh) {
                        'parttime', 'both' => '32-40 uur',
                        'fulltime' => '40 uur',
                        default => $wh,
                    };
                }
                $workingHoursLabel = implode(', ', $labels);
            } else {
                $workingHoursLabel = match ($workingHours) {
                    'both', 'parttime' => '32-40 uur',
                    'fulltime' => '40 uur',
                    default => $workingHours,
                };
            }

            // Extract numeric value from salary if possible
            $salaryValue = $fields['salary'] ?? '';
            if (preg_match('/[0-9.,]+/', $salaryValue, $matches)) {
                $salaryValue = str_replace(['.', ','], ['', '.'], $matches[0]);
            }

            $responsibilities = $post->post_content;
            // Clean up HTML tags for CSV
            $responsibilities = wp_strip_all_tags($responsibilities);

            $data[] = [
                $salaryValue, // salary.value
                'EUR', // salary.currency
                'MONTH', // salary.unitText
                $workingHoursLabel, // workHours
                'ONSITE', // jobLocationType
                'NL', // applicantLocationRequirements
                '', // educationRequirements
                '', // experienceRequirements
                implode(', ', $categoryNames), // industry
                $post->post_title, // occupationalCategory
                $responsibilities, // responsibilities
                '', // skills
                '', // qualifications
                ''  // benefits
            ];
        }

        return [
            'header' => $header,
            'data' => $data
        ];
    }

}
