@php
    $embedSource = $embed['embed'] ?? '';
    $embedHeight = $block['data']['embed_height'] ?? 600;
@endphp

@if ($embedSource)
    @php
        $embedHtml = '';
        if (strpos($embedSource, '<iframe') !== false) {
            $embedHtml = $embedSource;

            // Update height in manual iframe code
            if (strpos($embedHtml, 'height="') !== false) {
                $embedHtml = preg_replace('/height="[^"]*"/', 'height="' . $embedHeight . '"', $embedHtml);
            } else {
                $embedHtml = str_replace('<iframe', '<iframe height="' . $embedHeight . '"', $embedHtml);
            }

            // Ensure allow attributes are present in manual iframe code
            if (strpos($embedHtml, 'allow="') === false) {
                $embedHtml = str_replace('<iframe', '<iframe allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture; web-share"', $embedHtml);
            } else {
                if (strpos($embedHtml, 'autoplay') === false) {
                    $embedHtml = str_replace('allow="', 'allow="autoplay; ', $embedHtml);
                }
                if (strpos($embedHtml, 'clipboard-write') === false) {
                    $embedHtml = str_replace('allow="', 'allow="clipboard-write; ', $embedHtml);
                }
                if (strpos($embedHtml, 'encrypted-media') === false) {
                    $embedHtml = str_replace('allow="', 'allow="encrypted-media; ', $embedHtml);
                }
                if (strpos($embedHtml, 'fullscreen') === false) {
                    $embedHtml = str_replace('allow="', 'allow="fullscreen; ', $embedHtml);
                }
                if (strpos($embedHtml, 'picture-in-picture') === false) {
                    $embedHtml = str_replace('allow="', 'allow="picture-in-picture; ', $embedHtml);
                }
                if (strpos($embedHtml, 'web-share') === false) {
                    $embedHtml = str_replace('allow="', 'allow="web-share; ', $embedHtml);
                }
            }
        } else {
            if (is_admin() || (defined('REST_REQUEST') && REST_REQUEST)) {
                $embedHtml = '<div class="flex items-center justify-center bg-gray-100 border-2 border-dashed border-gray-300" style="height: ' . $embedHeight . 'px;">
                    <div class="text-center p-4">
                        <i class="fa-solid fa-share-nodes text-3xl mb-2 text-gray-400"></i>
                        <p class="text-sm text-gray-500">Embed preview is uitgeschakeld in de editor om de snelheid te verbeteren.</p>
                        <code class="text-xs text-gray-400 break-all">' . $embedSource . '</code>
                    </div>
                </div>';
            } else {
                // Check if the current environment is front-end or AJAX/CRON
                // wp_oembed_get can be slow and cause 502s if it fails to fetch content
                $cache_key = 'embed_' . md5($embedSource . $embedHeight);
                $embedHtml = get_transient($cache_key);

                if ($embedHtml === false) {
                    $embedHtml = wp_oembed_get($embedSource, ['height' => $embedHeight]);
                    if ($embedHtml) {
                        set_transient($cache_key, $embedHtml, DAY_IN_SECONDS);
                    }
                }

                if (!$embedHtml) {
                    $embedHtml = '<iframe width="100%" height="' . $embedHeight . '" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="' . $embedSource . '" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture; web-share"></iframe>';
                } else {
                    // Update height in oembed html if it's an iframe
                    if (strpos($embedHtml, '<iframe') !== false) {
                        if (strpos($embedHtml, 'height="') !== false) {
                            $embedHtml = preg_replace('/height="[^"]*"/', 'height="' . $embedHeight . '"', $embedHtml);
                        } else {
                            $embedHtml = str_replace('<iframe', '<iframe height="' . $embedHeight . '"', $embedHtml);
                        }
                    }

                    // Add allow attributes to the oembed html if it's an iframe
                    if (strpos($embedHtml, '<iframe') !== false) {
                        if (strpos($embedHtml, 'allow="') === false) {
                            $embedHtml = str_replace('<iframe', '<iframe allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture; web-share"', $embedHtml);
                        } else {
                            if (strpos($embedHtml, 'autoplay') === false) {
                                $embedHtml = str_replace('allow="', 'allow="autoplay; ', $embedHtml);
                            }
                            if (strpos($embedHtml, 'clipboard-write') === false) {
                                $embedHtml = str_replace('allow="', 'allow="clipboard-write; ', $embedHtml);
                            }
                            if (strpos($embedHtml, 'encrypted-media') === false) {
                                $embedHtml = str_replace('allow="', 'allow="encrypted-media; ', $embedHtml);
                            }
                            if (strpos($embedHtml, 'fullscreen') === false) {
                                $embedHtml = str_replace('allow="', 'allow="fullscreen; ', $embedHtml);
                            }
                            if (strpos($embedHtml, 'picture-in-picture') === false) {
                                $embedHtml = str_replace('allow="', 'allow="picture-in-picture; ', $embedHtml);
                            }
                            if (strpos($embedHtml, 'web-share') === false) {
                                $embedHtml = str_replace('allow="', 'allow="web-share; ', $embedHtml);
                            }
                        }
                    }
                }
            }
        }
    @endphp
    {!! $embedHtml !!}
@endif
