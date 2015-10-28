SymEdit
=======

SymEdit is a Symfony based Content Management System. It was designed to be simple for users
and easily extendable for developers. It tries to stay close to Symfony best practices
and methodology so if you know how to use Symfony you can easily add new controllers,
routing, forms, etc. and override the default ones as well.

![Admin Screenshot](http://symedit.com/media/image/screenshot.png "Admin Screenshot")


Installation
------------

Note that this is for installing and testing SymEdit itself, to install a project for yourself
symedit/symedit-standard will be created eventually.

```bash
composer create-project -s symedit/symedit
```

After you have the project created, you need to install the sample data (this sets up
the basic page tree, we will probably add a way to only install the basics eventually)

```bash
php app/console symedit:install
```

This will create the database, load the schema, and install fixtures needed for functional
tests.

Administration
--------------

You can administer the site by going to `/sym-admin`, the default username and password are
`admin` and `test` respectively.

Documentation
-------------

http://docs.symedit.com

Testing
-------

Could definitely use some help in this aspect. There are some unit tests and functional
tests that are run from `phpunit` so you can just run `phpunit` to use the existing tests.

There are also Behat tests which can be run by using `bin/behat` once you've run composer install.

We have a .travis.yml configuration for travis.
