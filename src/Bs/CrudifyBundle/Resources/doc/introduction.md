# CrudifyBundle introduction

## Installation
To install the CrudifyBundle, follow the instructions as [layed out in][doc_readme] the `README.md`.

## Creating mappings
Inside the `bs_crudify.mappings` key of your configuration you can specify any number of mappings. These mappings
each have their own unique name, which is then used in the routes to allow the CrudifyBundle to recognize what you
are editing. Every mapping is bound to one and only one entity. However you may have multiple mappings for the
same entity.

For the listing of the objects of a certain entity type the BsCrudifyBundle also need you to provide a list of
columns to be shown. Also required if creating or updating is enabled: a `FormTypeInterface` for the create and
update forms. Let's take a look at a very simple mapping for a list of posts in a blog:

```yaml
bs_crudify:
    # ...
    mappings:
        # ...
        posts:
            entity: SiteBundle:Post
            index:
                columns: { title: text, slug: text }
            form: Acme\SiteBundle\Form\PostType
        # ...
```

The mapping defines a mapping on the entity `SiteBundle:Post`. It has a listview with a title and a slug column, both
of them are of the type `text`. For both the create and the update form, this mapping uses the
`Acme\SiteBundle\Form\PostType` FormType. You may be asking yourself: which column types are available. By default the
bundle provides blocks for displaying `bool`, `url`, `date`, `datetime` and `email`. However any type for which no block
could be found will be rendered as if it were a string. This means that you can specify any type you want. If you want to
create your own block, you can read more about that in the template documentation below.

If you've set the bundle up correctly, you should be able to visit `/{prefix}/posts` (where `{prefix}` is the url prefix
you used in your routing configuration) and you should get a listing of the available Posts, including the ability to
create, update and delete the objects available for the Post entity.

## Global options
Some options in the CrudifyBundle are shared between all mappings. By configuring `bs_crudify.default` you can specify a
default mapping. Using this option enables a route for `/{prefix}` (with `{prefix}` being the url prefix you used in your
routing configuration) which automatically redirects you to the index page for the configured mapping.

The `bs_crudify.controller` setting allows you to provide a default service/class name to be used for all mappings, you can
override this default controller using the `controller` setting in each individual mapping. This allows you to use a specific
controller for a limited selection of your mappings.

Finally, the `bs_crudify.templates` setting allows you to define the templates that should be used for the views of
parts of the page. Each of these templates can also be overridden per mapping if required. Templates you can specify are:

* `layout`: The layout surrounding all views of the CRUD.
* `form_theme`: An additional theme to be used for your forms, besides those already available in the application.
* `pagination`: The [KnpPaginatorBundle][knp_paginatior_bundle] pagination theme.
* `sortable`: The [KnpPaginatorBundle][knp_paginatior_bundle] sortable column header theme.
* `index`: The template to be used for the index (the list of objects) view.
* `new`: The template to be used for the new/create view.
* `edit`: The template to be used for the edit/update view.

To get a list of all the options available, take a look at the [example/default configuration][doc_config].

## Templates
The layout template you specify should contain the block `bs_crudify_content` which is where BsCrudifyBundle will place
the content of its views. The BsCrudifyBundle also registers a few Twig functions for you to use in your templates:

* `crudify_action(action, definition[, object])`: Retrieve a path to the specified action (`index`, `new`, `create`,
  `edit`, `update`, `delete`) for the definition with the optional object for those routes that require an identifier.
  The object may also be an identifier and the definition may also be the name of a definition.
* `crudify_defined()`: Retrieve a list of defined definitions.
* `crudify_delete_form(definition, object)`: Retrieve the delete form for an object given the definition.
* `crudify_value(column, object)`: Display the value of `column` for `object` inside the index view.
* `crudify_definition(mapping)`: Retrieve the definition for a specific mapping.

The values inside the columns of the listview are generated using blocks. You have to include these blocks yourself.
The BsCrudifyBundle uses the Twig statement `{% use "BsCrudifyBundle:Admin:_blocks.html.twig" %}` to load the blocks
used for the default types. Blocks must have a name `crudify_field_{type}` where `{type}` is the type of the column
that should be rendered. Note that if no block could be found, the crudify bundle will try to display the field
directly. More about templates can be found in [its own documentation][doc_templates].

## Access permissions
You can use the attributes `CRUDIFY_INDEX`, `CRUDIFY_CREATE` and `CRUDIFY_UPDATE` for checking permissions of
the index, new/create actions and edit/update actions respectively. All these attributes work on `DefinitionInterface`
objects. In twig templates you might for example use `is_granted('CRUDIFY_INDEX', definition)` to determine whether or
not to show a user the link to the list view of some mapping. Read more about permissions in the
[documentation about permissions][doc_permissions].

## Customizing behavior
Some parts of the crudify bundle can be customized so that you can implement your own behavior, read about them here:

* [Modify the query used for index pages][doc_modify_index_query]
* [Modify the way objects are retrieved on edit and delete pages][doc_custom_object_retriever]
* [Modify the options array for building the form][doc_custom_form_options]
* [Use a custom controller][doc_custom_controller]

[doc_readme]: ../../../../../README.md
[doc_permissions]: permissions.md
[doc_templates]: templates.md
[doc_modify_index_query]: modify_index_query.md
[doc_custom_object_retriever]: custom_object_retriever.md
[doc_custom_form_options]: custom_form_options.md
[doc_custom_controller]: custom_controller.md
[doc_config]: config.md
[knp_paginatior_bundle]: https://github.com/KnpLabs/KnpPaginatorBundle
