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

[doc_readme]: ../../../../../README.md
