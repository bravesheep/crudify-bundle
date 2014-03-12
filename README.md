# Bravesheep Crudify bundle

## Documentation
Read more about the bundle here:

* [Default configuration][config_default]

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
bs_crudify:
    mappings: ~
```

A [full listing of the default config][config_default] is available in the documentation.

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
        new Bs\CrudifyBundle\BsCrudifyBundle(),
        // ...
    );
}
```

[config_default]: src/Bs/CrudifyBundle/Resources/doc/config.md
[composer]: https://getcomposer.org/
