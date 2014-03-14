# Templates
In the BsCrudifyBundle you can override the following templates:

* `layout`: The layout surrounding all views of the CRUD.
* `form_theme`: An additional theme to be used for your forms, besides those already available in the application.
* `pagination`: The [KnpPaginatorBundle][knp_paginatior_bundle] pagination theme.
* `sortable`: The [KnpPaginatorBundle][knp_paginatior_bundle] sortable column header theme.
* `index`: The template to be used for the index (the list of objects) view.
* `new`: The template to be used for the new/create view.
* `edit`: The template to be used for the edit/update view.

All of these templates can be overridden globally by changing their respective configuration key in the `bs_crudify.templates`
array of your configuration. Alternatively you can override a template for a specific mapping only by changing the
respective configuration key in the `bs_crudify.mappings.{mapping}.templates` array, where `{mapping}` is the mapping for which
you want to override a default template.

## Twig functions
The BsCrudifyBundle creates a few functions that you can call in your templates:

* `crudify_action(action, definition[, object])`: Retrieve a path to the specified action (`index`, `new`, `create`,
  `edit`, `update`, `delete`) for the definition with the optional object for those routes that require an identifier.
  The object may also be an identifier and the definition may also be the name of a definition. Using this function
  ensures that all parameters are successfully passed to that action.
* `crudify_defined()`: Retrieve a list of defined definitions. This is useful for creating a menu somewhere in your
  layout. Especially if used in combination with the permission system, you can ensure that only those mappings to
  which the user has access are shown.
* `crudify_delete_form(definition, object)`: Retrieve the delete form for an object given the definition. This calls the
  `CrudControllerInterface::createDeleteForm()` function in your controller, so make sure that function is correctly
  implemented if you have used a custom controller.
* `crudify_value(column, object)`: Display the value of `column` for `object` inside the index view. This function calls
  the correct block for the column or shows the value as a string if no block could be found. Read more about these blocks
  below.
* `crudify_definition(mapping)`: Retrieve the definition for a specific mapping. This may be useful to check for access
  permissions on the admin when called in combination with `is_granted()`.

## Value blocks
When rendering the grid inside the index view, as long as the `crudify_value()` function is used to display the field values,
some blocks will be called inside your view.




[knp_paginatior_bundle]: https://github.com/KnpLabs/KnpPaginatorBundle
