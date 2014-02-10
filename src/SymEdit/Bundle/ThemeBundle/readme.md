# SymEdit Theme Bundle

```yaml
symedit_theme:
    theme_directory: %kernel.root_dir%/../themes
    public_directory: themes
    active_theme: default
    templates:
        bundles: [AcmeDemoBundle]
```

The theme bundle will load templates from the `{theme_directory}/{active_theme}/templates
folder. It also will allow you to use local assetic files. Themes are comprised
of a simple YAML definition (in theme.yml):

```yaml
theme:
    name: default
    title: Default Theme
    description: Default Theme for all websites
    stylesheets:
        filters: [cssrewrite]
        inputs:
           - 'bundles/acmedemo/bootstrap/css/bootstrap.min.css'
           - 'bundles/acmedemo/css/font-awesome.min.css'
           - '@AcmeDemoBundle/Resources/less/site.less'
           - 'css/site.less' # Taken from /{active_theme}/css/site.less
    javascripts:
        # Same as stylesheets
        inputs: []
```

You will now use your css in your templates like so:

```jinja
{% stylesheets '@theme_css' %}
<link rel="stylesheet" href="{{ asset_url }}">
{% endstylesheets %}
```

You can always include other stylesheets there as well, the @theme_css is mostly
to be able to access local assets inside your theme. Any bundle assets from
other bundles can be intermixed:

```jinja
{% stylesheets
    '@theme_css'
    '@AcmeDemoBundle/Resources/less/site.less' %}
<link rel="stylesheet" href="{{ asset_url }}">
{% endstylesheets %}
```

This same applies for javascripts as well and you can get it through assetic
by `@theme_js`.

## Templates

All your template includes and `extends` should use the @Theme namespace:

```jinja
{% extends '@Theme/Page/base.html.twig' %}

{% block content %}
    {% include '@Theme/Includes/content.html.twig' %}
{% endblock %}
```

## Forms

You can select a template using the `template` form type:

```php
$builder->add('page_template', 'template');
```