# Create a custom object retriever
On the edit and delete page, the BsCrudifyBundle needs to retrieve the object that we want to access. To do this the
BsCrudifyBundle specifies the `id` property in the url. This property is then passed to a class tasked with loading
an entity from the database.

The default loader, used if no custom loader is specified, is the `Bs\CrudifyBundle\Query\RepositoryObjectRetriever`.
If you take a look at the implementation of this class you can see that is simply retrieves the repository for the
entity and calls the `find()` method with the provided id.

However in some cases this may not be what you are looking for. In those cases you will want to create a custom
object retriever. You can do this by creating a class implementing `Bs\CrudifyBundle\Query\ObjectRetrieverInterface`.
This interface has one method, `retrieve(DefinitionInterface $definition, $id)`. Say for example that you are
using the `Gedmo\Translatable` behavior on your entity and you want to load the entity in a specific language. The
Translatable does this by letting you set the `locale` property of your entity and then calling refresh on the
entity manager. Alternatively you can even create a custom query that directly loads the entity as required.

## Changing the retrieval of objects on the index action
Changing the retrieval of objects on the `indexAction` of the `CrudifyController` can be done by creating a
[query modifier][doc_query_modifier].

[doc_query_modifier]: modify_index_query.md
