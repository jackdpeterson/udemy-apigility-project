<?php
use ZF\MvcAuth\Authentication\OAuth2Adapter;
return array(
    'view_manager' => array(
        'display_exceptions' => true
    ),
    'zf-oauth2' => array(
        'storage' => 'oauth2.doctrineadapter.default'
    ),
    'zf-mvc-auth' => array(
        'authentication' => array(
            
            'adapters' => array(
                'oauth2_doctrine' => array(
                    'adapter' => OAuth2Adapter::class,
                    'storage' => array(
                        'storage' => 'oauth2.doctrineadapter.default',
                        'route' => '/oauth'
                    )
                )
            ),
            'map' => array(
                'Identity\\V1' => 'oauth2_doctrine'
            )
        )
    )
);