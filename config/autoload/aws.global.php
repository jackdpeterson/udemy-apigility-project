<?php
return [
    /**
     * You can define global configuration settings for the SDK as an array.
     * Typically, you will want to a provide your
     * credentials (key and secret key) and the region (e.g. us-west-2) in which you would like to use your services.
     * You can also override the setting on a per service basic.
     *
     * To avoid breaking in your code when updating the SDK, we always recommend you to manually select a version for
     * each service instead of relying on the 'latest' keyword
     */
    
    'aws' => [
        'credentials' => [
            'key' => 'AKIAILM4WJZDMSRXR3EQ',
            'secret' => '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'
        ],
        'region' => 'us-east-1',
        'version' => 'latest',
        'services' => [
            'ses' => [
                'params' => [
                    'region' => 'us-east-1',
                    'credentials' => []
                ]
            ]
        ]
    ]
];