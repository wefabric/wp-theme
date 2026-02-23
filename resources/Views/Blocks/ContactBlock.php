<?php

namespace Theme\Views\Blocks;

use Theme\Concerns\HasTextContent;
use Theme\Views\Components\BlockComponent;
use Wefabric\WPEstablishments\Establishment;
use WP_Query;

class ContactBlock extends BlockComponent
{
    use HasTextContent;

    public string $contentBackgroundColor = '';
    public string $contentClass = '';
    public string $formPosition = 'right';

    public $form = null;
    public string $formTitle = '';
    public string $formTitleColor = '';
    public string $formSubTitle = '';
    public string $formSubTitleColor = '';
    public string $formTextColor = '';
    public string $formInputColor = '';
    public string $formBackgroundColor = '';
    public string $formClass = '';

    public array $visibleElements = [];
    public $establishment_query = null;

    public function setBlockData(): void
    {
        $this->setTextContentData();

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
        $this->formSubTitle = $this->block['data']['form_subtitle'] ?? '';

        // Colors
        $this->formTitleColor = $this->getBlockColor('form_title_color', '');
        $this->formSubTitleColor = $this->getBlockColor('form_subtitle_color', '');
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
