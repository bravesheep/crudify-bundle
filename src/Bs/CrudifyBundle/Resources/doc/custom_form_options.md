# Modify the options array for building the form
The form that is constructed for creating and updating entities always requires a few options. By default the
BsCrudifyBundle provides the `method` and `action` properties, which are required by forms to indicate by which
method they should be submitted back to the server and what url they should be submitted to. These properties are
determined by a `Bs\CrudifyBundle\Form\OptionsProvider\OptionsInterface` instance. Specifically the BsCrudifyBundle
uses `Bs\CrudifyBundle\Form\OptionsProvider\BasicOptions` if you have not specified another form options provider
yourself.

Note that all options providers should **always** return at least a `method` and `action` property. The best way to
do this is by extending the `BasicOptions` provider provided by the BsCrudifyBundle and calling the parent methods
on your own implementation.

Note that using options is **never** the correct way to provide Dependency Injection in your forms. If you need to
inject some service in your form, you should instead [make your form a service][symfony_forms_services] and inject
some service there instead. Typically you can say that if the options you are providing to your form are not some
sort of scalar value (i.e. integers, floats, booleans, strings) then it should not be provided as an option to
your form.

Also it is not appropriate to modify entities inside the FormType. Use a [object retriever][doc_object_retriever] to
load the correct entity directly. An exception might be made for creating a new instance of an object when none is
provided for the `newAction` and `createAction`. However then you may want to use the `empty_data` option that
[Symfony2 forms provide][symfony_forms_empty_data] by default. Used in combination with the `POST_SUBMIT` to update
inverse sides of non-owning-side entities, you should be able to fully get an updated object from the form component.

## Implementable methods
The Form Options provider has two methods available. One method, `OptionsInterface::getCreateOptions()`, is used for
retrieving the options for the create form. Note that this method only uses the controller and definition. The second
method is `OptionsInterface::getUpdateOptions()` also takes the controller and definition, but additionally gets
provided with the current object on which the form should be created. You can use this object to dynamically modify
the options to be provided to your update form based on the properties of the object.

[symfony_forms_services]: http://symfony.com/doc/current/book/forms.html#defining-your-forms-as-services
[doc_object_retriever]: custom_object_retriever.md
[symfony_forms_empty_data]: http://symfony.com/doc/current/cookbook/form/use_empty_data.html
