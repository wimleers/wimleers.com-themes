<?php
 /**
  * This template is used to print a single field in a view. It is not
  * actually used in default Views, as this is registered as a theme
  * function which has better performance. For single overrides, the
  * template is perfectly okay.
  *
  * Variables available:
  * - $view: The view object
  * - $field: The field handler object that can process the input
  * - $row: The raw SQL result that can be used
  * - $output: The processed output that will normally be used.
  *
  * When fetching output from the $row, this construct should be used:
  * $data = $row->{$field->field_alias}
  *
  * The above will guarantee that you'll always get the correct data,
  * regardless of any changes in the aliasing that might happen if
  * the view is modified.
  */
?>
<?php
// Hacky way to get better summaries that exclude <hX> tags :)
$format = $row->_field_data['nid']['entity']->body['und'][0]['format'];
$body = $row->_field_data['nid']['entity']->body['und'][0]['safe_value'];
$start_pos = strpos($body, '<p>');
$text = drupal_substr($body, $start_pos);
$line = strip_tags(text_summary($text, $format, 200));
?>
<a href="<?php print url("node/$row->nid") ?>" class="g8 omega">
  <h2><?php print $row->node_title ?></h2>
  <p><?php print $line ?></p>
</a>