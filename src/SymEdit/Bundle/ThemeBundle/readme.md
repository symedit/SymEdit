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
name: default
parent: base
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

## Parent Themes

You can set your theme to have a parent (should be the slug of the theme, and
themes are located in %theme_dir%/{theme_name}/theme.yml). If your theme has a
parent, then those templates are second in line to be used. After that are the
overrides. If you use an override like "Framework" then templates being
referenced like: @Framework/template.html.twig will instead use your theme
directories to find a template. Likewise, if you use @Theme/template.html and
it only existed in the @Framework namespace, it would still work.

When using a parent theme, you can also store your assets in any theme you'd
like, or have them split up. It will start with your current theme and move
up through all parents trying to locate the resource, so assets in your current
theme take precedence. This helps if you have lots of similar themes so you can
store shared assets in a "base" theme.

## Templates

All your template includes and `extends` should use the @Theme namespace:

```jinja
{% extends '@Theme/Page/base.html.twig' %}

{% block content %}
    {% include '@Theme/Includes/content.html.twig' %}
{% endblock %}
```

### Parent Templates

You can also use the `@Parent` namespace to access parent templates. This allows
you to easily override any part of a parent template without Twig trying to
reference itself. If you're editing `@Theme/Page/base.html.twig` and a parent
theme has the same template, you can extend it by using
`@Parent/Page/base.html.twig`. It will search all parents starting with the most
immediate until it finds one.

**This should only be used in themes that don't, or won't have any children! If
you extend a theme that uses `@Parent` references, the theme itself becomes the
parent and will end up referencing itself.**

## Forms

You can select a template using the `template` form type:

```php
$builder->add('page_template', 'template');
```