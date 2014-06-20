# Using a custom controller
If you found all other methods of customization inadequate for your needs, you may find you need to override the
controller. Note that in many cases instead of overriding the controller, you may need to leave the BravesheepCrudifyBundle,
and instead create custom application logic. However for those cases where you think you can still fit it inside
the structure provided by the BravesheepCrudifyBundle, you can create your own controller.

This controller will need to implement the `Bravesheep\CrudifyBundle\Controller\CrudControllerInterface`. Alternatively you
can extend from the `Bravesheep\CrudifyBundle\Controller\AbstractCrudController` abstract class, which already implements
some methods. Even easier is extending the `Bravesheep\CrudifyBundle\Controller\BaseController`. This allows you to only
override those methods for which you really need some custom logic, and rely on the default implementations for the
rest.

If you choose to implement your own custom controller, please keep yourself to the variables and methods provided
by the Definition passed to you. For example, you should never need to implement a custom controller only to set
a static template for a certain action. Instead just override the parameter in your mappings instead but keep to the
variables provided by the definition in your controller.

Also note that the `CrudControllerInterface` **does not provide you with the ability to implement custom actions**. If
you are in need of another action besides those provided by the `CrudControllerInterface`, then you should no longer
use the BravesheepCrudifyBundle, but switch to a custom implementation for your mapping instead, entirely separate from the
BravesheepCrudifyBundle.

## Registering your controller with mappings
You can create a service for your controller (note that if you do this you need to call the `setContainer` method in
the definition of your service). Alternatively you can provide the name of a class. This class is then automatically
constructed as long as it has no required arguments for the constructor. The `setContainer` method is also called
automatically for controllers constructed this way.

You can override the controller for all mappings you provide by changing the setting in the `bs_crudify.controller`
key. Or you can override the controller for a specific mapping by setting the `mapping.controller` key for your
specific mapping (either with the service or the class mentioned previously). Also take a look at the
[default configuration][doc_config].

[doc_config]: config.md
