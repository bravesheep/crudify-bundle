<?php

namespace Bs\CrudifyBundle\Security\Authorization\Voter;

use Bs\CrudifyBundle\Definition\DefinitionInterface;
use Bs\CrudifyBundle\Exception\CrudifyException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class CrudifyAccessVoter implements VoterInterface
{
    /**
     * @var int
     */
    private $defaultAccess;

    public function __construct($defaultAccess = 'grant')
    {
        $this->defaultAccess = $this->constantForAccessName($defaultAccess);
    }

    private function constantForAccessName($name)
    {
        if (is_int($name)) {
            return $name;
        }

        switch ($name) {
            case 'grant': return VoterInterface::ACCESS_GRANTED; break;
            case 'deny': return VoterInterface::ACCESS_DENIED; break;
            case 'abstain': return VoterInterface::ACCESS_ABSTAIN; break;
            default:
                throw new CrudifyException("The name {$name} is not a valid voter default.");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return strpos($attribute, 'CRUDIFY_') === 0;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class instanceof DefinitionInterface;
    }

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        foreach ($attributes as $attr) {
            if ($this->supportsAttribute($attr) && $this->supportsClass($object)) {
                return $this->voteAccess($object, $attr);
            }
        }
        return VoterInterface::ACCESS_ABSTAIN;
    }

    private function voteAccess(DefinitionInterface $definition, $attribute)
    {
        if ($attribute === 'CRUDIFY_CREATE') {
            if ($definition->withCreate()) {
                return $this->defaultAccess;
            } else {
                return VoterInterface::ACCESS_DENIED;
            }
        }

        if ($attribute === 'CRUDIFY_UPDATE') {
            if ($definition->withUpdate()) {
                return $this->defaultAccess;
            } else {
                return VoterInterface::ACCESS_DENIED;
            }
        }

        if ($attribute === 'CRUDIFY_DELETE') {
            if ($definition->withDelete()) {
                return $this->defaultAccess;
            } else {
                return VoterInterface::ACCESS_DENIED;
            }
        }
        return $this->defaultAccess;
    }
}
