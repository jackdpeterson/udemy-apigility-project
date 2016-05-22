<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Identity\\V1\\Rest\\User\\UserResource' => 'Identity\\V1\\Rest\\User\\UserResourceFactory',
            'Identity\\V1\\Rest\\BeginPasswordReset\\BeginPasswordResetResource' => 'Identity\\V1\\Rest\\BeginPasswordReset\\BeginPasswordResetResourceFactory',
            'Identity\\V1\\Rest\\FinishPasswordReset\\FinishPasswordResetResource' => 'Identity\\V1\\Rest\\FinishPasswordReset\\FinishPasswordResetResourceFactory',
            'Identity\\V1\\Rest\\TestFilter\\TestFilterResource' => 'Identity\\V1\\Rest\\TestFilter\\TestFilterResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'identity.rest.user' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/user[/:user_id]',
                    'defaults' => array(
                        'controller' => 'Identity\\V1\\Rest\\User\\Controller',
                    ),
                ),
            ),
            'identity.rest.begin-password-reset' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/account/begin-password-reset[/:begin_password_reset_id]',
                    'defaults' => array(
                        'controller' => 'Identity\\V1\\Rest\\BeginPasswordReset\\Controller',
                    ),
                ),
            ),
            'identity.rest.finish-password-reset' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/account/finish-password-reset[/:finish_password_reset_id]',
                    'defaults' => array(
                        'controller' => 'Identity\\V1\\Rest\\FinishPasswordReset\\Controller',
                    ),
                ),
            ),
            'identity.rest.test-filter' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/test-filter[/:test_filter_id]',
                    'defaults' => array(
                        'controller' => 'Identity\\V1\\Rest\\TestFilter\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'identity.rest.user',
            1 => 'identity.rest.begin-password-reset',
            2 => 'identity.rest.finish-password-reset',
            3 => 'identity.rest.test-filter',
        ),
    ),
    'zf-rest' => array(
        'Identity\\V1\\Rest\\User\\Controller' => array(
            'listener' => 'Identity\\V1\\Rest\\User\\UserResource',
            'route_name' => 'identity.rest.user',
            'route_identifier_name' => 'user_id',
            'collection_name' => 'user',
            'entity_http_methods' => array(
                0 => 'PATCH',
                1 => 'PUT',
                2 => 'GET',
            ),
            'collection_http_methods' => array(
                0 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'MyCompany\\Entity\\User',
            'collection_class' => 'Identity\\V1\\Rest\\User\\UserCollection',
            'service_name' => 'User',
        ),
        'Identity\\V1\\Rest\\BeginPasswordReset\\Controller' => array(
            'listener' => 'Identity\\V1\\Rest\\BeginPasswordReset\\BeginPasswordResetResource',
            'route_name' => 'identity.rest.begin-password-reset',
            'route_identifier_name' => 'begin_password_reset_id',
            'collection_name' => 'begin_password_reset',
            'entity_http_methods' => array(),
            'collection_http_methods' => array(
                0 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Identity\\V1\\Rest\\BeginPasswordReset\\BeginPasswordResetEntity',
            'collection_class' => 'Identity\\V1\\Rest\\BeginPasswordReset\\BeginPasswordResetCollection',
            'service_name' => 'BeginPasswordReset',
        ),
        'Identity\\V1\\Rest\\FinishPasswordReset\\Controller' => array(
            'listener' => 'Identity\\V1\\Rest\\FinishPasswordReset\\FinishPasswordResetResource',
            'route_name' => 'identity.rest.finish-password-reset',
            'route_identifier_name' => 'finish_password_reset_id',
            'collection_name' => 'finish_password_reset',
            'entity_http_methods' => array(),
            'collection_http_methods' => array(
                0 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Identity\\V1\\Rest\\FinishPasswordReset\\FinishPasswordResetEntity',
            'collection_class' => 'Identity\\V1\\Rest\\FinishPasswordReset\\FinishPasswordResetCollection',
            'service_name' => 'FinishPasswordReset',
        ),
        'Identity\\V1\\Rest\\TestFilter\\Controller' => array(
            'listener' => 'Identity\\V1\\Rest\\TestFilter\\TestFilterResource',
            'route_name' => 'identity.rest.test-filter',
            'route_identifier_name' => 'test_filter_id',
            'collection_name' => 'test_filter',
            'entity_http_methods' => array(),
            'collection_http_methods' => array(
                0 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Identity\\V1\\Rest\\TestFilter\\TestFilterEntity',
            'collection_class' => 'Identity\\V1\\Rest\\TestFilter\\TestFilterCollection',
            'service_name' => 'testFilter',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Identity\\V1\\Rest\\User\\Controller' => 'HalJson',
            'Identity\\V1\\Rest\\BeginPasswordReset\\Controller' => 'HalJson',
            'Identity\\V1\\Rest\\FinishPasswordReset\\Controller' => 'HalJson',
            'Identity\\V1\\Rest\\TestFilter\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Identity\\V1\\Rest\\User\\Controller' => array(
                0 => 'application/vnd.identity.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Identity\\V1\\Rest\\BeginPasswordReset\\Controller' => array(
                0 => 'application/vnd.identity.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Identity\\V1\\Rest\\FinishPasswordReset\\Controller' => array(
                0 => 'application/vnd.identity.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Identity\\V1\\Rest\\TestFilter\\Controller' => array(
                0 => 'application/vnd.identity.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Identity\\V1\\Rest\\User\\Controller' => array(
                0 => 'application/vnd.identity.v1+json',
                1 => 'application/json',
            ),
            'Identity\\V1\\Rest\\BeginPasswordReset\\Controller' => array(
                0 => 'application/vnd.identity.v1+json',
                1 => 'application/json',
            ),
            'Identity\\V1\\Rest\\FinishPasswordReset\\Controller' => array(
                0 => 'application/vnd.identity.v1+json',
                1 => 'application/json',
            ),
            'Identity\\V1\\Rest\\TestFilter\\Controller' => array(
                0 => 'application/vnd.identity.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Identity\\V1\\Rest\\User\\UserEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'identity.rest.user',
                'route_identifier_name' => 'user_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'Identity\\V1\\Rest\\User\\UserCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'identity.rest.user',
                'route_identifier_name' => 'user_id',
                'is_collection' => true,
            ),
            'MyCompany\\Entity\\User' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'identity.rest.user',
                'route_identifier_name' => 'user_id',
                'hydrator' => 'DoctrineModule\\Stdlib\\Hydrator\\DoctrineObject',
            ),
            'Identity\\V1\\Rest\\BeginPasswordReset\\BeginPasswordResetEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'identity.rest.begin-password-reset',
                'route_identifier_name' => 'begin_password_reset_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'Identity\\V1\\Rest\\BeginPasswordReset\\BeginPasswordResetCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'identity.rest.begin-password-reset',
                'route_identifier_name' => 'begin_password_reset_id',
                'is_collection' => true,
            ),
            'Identity\\V1\\Rest\\FinishPasswordReset\\FinishPasswordResetEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'identity.rest.finish-password-reset',
                'route_identifier_name' => 'finish_password_reset_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'Identity\\V1\\Rest\\FinishPasswordReset\\FinishPasswordResetCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'identity.rest.finish-password-reset',
                'route_identifier_name' => 'finish_password_reset_id',
                'is_collection' => true,
            ),
            'Identity\\V1\\Rest\\TestFilter\\TestFilterEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'identity.rest.test-filter',
                'route_identifier_name' => 'test_filter_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'Identity\\V1\\Rest\\TestFilter\\TestFilterCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'identity.rest.test-filter',
                'route_identifier_name' => 'test_filter_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-content-validation' => array(
        'Identity\\V1\\Rest\\User\\Controller' => array(
            'input_filter' => 'Identity\\V1\\Rest\\User\\Validator',
        ),
        'Identity\\V1\\Rest\\BeginPasswordReset\\Controller' => array(
            'input_filter' => 'Identity\\V1\\Rest\\BeginPasswordReset\\Validator',
        ),
        'Identity\\V1\\Rest\\FinishPasswordReset\\Controller' => array(
            'input_filter' => 'Identity\\V1\\Rest\\FinishPasswordReset\\Validator',
        ),
        'Identity\\V1\\Rest\\TestFilter\\Controller' => array(
            'input_filter' => 'Identity\\V1\\Rest\\TestFilter\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'Identity\\V1\\Rest\\User\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\EmailAddress',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'emailAddress',
                'description' => 'Email Address',
                'error_message' => 'Please enter a valid email address',
            ),
            1 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => '5',
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'password',
                'description' => 'A user password',
                'error_message' => 'a password must contain at least 5 characters',
            ),
        ),
        'Identity\\V1\\Rest\\BeginPasswordReset\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\EmailAddress',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'emailAddress',
                'description' => 'A valid email address',
                'error_message' => 'Please provide a valid email address',
            ),
        ),
        'Identity\\V1\\Rest\\Test\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\I18n\\Filter\\Alnum',
                        'options' => array(),
                    ),
                ),
                'name' => 'alnum',
            ),
        ),
        'Identity\\V1\\Rest\\FinishPasswordReset\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'token',
                'description' => 'a reset token provided by the beginPasswordReset process that would be delivered via an email',
                'error_message' => 'The provided token is not valid.',
            ),
            1 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => '5',
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'newPassword',
                'description' => 'The new password',
            ),
            2 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\EmailAddress',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'email',
                'description' => 'A valid email address',
                'error_message' => 'Please enter a valid email address',
            ),
        ),
        'Identity\\V1\\Rest\\TestFilter\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\I18n\\Filter\\Alnum',
                        'options' => array(
                            'allow_white_space' => '',
                        ),
                    ),
                ),
                'name' => 'basicString',
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'Identity\\V1\\Rest\\TestFilter\\Controller' => array(
                'collection' => array(
                    'GET' => false,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
            ),
            'Identity\\V1\\Rest\\User\\Controller' => array(
                'collection' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => false,
                ),
            ),
        ),
    ),
);
