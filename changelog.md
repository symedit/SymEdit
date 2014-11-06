Upgrade to 9.*
===============

    - Move SymEdit/Widget/gallery.html.twig => SymEdit/Widget/Media/gallery.html.twig
    - Move SymEdit/Widget/slider.html.twig => SymEdit/Widget/Media/slider.html.twig
    - Page controller names need to be change to underscore from hyphens
    - Page controllers can no longer be defined in the routing, they need
        to be defined in /Resources/config/symedit/page_controllers.yml
