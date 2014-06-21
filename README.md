# BravesheepCrudifyBundle
The Bravesheep crudify bundle provides an easy way to quickly get a CRUD interface (Create-Read-Update-Delete) for
simple entities. The bundle has several extension points and options to customize behavior. Most
functionality can be customized quickly via the configuration. For a more generalized (be it more verbose)
approach you should take a look at the [SonataAdminBundle][sonata_admin_bundle]. Currently the BravesheepCrudifyBundle only
supports Doctrine ORM as a backend for retrieving data.

## Documentation
Read more about the bundle here:

* [Introduction][doc_introduction]
* [Permissions][doc_permissions]
* [Templates][doc_templates]
* [Modify the query used for index pages][doc_modify_index_query]
* [Modify the way objects are retrieved on edit and delete pages][doc_custom_object_retriever]
* [Modify the options array for building the form][doc_custom_form_options]
* [Use a custom controller][doc_custom_controller]
* [Default configuration][doc_config]

## Installation and configuration
Using [Composer][composer] add the bundle to your requirements:

```json
{
    "require": {
        "bravesheep/crudify-bundle": "dev-master"
    }
}
```

Then run `composer update bravesheep/crudify-bundle`

### Basic configuration
Define mappings in your configuration file `app/config/config.yml`:

```yaml
bravesheep_crudify:
    mappings: ~
```

A [full listing of the default config][doc_config] is available in the documentation.

### Add routes to your routing file
In `app/config/routing.yml`, add the routes for the crudify administrator interface:

```yaml
crudify_admin:
    prefix: /admin/
    type: crudify
    resource: .
```

### Add the bundle to your AppKernel
Finally add the bundle in `app/AppKernel.php`:

```php
public function registerBundles()
{
    return array(
        // ...
        new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
        new Bravesheep\CrudifyBundle\BravesheepCrudifyBundle(),
        // ...
    );
}
```

Don't forget to further configure the KnpPaginatorBundle, following [their guide][knp_menu_install]. If you are already
using the KnpPaginatorBundle in your AppKernel, then you don't need to add it again.

[doc_introduction]: src/Bravesheep/CrudifyBundle/Resources/doc/introduction.md
[doc_permissions]: src/Bravesheep/CrudifyBundle/Resources/doc/permissions.md
[doc_templates]: src/Bravesheep/CrudifyBundle/Resources/doc/templates.md
[doc_modify_index_query]: src/Bravesheep/CrudifyBundle/Resources/doc/modify_index_query.md
[doc_custom_object_retriever]: src/Bravesheep/CrudifyBundle/Resources/doc/custom_object_retriever.md
[doc_custom_form_options]: src/Bravesheep/CrudifyBundle/Resources/doc/custom_form_options.md
[doc_custom_controller]: src/Bravesheep/CrudifyBundle/Resources/doc/custom_controller.md
[doc_config]: src/Bravesheep/CrudifyBundle/Resources/doc/config.md
[composer]: https://getcomposer.org/
[sonata_admin_bundle]: https://github.com/sonata-project/SonataAdminBundle
[knp_menu_install]: https://github.com/KnpLabs/KnpPaginatorBundle/blob/master/README.md#installation-and-configuration
