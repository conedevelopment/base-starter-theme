<?php

namespace Base\Modules;

use Base\Support\Str;

class Shortcodes extends Module
{
    /**
     * Iframe embed.
     *
     * @return string
     */
    public function iframe($atts, $content = null): string
    {
        $atts = shortcode_atts([
            'type' => 'youtube',
            'message' => __('In order to play embedded YouTube videos, you must agree to the processing of data and the use of associated cookies.', 'base'),
            'btn-on-text' => __('Decline YouTube cookies', 'base'),
            'btn-off-text' => __('Allow YouTube cookies', 'base'),
        ], $atts);

        if ($content) {
            $content = str_replace('src="', 'data-src="', $content);
        }

        return '<div class="restriction" data-type="' . $atts['type'] . '">
                    <div class="restriction__caption">
                        <img class="restriction__icon" src="' . get_template_directory_uri() . '/assets/img/privacy.svg" alt="">
                        <div class="restriction__body">
                            <p>' . $atts['message'] . '</p>
                            <button class="js-sub-cookie-access btn btn--primary" data-type="' . $atts['type'] . '" data-on-text="' . $atts['btn-on-text'] . '" data-off-text="' . $atts['btn-off-text'] . '"></button>
                        </div>
                    </div>
                    ' . $content . '
                </div>';
    }

    /**
     * Responsive table shortcode.
     */
    public function table($atts, $content = null): string
    {
        return '<div class="table-responsive">' . Str::removeEmptyP($content) . '</div>';
    }

    /**
     * Button shortcode.
     */
    public function button($atts, $content = null): string
    {
        $atts = shortcode_atts([
            'url' => '',
            'type' => 'secondary',
            'target' => '_self'
        ], $atts);

        return '<a class="btn btn--' . $atts['type'] . '" href="' . $atts['url'] . '" target="' . $atts['target'] . '">' . $content . '</a>';
    }

    /**
     * Code highlighting shortcode.
     */
    public function code($atts, $content = null): string
    {
        $atts = shortcode_atts([
            'id' => null,
        ], $atts);

        if ($atts['id']) {
            $language = get_field('base_language', $atts['id']);

            $shell = get_field('base_display_shell', $atts['id']);
            $code = get_field('base_code', $atts['id']);

            $code = $code ? $code : $content;
            $codeBlockShell = $shell === 'show' ? '<div class="code-block__header"><span class="code-block__dots"><span class="code-block__dot"></span><span class="code-block__dot"></span><span class="code-block__dot"></span></span></div>' : '';
            $class = $shell === 'show' ? 'code-block code-block--header' : 'code-block';

            $output = '
                <div
                    x-data="{ copied: false }"
                    class="' . $class . '"
                    data-lang="' . esc_attr(strtolower($language['label'])) . '"
                >
                    ' . $codeBlockShell . '
                    <pre>
                        <code class="language-' . esc_attr($language['value']) . '">' . esc_html($code) . '</code>
                    </pre>
                    <button
                        @click="
                            copyCode(`' . esc_js($code) . '`);
                            copied = true;
                            setTimeout(() => copied = false, 2000);
                        "
                        class="code-block__copy" 
                        :class="copied ? \'code-block__copy--active\' : \'\'">
                        <span x-text="copied ? \'' . esc_html__('Copied', 'base') . '\' : \'' . esc_html__('Copy', 'base') . '\'"></span>
                    </button>
                </div>
                <script>
                    function copyCode(code) {
                        let tempInput = document.createElement(\'textarea\');
                        tempInput.value = code;
                        document.body.appendChild(tempInput);
                        tempInput.select();

                        try {
                            document.execCommand(\'copy\');
                        } catch (err) {
                            console.error(\'Could not copy text: \', err);
                        }

                        document.body.removeChild(tempInput);
                    }
                </script>
            ';
        } else {
            $output = '';
        }

        return $output;
    }


    /**
     * Cookie opt in-out btn shortcode.
     */
    public function cookie($atts, $content = null): string
    {
        $args = wp_parse_args(shortcode_atts([
            'type' => 'none',
        ], $atts));

        return '<div class="cookie-acceptance"><button class="js-sub-cookie-access btn btn--primary" data-type="' . $args['type'] . '" data-on-text="' .  __('Decline', 'base') . '" data-off-text="' .  __('Allow', 'base') . '">' . $content . '</button></div>';
    }

    /**
     * Accordion card.
     */
    public function accordionCard($atts, $content = null): string
    {
        $args = wp_parse_args(shortcode_atts([
            'title' => null,
        ], $atts));

        return '<div class="accordion-card"><h3 class="accordion-card__title">' . $args['title'] . '</h3>
        <div class="accordion-card__content" aria-hidden="true"><div class="post-content">' . $content . '</div></div></div>';
    }

    /**
     * Boot the module.
     */
    public function boot(): void
    {
        add_shortcode('table', [$this, 'table']);
        add_shortcode('code', [$this, 'code']);
        add_shortcode('button', [$this, 'button']);
        add_shortcode('accordion-card', [$this, 'accordionCard']);
        add_shortcode('cookie-button', [$this, 'cookie']);
        add_shortcode('iframe', [$this, 'iframe']);
    }
}
