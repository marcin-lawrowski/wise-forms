<div class="wrap">
	<h2>Forms</h2>

	<div class="tablenav top">
		<input type="button" class="button button-primary button-large" value="+ Add Form" onclick="window.location = '<?php echo $this->getNewUrl(); ?>';" />
		<input type="button" class="button button-primary button-large" value="Form Wizard" onclick="window.location = '<?php echo $this->getWizardUrl(); ?>';" />

		<div class="tablenav-pages">
			<span class="displaying-num"><?php echo $total; ?> forms</span>
			<span class="pagination-links">
				<a class="first-page" title="Go to the first page" href="<?php echo $urlPageFirst; ?>">«</a>
				<a class="prev-page" title="Go to the previous page" href="<?php echo $urlPagePrevious; ?>">‹</a>
				<span class="paging-input"><span class="current-page"><?php echo $currentPage; ?></span> of <span class="total-pages"><?php echo $totalPages; ?></span></span>
				<a class="next-page" title="Go to the next page" href="<?php echo $urlPageNext; ?>">›</a>
				<a class="last-page" title="Go to the last page" href="<?php echo $urlPageLast; ?>">»</a>
			</span>
		</div>
		<br class="clear">
	</div>

	<table class="wp-list-table widefat fixed striped users">
		<thead>
		<tr>
			<th scope="col" width="40"><span>ID</span></th>
			<th scope="col"><span>Name</span></th>
			<th scope="col"><span>Shortcode</span></th>
			<th scope="col" width="160"></th>
		</thead>

		<tbody>
			<?php foreach ($objects as $object) { ?>
				<tr>
					<td><?php echo $object->getId(); ?></td>
					<td><a href="<?php echo $this->getEditUrl($object->getId()); ?>"><?php echo $object->getName(); ?></a></td>
					<td>[wise-forms id="<?php echo $object->getId(); ?>"]</td>
					<td>
						<a href="<?php echo $this->getEditUrl($object->getId()); ?>" class="button button-primary button-small">Edit</a>
						<a href="<?php echo $this->getObjectCloneUrl($object->getId()); ?>" class="button button-primary button-small" onclick="return confirm('Are you sure you want to clone the form?')">Clone</a>

						<a class="button button-small" href="<?php echo $this->getObjectDeleteUrl($object->getId()); ?>" onclick="return confirm('Are you sure you want to delete the form?')">Delete</a>
					</td>
				</tr>
			<?php } ?>

			<?php if (count($objects) === 0) { ?>
				<tr>
					<td colspan="4">No forms created yet</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>