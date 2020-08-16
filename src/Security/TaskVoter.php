<?php

namespace App\Security;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class TaskVoter extends Voter
{
    // these strings are just invented: you can use anything
    const DELETE = 'delete';
    private $security;

    public function __construct(Security $security)
     {
         $this->security = $security;
     }

    protected function supports(string $attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::DELETE])) {
            return false;
        }

        // only vote on `Task` objects
        if (!$subject instanceof Task) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a Task object, thanks to `supports()`
        /** @var Task $task */
        $task = $subject;

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }
        else {
          switch ($attribute) {
              case self::DELETE:
                  return $this->canDelete($task, $user);
          }

          throw new \LogicException('This code should not be reached!');
        }
    }

    private function canDelete(Task $task, User $user)
    {
        // this assumes that the Task object has a `getOwner()` method
        return $user === $task->getCreatedBy();
    }
}
