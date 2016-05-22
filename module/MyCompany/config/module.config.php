<?php
use MyCompany\Service\UserService;
use MyCompany\Factory\UserServiceFactory;
use MyCompany\Controller\UserResetPasswordController;
use MyCompany\Entity\User;
use MyCompany\Authentication\iAuthAwareInterface;
use ZF\MvcAuth\Identity\AuthenticatedIdentity;
use ZF\ApiProblem\ApiProblem;

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
            'iAuthAwareInterface' => function ($model, $serviceManager) {
                if ($model instanceof iAuthAwareInterface) {
                    try {
                        $authObj = $serviceManager->get('api-identity');
                        
                        if ($authObj instanceof AuthenticatedIdentity) {
                            /**
                             *
                             * @var $orm EntityManagerInterface
                             */
                            $orm = $serviceManager->get('doctrine.entitymanager.orm_default');
                            
                            $oauth_user_id = $serviceManager->get('api-identity')->getAuthenticationIdentity()['user_id'];
                            
                            $userObj = $orm->find(User::class, $oauth_user_id);
                            
                            $model->setAuthenticatedIdentity($userObj);
                        }
                    } catch (\exception $e) {
                        return new ApiProblem(500, $e->getMessage());
                    }
                }
            }
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