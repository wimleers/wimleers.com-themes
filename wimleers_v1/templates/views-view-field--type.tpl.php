<?php
$node_type = $row->node_type;
?>

<span class="fancy-node-type <?php print $node_type ?>"><?php print str_replace(' ', '&nbsp;', $output); ?></span>