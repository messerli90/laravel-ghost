<?php

return [
    /**
     * The API version of your Ghost blog
     *
     * Read about Ghost API Versioning in their docs:
     * https://ghost.org/docs/faq/api-versioning/
     */
    'ghost_api_version' => env("GHOST_API_VERSION", 4),

    /**
     * Your admin domain can be different to your main domain.
     * All Ghost(Pro) blogs have a `.ghost.io`
     * domain as their admin domain and require https.
     */
    'admin_domain' => env('GHOST_ADMIN_DOMAIN', "https://{admin_domain}"),

    /**
     * The Content API URL and key can be obtained by creating a
     * new Custom Integration under the Integrations screen in Ghost Admin.
     */
    'key' => env('GHOST_API_KEY', '22444f78447824223cefc48062')
];
