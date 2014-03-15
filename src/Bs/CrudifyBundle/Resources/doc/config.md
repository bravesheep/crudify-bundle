# Crudify configuration
An example configuration with the defaults:

```yaml
bs_crudify:
    default: ~ # the mapping to which the administrator should redirect by default
    controller: bs_crudify.controller.base # The default controller that shows and edits mappings
    default_access: grant # Allowed: grant, abstain, deny; default result whenever access is checked in crudify
    templates: # Provide the templates used for showing
        layout: BsCrudifyBundle:Admin:_layout.html.twig # Layout file
        form_theme: ~ # Form theme
        pagination: KnpPaginatorBundle:Pagination:twitter_bootstrap_v3_pagination.html.twig
        sortable: BsCrudifyBundle:Pagination:sortable_link.html.twig # Sorting column header
        index: BsCrudifyBundle:Admin:index.html.twig # Template for the index
        new: BsCrudifyBundle:Admin:new.html.twig # Template for the new page
        edit: BsCrudifyBundle:Admin:edit.html.twig # Template for the edit page
    # Mappings may be any number of individual mappings, the keys will be the names of the mappings
    mappings:
        mapping:
            entity: ~ # The name of the entity to be used, either a Bundle:Shortcut or NameSpaced\Entity\Name
            title: ~ # Title to be used, of not provided will be determined from the name of the mapping
            # If 'index: ~' is provided, a dynamic index with these defaults will be created instead
            index:
                type: static # If set to dynamic, crudify will try to determine the columns automatically
                page_limit: 20 # Number of items per page on the index
                query_modifier: ~ # A class name or service name for a modifier that can adjust the index query
                sort:
                    column: ~
                    direction: asc # Either asc for ascending order, or desc for descending order
                # May contain any number of columns
                columns:
                    column: type # Shorthand notation
                    other_column:
                        title: ~ # Will be determined using the column name by default
                        type: ~
                        path: ~ # Determined using the column name by default, false to ignore the column in the query
                    column.from.other.table: type # You may use columns from joinable entities
            # If create and update use the same form, you may optionally use form: 'form_type' instead
            form:
                create: ~ # Form type for create, either class or service name
                update: ~ # Form type for update, either class or service name
            # Provider that generates the options available to the form
            form_options_provider: bs_crudify.form.options.provider.basic
            # Service/class name which provides the loading of a single object for a definition
            object_retriever: bs_crudify.query.retriever.repository
            create: true # Whether or not to enable create functionality for the mapping
            update: true # Whether or not to enable update functionality for the mapping
            delete: true # Whether or not to enable delete functionality for the mapping
            controller: ~ # The controller to be used for this mapping, either class name or service name
            templates:
                layout: ~ # Layout template for this mapping
                form_theme: ~ # Form theme template for this mapping
                pagination: ~ # Pagination template for this mapping
                sortable: ~ # Sortable template for this mapping
                index: ~ # Index template for this mapping
                new: ~ # New/create template for this mapping
                edit: ~ # Edit/update template for this mapping
```
