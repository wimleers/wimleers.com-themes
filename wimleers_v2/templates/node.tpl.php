<article id="node-<?php print $node->nid; ?>" class="g9 suf2 <?php print $classes; ?>"<?php print $attributes; ?>>
  <header>
    <h1<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h1>
    <?php if ($meta): ?>
      <p class="meta"><?php print $meta ?></p>
    <?php endif; ?>
  </header>
  <div class="body "<?php print $content_attributes; ?>>
    <?php
      // Hide the comments and links; we'll render them later.
      hide($content['comments']);
      hide($content['links']);
      // Hide the tags and downloads; we'll render them in the sidebar.
      hide($content['taxonomy_vocabulary_1']);
      hide($content['upload']);
      print render($content);
    ?>
  </div>
  <section id="links">
    <?php
    if ($is_comment_reply_page) {
      hide($content['links']['comment']);
    }
    print render($content['links']);
    ?>
  </section>
  <section id="comments">
    <?php print render($content['comments']); ?>
  </section>
  <?php if (!$is_comment_reply_page && $node->comment_count >= 5): ?>
    <section id="links-below-comments">
      <?php print render($content['links']['comment']); ?>
    </section>
  <?php endif; ?>
</article>
