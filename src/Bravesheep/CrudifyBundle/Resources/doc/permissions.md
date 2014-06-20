# Permissions
The `CrudifyController`, the master controller that handles all requests and redirects them to the controller
that you specify in your mappings file checks whether or not you have access to run a certain permission. The
controller checks for the `indexAction` that the current [Token][symfony_security_token] has the `CRUDIFY_INDEX`
attribute. For the `newAction` and `createAction` the attribute `CRUDIFY_CREATE` is checked. For `editAction`
and `updateAction` the attribute `CRUDIFY_UPDATE` is checked. Finally, for the `deleteAction` the attribute
`CRUDIFY_DELETE` is checked. Note that in this context an attribute does not mean a property on the user or
token object, but instead for example a permission or role that is granted to a user. Note that because all these
checks are being done on the `CrudifyController` already, there is no need for you to check for these permissions
again in your custom controller. Your custom controller will simply not be called when the user has no permission
to access the current action.

The BravesheepCrudifyBundle registers a voter for checking access on definitions for the previously mentioned attributes.
In practice this means that you can call `$this->get('security.context')->isGranted('attr', $definition)` in your
controller for any of the previously mentioned attributes. In your Twig templates you have access to
`is_granted('attr', definition)`. Note that if you don't have access to the definition object you can use
`crudify_definition('definition_name')`, where `definition_name` is the name of the definition you want to check
access for.

The default voter returns for the `CRUDIFY_INDEX` attribute the access specified in the configuration key
`bs_crudify.default_access` (by default this is 'grant'). For the `CRUDIFY_CREATE`, `CRUDIFY_UPDATE` and
`CRUDIFY_DELETE` attributes, the voter will check whether or not the mapping has enabled creates, updates or
deletes respectively. If a mapping has enabled any of these actions, then the voter will return the value of
`bs_crudify.default_access`. If a mapping has disabled an action, then the voter will deny access.

If you define multiple access voters for a specific permission, you may want to change the behavior of the access
permission manager to only allow access when all voters agree on access, read more about this in the symfony
[documentation][symfony_security_strategy].

For reference purposes, here are the attributes again with when they are used by the BravesheepCrudifyBundle:

* `CRUDIFY_INDEX`: For viewing the listing and accessing the `indexAction` on your controller.
* `CRUDIFY_CREATE`: For creating new objects and accessing the `newAction` and `createAction` on your controller.
  Influenced by the `mapping.create` boolean in your mapping configuration.
* `CRUDIFY_UPDATE`: For updating existing objects and accessing the `editAction` and `updateAction` on your controller.
  Influenced by the `mapping.update` boolean in your mapping configuration.
* `CRUDIFY_DELETE`: For deleting objects and accessing the `deleteAction` on your controller. Influenced by the
  `mapping.delete` boolean in your mapping configuration.

## Preventing access by non-admin users
The voter mentioned in the previous section does not check user roles in any way. However you could implement
your own voter to do this instead. Another option is to use the ability of the symfony security component to
prevent access to certain urls in your application based on some properties of the current token.

Say that you for example registered the routes of the BravesheepCrudifyBundle under the prefix `/admin`. You could then
add to the `security.access_control` section of `app/config/security.yml` the following line to only allow those
users with the `ROLE_ADMIN` role to get access to the BravesheepCrudifyBundle CRUD you created:

```yaml
security:
    # ...
    access_control:
        # ...
        - { path: ^/admin, roles: ROLE_ADMIN }
```

You can read more about this in the [Symfony2 documentation on security][symfony_security_urls]

## Writing a custom voter
Most of the information on how to write a custom voter is available in the [Symfony2 documentation][symfony_voter].
In this section we will show a small example of how a custom voter for the BravesheepCrudifyBundle might look:

```php
use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class MyCustomVoter implements VoterInterface
{
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
        foreach ($attributes as $attribute) {
            if ($this->supportsAttribute($attribute) && $this->supportsClass($object)) {
                // TODO: do some access checking here
            }
        }
        return self::ACCESS_ABSTAIN;
    }
}
```

The voter above returns that it supports any attributes that start with `CRUDIFY_` and that the object provided
should implement the interface `DefinitionInterface`. For attribute/object combinations that confirm to these
requirements, you can implement your own logic on determining whether or not to give access to the user. Note that
you still need to register this voter in the service container, but this is explained in more detail in the
[respective documentation][symfony_voter].

[symfony_security_token]: http://symfony.com/doc/current/cookbook/security/custom_authentication_provider.html#the-token
[symfony_security_strategy]: http://symfony.com/doc/current/cookbook/security/voters.html#changing-the-access-decision-strategy
[symfony_security_urls]: http://symfony.com/doc/current/book/security.html#securing-specific-url-patterns
[symfony_voter]: http://symfony.com/doc/current/cookbook/security/voters.html
