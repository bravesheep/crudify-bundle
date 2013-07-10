# Bravesheep Crudify bundle

Example configuration:

```yml
bs_crudify:
    default: post
    layout: AcmeBundle::layout.html.twig
    entities:
        post:
            ns: AcmeBundle\Entity\Post
            index: ['author.name', 'title', 'created']
            form: AcmeBundle\Form\PostType
        author:
            ns: AcmeBundle\Entity\Author
            index: ['name', 'email']
            form: ['name', 'email']
```

Routes can also be customized:

```yml
admin_index:
    path:      /beheer/
    defaults:  { _controller: BsCrudifyBundle:Admin:index }
admin_list:
    path:      /beheer/overzicht/{entity}
    defaults:  { _controller: BsCrudifyBundle:Admin:list }
admin_add:
    path:      /beheer/toevoegen/{entity}
    defaults:  { _controller: BsCrudifyBundle:Admin:add }
admin_edit:
    path:      /beheer/bewerk/{entity}/{id}
    defaults:  { _controller: BsCrudifyBundle:Admin:edit }
admin_delete:
    path:      /beheer/verwijderen/{entity}/{id}
    defaults:  { _controller: BsCrudifyBundle:Admin:delete }
```
