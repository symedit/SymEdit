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

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\Form\FormBuilderInterface;

class MyStrategy extends AbstractWidgetStrategy
{
    public function execute(WidgetInterface $widget)
    {
        return $this->render('MyBundle:Widget:mywidget.html.twig', array(
            'number' => $widget->getOption('number'),
        ));
    }

    public function setDefaultOptions(WidgetInterface $widget)
    {
        $widget->setOptions(array(
            'number' => 5,
        ));
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

```jinja
{% widgetarea 'footer' %}
```