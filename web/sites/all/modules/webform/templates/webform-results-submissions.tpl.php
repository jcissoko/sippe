<?php
// $Id:

/**
 * @file
 * Result submissions page.
 *
 * Available variables:
 * - $node: The node object for this webform.
 * - $submissions: The Webform submissions array.
 * - $total_count: The total number of submissions to this webform.
 * - $pager_count: The number of results to be shown per page.
 * - is_submissions: The user is viewing the node/NID/submissions page.
 * - $table: The table[] array consists of three keys:
 * - $table['#header']: Table header.
 * - $table['#rows']: Table rows.
 * - $table['#operation_total']: Maximum number of operations in the operation column.
 */
?>

<?php if (count($table['#rows'])): ?>
  <?php print theme('webform_results_per_page', array('total_count' => $total_count, 'pager_count' => $pager_count)); ?>
  <?php print render($table); ?>
<?php else: ?>
  <?php print t('Il n\'y a pas de soumission pour ce fomulaire. <a href="!url">Voir le formulaire</a>.', array('!url' => url('node/' . $node->nid))); ?>
<?php endif; ?>


<?php if ($is_submissions): ?>
  <?php print theme('links', array('links' => array('webform' => array('title' => t('Retour au formulaire'), 'href' => 'node/' . $node->nid)))); ?>
<?php endif; ?>

<?php if ($pager_count): ?>
  <?php print theme('pager', array('limit' => $pager_count)); ?>
<?php endif; ?>
