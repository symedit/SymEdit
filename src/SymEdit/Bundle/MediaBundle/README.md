SymEdit Media Bundle
========================

Configuration:

```yaml
# Gaufrette Configuration
knp_gaufrette:
    adapters:
        symedit_image:
            local:
                directory: %kernel.root_dir%/../web/media/image
                create: true
        symedit_file:
            local:
                directory: %kernel.root_dir%/../web/media/file
                create: true
    filesystems:
        symedit_image:
            adapter: symedit_image
        symedit_file:
            adapter: symedit_file

# Media Configuration
symedit_media:
    paths:
        image: /media/image
        file: /media/file
```

Paths should match between Gaufrette and the Media Configuration