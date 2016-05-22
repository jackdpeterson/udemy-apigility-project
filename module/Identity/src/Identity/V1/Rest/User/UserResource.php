<?php
namespace Identity\V1\Rest\User;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use MyCompany\Service\UserService;

class UserResource extends AbstractResourceListener
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Create a resource
     *
     * @param mixed $data            
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        try {
            $response = $this->userService->registerUser($data->emailAddress, $data->password);
            
            return $response;
        } catch (\RuntimeException $e) {
            if ($e->getCode() == UserService::USER_ALREADY_REGISTERED_CODE) {
                return new ApiProblem(422, 'A user has already been registered with that email address');
            }
            
            return new ApiProblem(500, $e->getMessage());
        }
    }

    /**
     * Delete a resource
     *
     * @param mixed $id            
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param mixed $data            
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param mixed $id            
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return $this->userService->fetchUserById($id);
        
        return new ApiProblem(405, 'The GET method has not been defined for individual resources');
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param array $params            
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        return new ApiProblem(405, 'The GET method has not been defined for collections');
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param mixed $id            
     * @param mixed $data            
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        if (isset($data->emailAddress)) {
            
            $userObj = $this->userService->fetchUserById($this->getIdentity()
                ->getAuthenticationIdentity()['user_id']);
            return $this->userService->changeEmailAddress($userObj->getEmail(), $this->getInputFilter()
                ->getValue('emailAddress'));
        }
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param mixed $data            
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param mixed $id            
     * @param mixed $data            
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return ($data);
        if (isset($data->emailAddress)) {
            
            $userObj = $this->userService->fetchUserById($this->getIdentity()
                ->getAuthenticationIdentity()['user_id']);
            return $this->userService->changeEmailAddress($userObj->getEmail(), $this->getInputFilter()
                ->getValue('emailAddress'));
        }
        return array();
    }
}
