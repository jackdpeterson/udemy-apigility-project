<?php
namespace MyCompany\RBAC;

use Zend\Permissions\Rbac\Rbac;

class ServiceRBAC
{

    const ROLE_USER = 'user';

    const ROLE_ADMIN = 'admin';

    protected $_rbac;

    public function __construct()
    {
        $rbac = new Rbac();
        $this->_rbac = $rbac;
        $this->addRoles();
    }

    public function addRoles()
    {
        
        /**
         * parents inherit ALL roles from CHILDREN.
         * E.g., becuase ADMIN is defined everywhere it will get the permissions rolled up
         * from every CHILD that defines its permissions
         */
        $this->_rbac->addRole(self::ROLE_ADMIN);
        
        $this->_rbac->addRole(self::ROLE_USER, array(
            self::ROLE_ADMIN
        ));
    }

    /**
     *
     * @return \Zend\Permissions\rbac\rbac
     */
    public function getRBAC()
    {
        return $this->_rbac;
    }
}