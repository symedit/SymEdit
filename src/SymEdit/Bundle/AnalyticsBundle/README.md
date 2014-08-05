SymEdit Analytics Bundle
==========

Track your Doctrine Entities and create reports:

```php
// Get an entity
$post = $repository->find(5);

// Track it
$this->get('symedit_analytics.tracker')->track($post);
```

Include twig function to render (currently requires jQuery)
===

```jinja
{{ symedit_analytics_render() }}
```

Run reports:

```php
$reporter = $this->get('symedit_analytics.reporter');

$popularPosts = $reporter->runReport('popular', array(
    'class' => 'SymEdit\Bundle\BlogBundle\Model\Post',
));
```

Creating your own reports:
===

```php
class MyReport extends AbstractReport
{
    public function buildQuery(QueryBuilder $queryBuilder, $visitClass, array $options = array())
    {
        return parent::buildQuery($queryBuilder, $visitClass, $options)
            ->andWhere('c.status = :status')
            ->setParameter('status', Post::STATUS_PUBLISHED);
    }

    public function getClass()
    {
        return 'SymEdit\Bundle\BlogBundle\Model\Post';
    }

    public function getName()
    {
        return 'my_report';
    }
}
```

And the configuration:

```xml
<service id="my_bundle.my_report" class="%my_bundle.my_report.class%">
    <tag name="symedit_analytics.report" alias="my_report" />
</service>
```

And then use your report:

```php
$reporter = $this->get('symedit_analytics.reporter');

$result = $reporter->runReport('my_report');
```

Unless you change the buildQuery substantially your results will look something
like this:

```php
array(
    array(
        'object' => [A Doctrine Entity]
        'visits' => 45
    ),
    ...
)
```