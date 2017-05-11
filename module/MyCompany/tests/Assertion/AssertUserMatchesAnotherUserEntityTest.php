<?php

namespace MyCompanyTest\Assertion;

use Doctrine\ORM\EntityManager;
use MyCompany\Assertion\AssertUserMatchesAnotherUserEntity;
use MyCompany\Entity\User;
use Zend\Permissions\Rbac\Rbac;
use PHPUnit\Framework\TestCase;

/**
 * AssertUserMatchesAnotherUserEntity test case.
 */
class AssertUserMatchesAnotherUserEntityTest extends TestCase
{

    /**
     *
     * @var AssertUserMatchesAnotherUserEntity
     */
    private $assertUserMatchesAnotherUserEntity;

    private $originalUser;

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


        $userObj = new User();
        $userObj->setEmail('assert_user_matches_another_user_assertion_unit_test@mycompany.com');
        $userObj->setRoles([]);
        $userObj->setCreatedAt(new \DateTime());
        $userObj->setIsActivated(true);
        $userObj->setIsEmailConfirmed(true);
        $userObj->setPassword('abc123');

        $orm->persist($userObj);
        $orm->flush();

        $this->originalUser = $userObj;

        $assertion = new AssertUserMatchesAnotherUserEntity($userObj);

        $this->assertUserMatchesAnotherUserEntity = $assertion;
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated AssertUserMatchesAnotherUserEntityTest::tearDown()
        $this->assertUserMatchesAnotherUserEntity = null;

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

        parent::tearDown();
    }

    /**
     * Tests AssertUserMatchesAnotherUserEntity->__construct()
     */
    public function test__construct()
    {
        $userObj = new User();

        $assertion = new AssertUserMatchesAnotherUserEntity($userObj);

        $this->assertInstanceOf(AssertUserMatchesAnotherUserEntity::class, $assertion);
    }

    /**
     * Tests AssertUserMatchesAnotherUserEntity->setResourceInQuestion()
     */
    public function testSetResourceInQuestion()
    {
        $userObj = new User();
        $userObj->setEmail('assert_user_matches_another_user_assertion_setResource_unit_test@mycompany.com');
        $userObj->setRoles([]);
        $userObj->setCreatedAt(new \DateTime());
        $userObj->setIsActivated(true);
        $userObj->setIsEmailConfirmed(true);
        $userObj->setPassword('abc123');

        $this->assertNull($this->assertUserMatchesAnotherUserEntity->setResourceInQuestion($userObj));


    }

    /**
     * Tests AssertUserMatchesAnotherUserEntity->assert()
     */
    public function testAssert()
    {
        $userObj = new User();
        $userObj->setEmail('assert_user_matches_another_user_assertion_setResource_unit_test@mycompany.com');
        $userObj->setRoles([]);
        $userObj->setCreatedAt(new \DateTime());
        $userObj->setIsActivated(true);
        $userObj->setIsEmailConfirmed(true);
        $userObj->setPassword('abc123');

        $this->assertFalse($this->assertUserMatchesAnotherUserEntity->assert(new Rbac()));

        $this->assertUserMatchesAnotherUserEntity->setResourceInQuestion($userObj);

        $this->assertFalse($this->assertUserMatchesAnotherUserEntity->assert(new Rbac()));

        $this->assertUserMatchesAnotherUserEntity->setResourceInQuestion($this->originalUser);

        $this->assertTrue($this->assertUserMatchesAnotherUserEntity->assert(new Rbac()));
    }
}
