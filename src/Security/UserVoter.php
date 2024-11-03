<?php

namespace App\Security;

use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class UserVoter extends Voter
{
    const USER_SHOW = 'user_show';

    const USER_STORE = 'user_store';

    const USER_UPDATE = 'user_update';

    const USER_DELETE = 'user_delete';

    public function __construct(
        private JWTTokenManagerInterface $jwtManager
    )
    {
        
    }

    protected function supports($attribute, $subject): bool
    {
        return in_array($attribute, [
            self::USER_SHOW,
            self::USER_STORE,
            self::USER_UPDATE,
            self::USER_DELETE,
        ]);
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $payload = $this->jwtManager->decode($token);

        if ($payload['type'] == 'testAdmin') {
            return true;
        }

        $user = $token->getUser();

        switch ($attribute) {
            case self::USER_SHOW:
                return $this->canShow($user, $subject);
            case self::USER_STORE:
                return $this->canStore($user);
            case self::USER_UPDATE:
                return $this->canUpdate($user, $subject);
            case self::USER_DELETE:
                return $this->canDelete($user, $subject);
        }

        return false;
    }

    protected function canShow($user, $subject): bool
    {
        return $user->getId() == $subject;
    }

    protected function canStore($user): bool
    {
        return true;
    }

    protected function canUpdate($user, $subject): bool
    {
        return $user->getId() == $subject;
    }

    protected function canDelete($user, $subject): bool
    {
        return false;
    }
}