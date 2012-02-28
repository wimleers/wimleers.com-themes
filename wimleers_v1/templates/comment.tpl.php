<?php
$nid     = $content['comment_body']['#object']->nid;
$subject = $content['comment_body']['#object']->subject;
$comment = $content['comment_body']['#object']->comment_body['und'][0]['value'];
$manual_subject = ($nid > 112 || strpos($comment, $subject) === 0) ? FALSE : TRUE;
?>
<div class="<?php print $classes . ' ' . $zebra; ?>"<?php print $attributes; ?>>

  <div class="clearfix">

    <span class="submitted"><?php print $submitted ?></span>

  <?php if ($new) : ?>
    <span class="new"><?php print drupal_ucfirst($new) ?></span>
  <?php endif; ?>

  <?php print $picture ?>

    <?php if ($manual_subject): ?>
    <?php print render($title_prefix); ?>
    <h3<?php print $title_attributes; ?>><?php print $title ?></h3>
    <?php print render($title_suffix); ?>
    <?php endif; ?>

    <div class="content"<?php print $content_attributes; ?>>
      <?php hide($content['links']); print render($content); ?>
      <?php if ($signature): ?>
      <div class="clearfix">
        <div>—</div>
        <?php print $signature ?>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <?php print render($content['links']) ?>
</div>
