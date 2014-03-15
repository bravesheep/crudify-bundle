# Modify the query used for index pages
The BsCrudifyBundle automatically builds a query based on the columns you specify for the index view. However you may
want to apply some filtering, add multiple default-sort-columns, add a query hint to the query or replace it with an
entirely different query. You can do this by implementing a class that implements the interface
`Bs\CrudifyBundle\Query\ModifierInterface`.

## Modify the query builder
A query modifier can modify the query for the index page at two points. The first option is to modify the query at the
point where a `Doctrine\ORM\QueryBuilder` object is fully constructed. This allows you to add additional field to the
query or add additional joins for improved efficiency (if the default is not efficient). Modifying the `QueryBuilder`
can be done in the `ModifierInterface::modifyBuilder(QueryBuilder $builder)` method. You may also choose to return
an entirely new QueryBuilder. However there are some constraints:

* Name the base entity selected `entity`.
* Make sure that entities are selected, scalar values are not allowed.

## Modify the query
The section option for changing the query is after the `QueryBuilder` object is transformed to a `Doctrine\ORM\Query`
object. This section point at which you can modify the query allows you to add Query hints or set additional
parameters. This modification can be applied in the `ModifierInterface::modifyQuery(Query $query)` method. Here, again,
you may choose to return an entirely new Query, however the same constraints as with the builder apply.

## AbstractModifier
The BsCrudifyBundle provides a `Bs\CrudifyBundle\Query\AbstractModifier` abstract class that already implements both
modifier methods with empty implementations. This allows you to only implement one of the two modifier methods without
having to touch the other.

## Updating mappings
In order to let your QueryModifier be applied, you need to update your mapping: The `mapping.index.query_modifier` key
of a mapping allows you to specify either a service, so you can use Dependency Injection on your query modifier, or use
it directly by providing the class name directly. In the latter case the BsCrudifyBundle will construct the query
modifier for you as long as it is constructable without requiring any arguments. Also take a look at the
[default config][doc_config].

## Modify the query for the edit, update and delete pages
The query modifier only modifies the query for the `indexAction`, not for the actions where a single object is
selected. For these actions you should instead implement a `ObjectRetrieverInterface` and set that in your mapping.
For more information on the `ObjectRetrieverInterface`, take a look at the documentation about
[modifying the way objects are retrieved on edit and delete pages][doc_custom_object_retriever]

[doc_custom_object_retriever]: custom_object_retriever.md
[doc_config]: config.md
