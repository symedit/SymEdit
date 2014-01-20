SitemapBundle
===

Basic Setup:

```yaml
symedit_sitemap:
    models:
        blog_posts:
            repository: symedit.repository.post
            method: findPublished
            route:
                path: blog_show_slug
                params:
                    slug: $slug
            changefreq: monthly
            lastmod: updatedAt
            priority: 0.6
```

Inside of the route params, or the route path you can prefix strings with a
dollar sign ($). This will try to fetch the current models value. So using
`$slug` would try to fetch the objects public property $slug, or try to fetch
it via getSlug() using Symfony's PropertyAccess Component.