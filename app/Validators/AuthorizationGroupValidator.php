<?php


namespace Crm\Validators;


use Crm\Entities\User;
use LucaDegasperi\OAuth2Server\Authorizer;

class AuthorizationGroupValidator
{

    /**
     * @var User
     */
    private $user;
    /**
     * @var Authorizer
     */
    private $authorizer;


    /**
     * @param User $user
     * @param Authorizer $authorizer
     */
    public function __construct( User $user, Authorizer $authorizer){
        $this->user = $user;
        $this->authorizer = $authorizer;
    }


    /**
     * Check if authenticated user belongs to Administrators Group
     *
     * @return bool
     */
    public function isAdmin()
    {

        $authUser = $this->user->find($this->authorizer->getResourceOwnerId());

        if ($authUser->group_id == 1) {
            return true;
        }

        return false;
    }

}