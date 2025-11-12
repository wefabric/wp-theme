@php
    $fields = get_fields($post);
    $postThumbnailId = get_post_thumbnail_id($post);
    $postTitle = get_the_title($post);
    $postUrl = get_permalink($post);

    $postLocation = $fields['post_location'] ?? '';

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $postSummary = get_the_excerpt($post);
        $maxSummaryLength = 180;
        if (strlen($postSummary) > $maxSummaryLength) {
            $postSummary = substr($postSummary, 0, $maxSummaryLength - 3) . '...';
        }
    $postDate = get_the_date('j F, Y', $post);
    $postAuthorId = get_post_field('post_author', $post);
    $postAuthorName = get_the_author_meta('display_name', $postAuthorId);
    $postCategories = get_the_category($post);
@endphp

<div class="nieuws-item group h-full @if ($flyinEffect) news-hidden @endif">
    <div class="news-wrapper relative h-full flex flex-col {{ $hoverEffectClass }} duration-300 ease-in-out">
        @if ($postThumbnailId)
            <div class="news-image max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
                <a href="{{ $postUrl }}" aria-label="Ga naar {{ $postTitle }} pagina"
                   class="card-overlay absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out">
                    <span class="sr-only">Ga naar {{ $postTitle }} pagina</span>
                </a>
                @if (!empty($visibleElements) && in_array('category', $visibleElements))
                    <div class="news-categories absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                        @php
                            $categoriesToShow = $onlyPrimaryCategory ? [reset($postCategories)] : $postCategories;
                        @endphp

                        @foreach ($categoriesToShow as $category)
                            @php
                                if (!$category) continue;
                                $categoryColor = get_field('category_color', $category);
                                $categoryIcon = get_field('category_icon', $category);
                            @endphp
                            <a href="{{ get_category_link($category) }}" style="background-color: {{ $categoryColor }}" class="news-category @if(empty($categoryColor)) bg-primary hover:bg-primary-dark @endif text-white px-4 py-2 rounded-full flex items-center gap-x-1" aria-label="Ga naar {{ $category->name }}">
                                {!! $categoryIcon !!} {!! $category->name !!}
                            </a>
                        @endforeach
                    </div>
                @endif
                @if (!empty($visibleElements) && in_array('reading_time', $visibleElements))
                    @php
                        $content = get_post_field('post_content', $post);

                        // Snel en correct: render Gutenberg-blokken naar HTML en lees alleen zichtbare DOM-tekst
                        $wordsPerMinute = 225; // pas aan indien gewenst

                        $renderBlocksToText = function ($blocks) {
                            $html = '';
                            foreach ($blocks as $block) {
                                // Render elk blok zoals op de frontend (pakt ook dynamic blocks/ACF attrs)
                                $html .= render_block($block);
                            }
                            // Strip alle HTML en normaliseer whitespace
                            $text = wp_strip_all_tags($html);
                            return trim(preg_replace('/\s+/', ' ', $text));
                        };

                        $plain = '';
                        if (function_exists('has_blocks') && has_blocks($content)) {
                            $blocks = parse_blocks($content);
                            $plain = $renderBlocksToText($blocks);
                        }

                        // Fallback: klassieke editor / geen blokken of geen tekst gevonden
                        if ($plain === '') {
                            $raw = strip_shortcodes($content);
                            $plain = trim(preg_replace('/\s+/', ' ', wp_strip_all_tags($raw)));
                        }

                        // Laatste redmiddel: titel + excerpt
                        if ($plain === '') {
                            $fallback = (string) get_the_title($post) . ' ' . (string) get_the_excerpt($post);
                            $plain = trim(preg_replace('/\s+/', ' ', wp_strip_all_tags($fallback)));
                        }

                        // Tel woorden incl. cijfers (alleen DOM-tekst), Unicode-veilig
                        $wordCount = 0;
                        if ($plain !== '') {
                            if (preg_match_all('/[\p{L}\p{N}]+/u', $plain, $m)) {
                                $wordCount = count($m[0]);
                            }
                        }
                        $readingTime = max(1, (int) ceil($wordCount / $wordsPerMinute));
                    @endphp
                    <div class="news-reading-time absolute z-20 top-[15px] right-[15px]">
                        <div class="reading-time bg-primary text-white px-4 py-2 rounded-full flex items-center gap-x-1">
                            <i class="fa-classic fa-solid fa-clock" aria-hidden="true"></i>{{ $readingTime }} {{ _n('min', 'min', $readingTime, 'text-domain') }}
                        </div>
                    </div>
                @endif

                @include('components.image', [
                    'image_id' => $postThumbnailId,
                    'size' => 'full',
                    'object_fit' => 'cover',
                    'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110',
                    'alt' => $postTitle,
                ])
            </div>
        @endif
        <div class="news-data flex flex-col w-full grow mt-5">

            <a href="{{ $postUrl }}" aria-label="Ga naar {{ $postTitle }} pagina" class="news-title text-{{ $newsTitleColor }} font-bold group-hover:text-primary">{!! $postTitle !!}</a>

            <div class="news-info">
                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($postSummary))
                    <div class="news-summary text-{{ $newsTextColor }} mt-3 mb-2">{!! $postSummary !!}</div>
                @endif

                @if (!empty($visibleElements) && in_array('author', $visibleElements) && !empty($postAuthorName))
                    <div class="news-author mt-4 text-{{ $newsTextColor }}">Geschreven door {!! $postAuthorName !!}</div>
                @endif

                @if (!empty($visibleElements) && in_array('date', $visibleElements) && !empty($postDate))
                    <div class="news-post-date mb-2 text-{{ $newsTextColor }}">{{ $postDate }}</div>
                @endif

            </div>

            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                @if ($buttonCardText)
                    <div class="news-button mt-auto pt-8 z-10">
                        @include('components.buttons.default', [
                           'text' => $buttonCardText,
                           'href' => $postUrl,
                           'alt' => $buttonCardText,
                           'colors' => 'btn-' . $buttonCardColor . ' btn-' . $buttonCardStyle,
                           'class' => 'rounded-lg',
                           'icon' => $buttonCardIcon,
                        ])
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>