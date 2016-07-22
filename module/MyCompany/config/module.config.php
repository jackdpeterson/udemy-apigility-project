<?php
use MyCompany\Service\UserService;
use MyCompany\Factory\UserServiceFactory;
use MyCompany\Controller\UserResetPasswordController;
use MyCompany\Entity\User;
use MyCompany\Authentication\iAuthAwareInterface;

return array(
    'controllers' => array(
        'invokables' => array(
            UserResetPasswordController::class => UserResetPasswordController::class
        )
    ),
    'router' => array(
        'routes' => array(
            'account.reset.password.middle' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/user-reset-password/[:email]/[:token]',
                    'defaults' => array(
                        'controller' => UserResetPasswordController::class,
                        'action' => 'index'
                    )
                )
            )
        )
    ),
    'service_manager' => array(
        'factories' => array(
            UserService::class => UserServiceFactory::class
        ),
        'initializers' => array(
            'iAuthAwareInterface' => 'MyCompany\\Initializer\iAuthAwareInitializer'
        )
    ),
    'view_manager' => array(
        'template_map' => array(
            'MyCompany/mail/user/signup' => __DIR__ . '/../view/my-company/mail/user/signup.phtml',
            'MyCompany/mail/user/forgot-password' => __DIR__ . '/../view/my-company/mail/user/forgot-password.phtml',
            'my-company/user-reset-password/index' => __DIR__ . '/../view/my-company/user-reset-password/index.phtml'
        )
    )
);