SymEdit Widget Bundle
========================

Configuration

```yaml
symedit_widget:
    driver:               doctrine/orm

    # Fragment stategy to use
    fragment:
        strategy:             inline
    classes:
        widget:
            model:                SymEdit\Bundle\WidgetBundle\Model\Widget
            controller:           SymEdit\Bundle\WidgetBundle\Controller\WidgetController
            respository:          ~
            form:                 SymEdit\Bundle\WidgetBundle\Form\Type\WidgetType
        widget_area:
            model:                SymEdit\Bundle\WidgetBundle\Model\WidgetArea
            repository:           ~
            form:                 SymEdit\Bundle\WidgetBundle\Form\Type\WidgetAreaType
```

Creating a Strategy
-------------------

Build your strategy class:

```php
namespace SymEdit\Bundle\WidgetBundle\Widget\Strategy;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MyStrategy extends AbstractWidgetStrategy
{
    public function execute(WidgetInterface $widget)
    {
        return $this->render($widget, array(
            'number' => $widget->getOption('number'),
        ));
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'MyBundle:Widget:mywidget.html.twig',
            'number' => 5,
        ));
    }

    /**
     * Return array of options to pass to Response::setCache,
     * if it should not be cached return array('private' => true)
     */
    public function getCacheOptions(WidgetInterface $widget)
    {
        return array(
            'public' => true,
            'last_modified' => $widget->getUpdatedAt(),
        );
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('number', 'integer')
        ;
    }

    public function getName()
    {
        return 'number';
    }

    public function getDescription()
    {
        return 'widget.number'; // Translated
    }
}
```

Add it to your services:

```xml
<service id="mywidget.number" class="%mywidget.number.class%">
    <tag name="symedit_widget.widget_strategy" alias="number" />
</service>
```

Rendering Widgets
-----------------

This renders a widget area:

```jinja
{{ symedit_widget_area_render('footer') }}
```

In your widget area templates you should use:

```jinja
{% for widget in widgets %}
    {{ symedit_widget_render(widget) }}
{% endfor %}
```

This is a passthrough for the fragment renderer so if you turn on ESI then
you can cache the rest of your page except for the widgets.
