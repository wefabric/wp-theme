<?php

namespace Theme\Views\Blocks;

use Theme\Views\ButtonCollection;
use Theme\Views\Components\BlockComponent;

class HeaderBlock extends BlockComponent
{
    // --- Header style ---
    public string $headerStyle = 'fixed_height';
    public int|string $headerHeight = '';
    public string $headerClass = '';
    public string $headerName = '';

    // --- Content ---
    public string $title = '';
    public string $titleColor = '';
    public string $subTitle = '';
    public string $subTitleColor = '';
    public bool $showTitle = true;
    public string $text = '';
    public string $textColor = '';

    // --- Content image ---
    public int|string $contentImageId = '';
    public string $contentImageAlt = '';
    public bool $fullHeightContentImage = false;
    public string $title2 = '';
    public string $text2 = '';

    // --- Buttons ---
    public ?ButtonCollection $buttons = null;

    // --- Tags ---
    public array $tags = [];

    // --- Text position ---
    public string $textPosition = '';
    public string $textPositionClass = '';
    public string $textWidthClass = '';

    // --- Breadcrumbs ---
    public bool $breadcrumbsEnabled = false;
    public string $breadcrumbsBackgroundColor = '';
    public string $breadcrumbsTextColor = '';
    public string $breadcrumbsLocation = 'underneath';

    // --- Background / overlay ---
    public int|string $backgroundImageId = '';
    public bool $showFeaturedImage = false;
    public string $featuredImage = '';
    public int|string $featuredImageId = '';
    public int|string $backgroundVideoId = '';
    public string $backgroundVideoURL = '';
    public bool $overlayEnabled = false;
    public string $overlayColor = '';
    public string $overlayOpacity = '';
    public bool $backgroundImageParallax = false;

    // --- Block settings ---
    public string $headerBackgroundColor = '';
    public string $customBlockClasses = '';
    public string $customBlockId = '';
    public bool $hideBlock = false;

    // --- Theme settings ---
    public string $borderRadius = '';

    // --- Extra features ---
    public bool $showReadingProgress = false;
    public bool $showScrollIndicator = false;

    private array $heightClasses = [
        1 => 'h-[400px] sm:h-[500px] md:h-[500px] lg:h-[500px] xl:h-[500px] 2xl:h-[800px]',
        2 => 'h-[200px] md:h-[400px] 2xl:h-[500px]',
        3 => 'h-[120px] md:h-[200px]',
    ];

    private array $headerNames = [
        1 => 'big-header',
        2 => 'medium-header',
        3 => 'small-header',
    ];

    private array $textPositionClassMap = [
        'left'   => 'justify-start text-left',
        'center' => 'justify-center text-center items-center',
        'right'  => 'justify-end text-left',
    ];

    public function setBlockData(): void
    {
        $data = $this->block['data'] ?? [];

        // Header style
        $this->headerStyle  = $data['header_style'] ?? 'fixed_height';
        $this->headerHeight = $data['header_height'] ?? '';

        if ($this->headerStyle === 'fixed_height') {
            $this->headerClass = $this->heightClasses[$this->headerHeight] ?? '';
        }

        $this->headerName = $this->headerNames[$this->headerHeight] ?? '';

        // Content
        $this->title         = $this->getTitle($data);
        $this->titleColor    = $data['title_color'] ?? '';
        $this->subTitle      = $data['subtitle'] ?? '';
        $this->subTitleColor = $data['subtitle_color'] ?? '';
        $this->showTitle     = $data['show_title'] ?? true;
        $this->text          = $data['text'] ?? '';
        $this->textColor     = $data['text_color'] ?? '';

        // Content image
        $this->contentImageId         = $data['content_image'] ?? '';
        $this->contentImageAlt        = $this->contentImageId ? (string) get_post_meta($this->contentImageId, '_wp_attachment_image_alt', true) : '';
        $this->fullHeightContentImage = (bool) ($data['full_height_image'] ?? false);
        $this->title2                 = $data['title_2'] ?? '';
        $this->text2                  = $data['text_2'] ?? '';

        // Buttons
        $this->buttons = ButtonCollection::fromBlockData($this->block);

        // Tags
        $tagsCount  = (int) ($data['tags'] ?? 0);
        $this->tags = [];
        for ($i = 0; $i < $tagsCount; $i++) {
            $tagText = $data["tags_{$i}_tag"] ?? '';
            if (!empty($tagText)) {
                $this->tags[] = ['text' => $tagText];
            }
        }

        // Text position
        $this->textPosition      = $data['text_position'] ?? '';
        $this->textPositionClass = $this->textPositionClassMap[$this->textPosition] ?? '';

        if (!$this->contentImageId) {
            $this->textWidthClass = match ($this->textPosition) {
                'left'   => ($this->headerHeight == 3) ? 'w-full' : 'w-full md:w-2/3 xl:w-2/3',
                'center' => ($this->headerHeight == 3) ? 'w-full' : 'w-full xl:w-3/4',
                'right'  => ($this->headerHeight == 3) ? 'w-full md:w-2/3' : 'w-full md:w-1/2 xl:w-1/3',
                default  => '',
            };
        }

        // Breadcrumbs
        $this->breadcrumbsEnabled         = (bool) ($data['show_breadcrumbs'] ?? false);
        $this->breadcrumbsBackgroundColor = $data['breadcrumbs_background_color'] ?? '';
        $this->breadcrumbsTextColor       = $data['breadcrumbs_text_color'] ?? '';
        $this->breadcrumbsLocation        = $data['breadcrumbs_location'] ?? 'underneath';

        // Background / overlay
        $this->backgroundImageId       = $data['background_image'] ?? '';
        $this->showFeaturedImage       = (bool) ($data['show_featured_image'] ?? false);
        $this->featuredImage           = $this->showFeaturedImage ? (string) get_the_post_thumbnail_url(get_the_ID(), 'full') : '';
        $this->featuredImageId         = $this->featuredImage ? (int) attachment_url_to_postid($this->featuredImage) : '';
        $this->backgroundVideoId       = $data['background_video'] ?? '';
        $this->backgroundVideoURL      = $this->backgroundVideoId ? (string) wp_get_attachment_url($this->backgroundVideoId) : '';
        $this->overlayEnabled          = (bool) ($data['overlay_image'] ?? false);
        $this->overlayColor            = $data['overlay_color'] ?? '';
        $this->overlayOpacity          = $data['overlay_opacity'] ?? '';
        $this->backgroundImageParallax = (bool) ($data['background_image_parallax'] ?? false);

        // Block settings
        $this->headerBackgroundColor = $data['background_color'] ?? '';
        $this->customBlockClasses    = $data['custom_css_classes'] ?? '';
        $this->customBlockId         = $data['custom_block_id'] ?? '';
        $this->hideBlock             = (bool) ($data['hide_block'] ?? false);

        // Theme settings
        $options            = function_exists('get_fields') ? get_fields('option') : [];
        $this->borderRadius = ($options['rounded_design'] ?? false) === true
            ? ($options['border_radius_strength'] ?? '')
            : 'rounded-none';

        // Extra features
        $this->showReadingProgress = (bool) ($data['show_reading_progress'] ?? false);
        $this->showScrollIndicator = (bool) ($data['show_scroll_indicator'] ?? false);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.blocks.header.index');
    }

    private function getTitle(array $data): string
    {
        $title = !empty($data['title']) ? $data['title'] : (function_exists('get_the_title') ? get_the_title() : '');
        $title = $this->getPaginationTitle($title);
        return $title;
    }

    public function getPaginationTitle(string $title): string
    {
        if(is_paged()) {
            $title .= ' - ' . __('Pagina', THEME_TD) . ' ' . get_query_var('paged');
        }

        return $title;
    }
}
