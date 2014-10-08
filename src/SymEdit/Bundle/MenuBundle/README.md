SymEdit Menu Bundle
===================

The main point of this bundle is to allow multiple other bundles to construct
a single menu. The way this is done is by adding tags to the DI container and
then running the root node of the menu through each of the builders.

This bundle also adds a way to run menu extension after the menu has been built
which can allow you to remove nodes before the menu is rendered.

Registering a Builder
=====================

```xml
<service id="symedit_blog.symedit.menu" class="%symedit_blog.symedit.menu.class%">
    <tag name="symedit_menu.builder" menu="symedit_admin" priority="16" />
</service>
```

`menu` is required on the tag. If there are multiple tags with the same menu
name then they will be built according to priority (higher priority means the
that builder will execute first, default is 0).

Extensions
==========

Security Extension
------------------

You may add `is_granted` information to menu items and they will be removed if
the user does not have these permissions:

```php
$menu->addChild('Label', array(
    'extras' => array(
        'is_granted' => 'ROLE_ADMIN'
    ),
));
```

Remove Empty Dropdowns
----------------------

You can use `remove_leaf` to remove any dropdowns with no children. We
suggest having a main menu builder run first to create each of the dropdowns
that your other bundles may use so they won't have to check if they exist first
and create them if not. This solves the problem of no other builders using that
dropdown:

```php
$menu->addChild('Dropdown', array(
    'dropdown' => true, // From MopaBootstrapBundle
    'extras' => array(
        'remove_leaf' => true,
    ),
));
```