<?php

namespace Theme\Views\Blocks;

use Theme\Concerns\HasTextContent;
use Theme\Views\Components\BlockComponent;
use Wefabric\WPEstablishments\Establishment;
use WP_Query;

class ContactBlock extends BlockComponent
{
    use HasTextContent;

    public string $title = '';
    public string $titleColor = '';
    public string $subTitle = '';
    public string $subTitleColor = '';
    public ?array $subtitleIcon = null;
    public string $subtitleIconColor = '';

    public string $contentBackgroundColor = '';
    public string $contentClass = '';
    public string $formPosition = 'right';

    public $form = null;
    public string $formTitle = '';
    public string $formTitleColor = '';
    public string $formTextColor = '';
    public string $formInputColor = '';
    public string $formBackgroundColor = '';
    public string $formClass = '';

    public array $visibleElements = [];
    public $establishment_query = null;

    public string $borderRadius = 'rounded-none';

    public function setBlockData(): void
    {
        $this->setTextContentData();

        $this->title = $this->block['data']['title'] ?? '';
        $this->subTitle = $this->block['data']['subtitle'] ?? '';

        // Colors
        $options = function_exists('get_fields') ? \get_fields('option') : [];
        $globalTitleColor = $options['global_title_color'] ?? '';
        $globalSubTitleColor = $options['global_subtitle_color'] ?? '';
        $globalSubtitleIconColor = $options['global_subtitle_icon_color'] ?? '';
        $globalTextColor = $options['global_text_color'] ?? '';

        $this->titleColor = $this->getBlockColor('title_color', $globalTitleColor ?: $globalTextColor);
        $this->subTitleColor = $this->getBlockColor('subtitle_color', $globalSubTitleColor ?: $globalTextColor);

        $icon = $this->block['data']['subtitle_icon'] ?? null;
        if (is_string($icon)) {
            $this->subtitleIcon = json_decode($icon, true);
        } elseif (is_array($icon)) {
            $this->subtitleIcon = $icon;
        }

        $this->subtitleIconColor = $this->getBlockColor('subtitle_icon_color', $globalSubtitleIconColor ?: ($globalSubTitleColor ?: $globalTextColor));

        $this->contentBackgroundColor = $this->getBlockColor('content_background_color', '');
        $this->formPosition = $this->block['data']['form_position'] ?? 'right';

        $contentWidth = $this->block['data']['content_width'] ?? 50;
        $formWidth = $this->block['data']['form_width'] ?? 50;

        $widthMap = [
            25 => 'lg:w-1/4',
            33 => 'lg:w-1/3',
            50 => 'lg:w-1/2',
            66 => 'lg:w-2/3',
            75 => 'lg:w-3/4',
            100 => 'lg:w-full',
        ];

        $this->contentClass = $widthMap[$contentWidth] ?? 'lg:w-1/2';
        $this->formClass = $widthMap[$formWidth] ?? 'lg:w-1/2';

        $this->form = $this->block['data']['form'] ?? null;
        $this->formTitle = $this->block['data']['form_title'] ?? '';
        $this->formTitleColor = $this->getBlockColor('form_title_color', $globalTitleColor ?: $globalTextColor);
        $this->formTextColor = $this->getBlockColor('form_text_color', '');
        $this->formInputColor = $this->getBlockColor('form_input_color', '');
        $this->formBackgroundColor = $this->getBlockColor('form_background_color', '');

        $this->visibleElements = $this->block['data']['show_element'] ?? [];

        // Establishments query
        $establishmentIds = $this->block['data']['show_specific_establishment'] ?? [];
        $args = [
            'post_type' => 'establishments',
            'posts_per_page' => -1,
        ];
        if (!empty($establishmentIds)) {
            $args['post__in'] = $establishmentIds;
            $args['orderby'] = 'post__in';
        }

        $this->establishment_query = new WP_Query($args);

        $this->borderRadius = $options['border_radius_strength'] ?? '';
    }

    protected function getBlockColor(string $key, string $default): string
    {
        $color = $this->block['data'][$key] ?? null;
        $hasColor = (is_string($color) && $color !== '' && $color !== '0')
            || (is_int($color) && $color !== 0);

        return $hasColor ? (string)$color : $default;
    }

    public function render()
    {
        return view('components.blocks.contact.index');
    }
}
