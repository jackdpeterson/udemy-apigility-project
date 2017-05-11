<?php

namespace MyCompanyTest\Service;

use Doctrine\ORM\EntityManager;
use MyCompany\Service\UserService;
use MyCompany\Entity\User;
use MyCompany\RBAC\ServiceRBAC;
use MyCompanyTest\Factory\UserServiceFactory;
use PHPUnit\Framework\TestCase;


/**
 * UserService test case.
 */
class UserServiceTest extends TestCase
{

    /**
     *
     * @var UserService
     */
    private $userService;

    protected function getORM()
    {
        $sm = \TestBootstrap::getServiceManager();
        $orm = $sm->get(EntityManager::class);

        return $orm;
    }

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {

        // TODO Auto-generated UserServiceTest::setUp()

        $factory = new UserServiceFactory();
        $this->userService = $factory->createService(\TestBootstrap::getServiceManager());
        $this->assertInstanceOf(UserService::class, $this->userService);

        $orm = $this->getORM();
        $qb = $orm->createQueryBuilder()->select('u');
        $qb->from(User::class, 'u')->andWhere($qb->expr()
            ->like('u.email', ':email'));
        $qb->setParameter('email', '%unit_test%');
        $iterableResults = $qb->getQuery()->iterate();
        foreach ($iterableResults as $uAsArr) {
            $orm->remove($uAsArr[0]);
        }
        $orm->flush();
        $orm->clear();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated UserServiceTest::tearDown()
        $this->userService = null;
    }


    /**
     * Tests UserService->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated UserServiceTest->test__construct()
        $this->assertInstanceOf(UserService::class, $this->userService);
    }

    /**
     * Tests UserService->registerUser()
     */
    public function testRegisterUser()
    {
        // TODO Auto-generated UserServiceTest->testRegisterUser()
        $emailAddress = "you_unit_test@example.com";
        $password = "abc123";

        $userObj = $this->userService->registerUser($emailAddress, $password);

        $this->assertInstanceOf(User::class, $userObj);
    }

    public function testRegisterUserEmailAreadyExistsException()
    {
        // TODO Auto-generated UserServiceTest->testRegisterUser()
        $emailAddress = "you_unit_test@example.com";
        $password = "abc123";

        $userObj = $this->userService->registerUser($emailAddress, $password);

        $this->assertInstanceOf(User::class, $userObj);

        $this->expectException(\RuntimeException::class, UserService::USER_ALREADY_REGISTERED_MESSAGE,
            UserService::USER_ALREADY_REGISTERED_CODE);
        $userObj = $this->userService->registerUser($emailAddress, $password);
    }

    /**
     * Tests UserService->forgotPassword()
     */
    public function testForgotPassword()
    {
        $emailAddress = "you_unit_test@example.com";
        $password = "abc123";

        $userObj = $this->userService->registerUser($emailAddress, $password);

        $this->assertInstanceOf(User::class, $userObj);

        $response = $this->userService->forgotPassword($emailAddress);

        $this->assertInternalType('array', $response);

        $this->assertArrayHasKey('isMailSent', $response);

        $this->assertTrue($response['isMailSent']);
    }

    /**
     * Tests UserService->resetPassword()
     */
    public function testResetPassword()
    {

        // TODO Auto-generated UserServiceTest->testRegisterUser()
        $emailAddress = "you_unit_test@example.com";
        $password = "abc123";

        $userObj = $this->userService->registerUser($emailAddress, $password);

        $this->assertInstanceOf(User::class, $userObj);

        $emailAddress = "you_unit_test@example.com";
        $newPassword = 'def456';
        $resetToken = hash('sha256',
            $userObj->getId() . $userObj->getEmail() . $userObj->getPassword() . $userObj->getCreatedAt()->getTimestamp());

        $userResetObj = $this->userService->resetPassword($emailAddress, $resetToken, $newPassword);

        $this->assertInstanceOf(User::class, $userResetObj);
    }

    /**
     * Tests UserService->fetchUser()
     */
    public function testFetchUser()
    {
        $emailAddress = "you_unit_test@example.com";
        $password = "abc123";

        $userObj = $this->userService->registerUser($emailAddress, $password);

        $this->assertInstanceOf(User::class, $userObj);

        $expectedOutput = $this->userService->fetchUser($emailAddress);
        $this->assertInstanceOf(User::class, $expectedOutput);
    }

    public function testIsMethodAllowed()
    {
        $this->assertFalse($this->userService->isMethodAllowed(UserService::class . "::changeEmailAddress"));

        $userObj = new User();
        $userObj->setRoles([]);

        $this->userService->setAuthenticatedIdentity($userObj);

        $this->assertFalse($this->userService->isMethodAllowed(UserService::class . "::changeEmailAddress"));

        $userObj = new User();
        $userObj->setRoles([
            ServiceRBAC::ROLE_USER
        ]);

        $this->userService->setAuthenticatedIdentity($userObj);

        $this->assertTrue($this->userService->isMethodAllowed(UserService::class . "::changeEmailAddress"));
    }

    public function testChangeEmailAddress()
    {
        // TODO Auto-generated UserServiceTest->testRegisterUser()
        $emailAddress = "you_unit_test@example.com";
        $password = "abc123";

        $userObj = $this->userService->registerUser($emailAddress, $password);

        $this->assertInstanceOf(User::class, $userObj);

        $newEmailAddress = "jack.peterson+newEmailunit_test@gmail.com";

        $this->userService->setAuthenticatedIdentity($userObj);

        $response = $this->userService->changeEmailAddress($userObj->getEmail(), $newEmailAddress);

        $this->assertInstanceOf(User::class, $response);

        $this->assertEquals($newEmailAddress, $response->getEmail());
    }

    public function testChangeEmailAddressByAnotherRegularUser()
    {
        // TODO Auto-generated UserServiceTest->testRegisterUser()
        $emailAddress = "you_unit_test@example.com";
        $password = "abc123";

        $userObj = $this->userService->registerUser($emailAddress, $password);

        $this->assertInstanceOf(User::class, $userObj);

        $newEmailAddress = "jack.peterson+newEmailunit_test@gmail.com";

        $this->userService->setAuthenticatedIdentity($userObj);

        $emailAddress2 = "jack.peterson2+unit_test@gmail.com";
        $userObj2 = $this->userService->registerUser($emailAddress2, $password);
        $this->assertInstanceOf(User::class, $userObj2);

        $this->expectException(\RuntimeException::class, UserService::PERMISSION_DENIED_MESSAGE,
            UserService::PERMISSION_DENIED_CODE);

        $this->userService->changeEmailAddress($userObj2->getEmail(), $newEmailAddress);
    }
}
