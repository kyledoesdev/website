<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Filesystem Configuration
    |--------------------------------------------------------------------------
    |
    | This setting determines the filesystem disk used by Prezet to store and
    | retrieve markdown files and images. By default, it uses the 'prezet' disk.
    |
    */

    'filesystem' => [
        'disk' => env('PREZET_FILESYSTEM_DISK', 'prezet'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Slug Configuration
    |--------------------------------------------------------------------------
    |
    | Configure how document slugs are generated. The source can be 'filepath'
    | or 'title'. Note that a slug defined in front matter will take precedence
    | over the generated slug. When 'keyed' is true, the key present in the
    | front matter key will be appended to the slug (e.g., my-post-123).
    |
    */

    'slug' => [
        'source' => 'filepath', // 'filepath' or 'title'
        'keyed' => false, // 'true' or 'false'
    ],

    /*
    |--------------------------------------------------------------------------
    | CommonMark
    |--------------------------------------------------------------------------
    |
    | Configure the CommonMark Markdown parser. You can specify the extensions
    | to be used and their configuration. Extensions are added in the order
    | they are listed.
    |
    */

    'commonmark' => [

        'extensions' => [
            League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension::class,
            League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension::class,
            League\CommonMark\Extension\ExternalLink\ExternalLinkExtension::class,
            League\CommonMark\Extension\FrontMatter\FrontMatterExtension::class,
            Prezet\Prezet\Extensions\MarkdownBladeExtension::class,
            Prezet\Prezet\Extensions\MarkdownImageExtension::class,
            /* Phiki\CommonMark\PhikiExtension::class, - using prism js at vite config level */
        ],

        'config' => [
            'heading_permalink' => [
                'html_class' => 'prezet-heading',
                'id_prefix' => 'content',
                'apply_id_to_heading' => false,
                'heading_class' => '',
                'fragment_prefix' => 'content',
                'insert' => 'before',
                'min_heading_level' => 2,
                'max_heading_level' => 3,
                'title' => 'Permalink',
                'symbol' => '#',
                'aria_hidden' => false,
            ],
            'external_link' => [
                'internal_hosts' => 'www.example.com', // Don't forget to set this!
                'open_in_new_window' => true,
                'html_class' => 'external-link',
                'nofollow' => 'external',
                'noopener' => 'external',
                'noreferrer' => 'external',
            ],
            'phiki' => [
                'theme' => \Phiki\Theme\Theme::NightOwl,
                'with_wrapper' => false,
                'with_gutter' => true,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Images
    |--------------------------------------------------------------------------
    |
    | Configure how image tags are handled when converting from markdown.
    |
    | 'widths' defines the various widths for responsive images.
    | 'sizes' indicates the sizes attribute for responsive images.
    | 'zoomable' determines if images are zoomable.
    */

    'image' => [

        'widths' => [
            480, 640, 768, 960, 1536,
        ],

        'sizes' => '92vw, (max-width: 1024px) 92vw, 768px',

        'zoomable' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Sitemap
    |--------------------------------------------------------------------------
    | The sitemap origin is used to generate absolute URLs for the sitemap.
    | An origin consists of a scheme/host/port combination, but no path.
    | (e.g., https://example.com:8000) https://www.rfc-editor.org/rfc/rfc6454
    */

    'sitemap' => [
        'origin' => env('PREZET_SITEMAP_ORIGIN', env('APP_URL')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Structured Data
    |--------------------------------------------------------------------------
    |
    | Prezet uses these values for JSON-LD structured data. 'authors' defines
    | named authors you can reference in front matter, and 'publisher' is used
    | as the default publisher for all content.
    |
    */

    // https://schema.org/author
    'authors' => [
        'kyle_evangelisto' => [
            '@type' => 'Person',
            'name' => 'Kyle Evangelisto',
            'url' => 'https://kyledoes.dev',
            'image' => 'https://kyledoes.dev/me.jfif',
        ],
    ],

    // https://schema.org/publisher
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'Kyle Evangelisto',
        'url' => 'https://kyledoes.dev',
        'logo' => 'https://i.imgur.com/oWpheij.jpeg',
        'image' => 'https://i.imgur.com/oWpheij.jpeg',
    ],
];
