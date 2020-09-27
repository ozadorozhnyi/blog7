<?php

return [

    /**
     * Seeder settings
     */
    'seed' => (object)[
        'users' => (int) env('SEED_USERS_QTY', 3),
        'articles' => (int) env('SEED_ARTICLES_PER_USER', 20),
    ],

    /**
     * Articles display settings
     */
    'articles' => (object)[
        
        /**
         * Display articles on the main page.
         */
        'per_page' => (int) env('ARTCL_PER_PAGE', 10),

        /**
         * "You may also be interested" articles quantity
         */
        'interested' => (int) env('ARTCL_INTERESTED_QTY', 8),

        /**
         * Most talked articles emulations.
         * 
         * Computed by by subtracting X values from the `interested` collection.
         * This behavior is subject to change in the future in production mode.
         * 
         */
        'most_talked' => (int) env('ARTCL_MOST_TALKED_QTY', 3),
    ],

    /**
     * Image settings
     */
    'image' => (object)[
        /**
         * Max file size allowed, specified in bytes.
         * 15 Mb by default.
         */
        'max_file_size' => (int) env('IMG_MAX_FILE_SIZE', 15728640),

        /**
         * Allowed image types.
         */
        'mime_types_allowed' => env('IMG_MIME_TYPES_ALLOWED', 'jpeg, jpg, png, bmp, gif'),
        
        /**
         * Image resolution settings, max
         */
        'resolution' => (object)[
            'width' => (int) env('IMG_RESOL_WEIGHT', 640),
            'height' => (int) env('IMG_RESOL_HEIGHT', 480),
        ],
    ],

    /**
     * Share links widget
     */
    'share_links' => (object)[

        /**
         * Should we display share buttons on the article page?
         */
        'display' => (boolean) env('SHARE_LINKS_DISPLAY', true),

        /**
         * addthis.com service is used by default
         */
        'service' => env('SHARE_LINKS_SERVICE', 'addthis'),
    ],

];
