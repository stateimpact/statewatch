Our WordPress blogs all run on the same theme: StateWatch. This theme was adapted from the Argo Foundation (it began as a child theme and still contains many `argo_`-prefixed functions) and is built around many of the lessons learned in Project Argo.

Below is an outline of the theme's codebase. Top-level files control parts of the theme's presentation (`loop.php` and `404.php`) or are page templates (`about.php`). These files are documented extensively on the [WordPress Codex](http://codex.wordpress.org/Theme_Development).

Theme functionality is defined in `functions.php` and imported files. Specific pieces of functionality are grouped in files or directories under `includes`. Functionality should be extracted into plugins wherever possible. Where functionality can't be extracted or is intrinsic to the theme, we've tried to structure the code like a plugin. See `includes/topics` as an example.

statewatch
 - css
 - js
 - includes/
   - ads.php
   - audio (not used)
   - settings/ (various theme-related settings)
     - argo.php
     - statewatch.php

  - topics/ (StateImpact topic buildouts)
     - css
     - js
     - topics.php
     - walker.php

  - admin.php (sticky custom post types, plus any other editor mods)
  - collection-background.php
  - collection-featured.php
  - collection-header.php
  - collection-links.php
  - collection-multimedia.php
  - editor.php (editor mods)
  - featured-posts.php (featured posts menu and sidebar widget)
  - feedburner.php (feedburner email widget)
  - media.php (image sizes and media handling)
  - multimedia.php (custom post types linking to external content)
  - nav.php (navigation mods)
  - sidebars.php (define dynamic sidebars)
  - static-pages.php (get and create required static pages, like About)
  - stations.php (station and partner post types)
  - sw-widgets.php (sidebar widgets)
  - taxonomy.php (custom taxonomies)
  - template.php (template modifications, including wide posts)
  - topic_loop.php
  - users.php (staff management)
 - 404.php
 - about.php
 - archive.php
 - category.php
 - comments.php
 - editor-style.css
 - featured-topics.php
 - footer.php
 - functions.php
 - header.php
 - index.php
 - loop.php
 - page.php
 - post-meta.php
 - README
 - search.php
 - searchform.php
 - sidebar-about.php
 - sidebar-category.php
 - sidebar-post.php
 - sidebar-topic.php
 - sidebar.php
 - single-full-width.php
 - single-topic.php
 - single.php
 - style.css
 - tag.php
 - taxonomy.php
 - topic-index.php