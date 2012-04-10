<article id="node-<?php print $node->nid; ?>" class="g9 <?php print $classes; ?>"<?php print $attributes; ?>>
  <header>
    <h1<?php print $title_attributes; ?>>Client: <a href="<?php print $node_url; ?>"><?php print $title; ?></a></h1>
    <?php if ($meta): ?>
      <p class="meta"><?php print $meta ?></p>
    <?php endif; ?>
  </header>
  <div class="body "<?php print $content_attributes; ?>>
    <?php print render($content); ?>
  </div>
  <section id="links">
    <?php print render($content['links']); ?>
  </section>
</article>
