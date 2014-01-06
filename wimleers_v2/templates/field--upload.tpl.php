<?php

/**
 * Render the file list in a <ul>, with a span around the filesize.
 */

?>

<ul class="files">
<?php foreach ($items as $delta => $item) : ?>
    <li><?php print render($item); ?></li>
<?php endforeach; ?>
</ul>
