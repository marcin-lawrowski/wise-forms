<div class="wrap">
	<h2>Results</h2>

	<div class="tablenav top">
		<div class="tablenav-pages">
			<span class="displaying-num"><?php echo $total; ?> results</span>
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
			<th scope="col"><span>Form name</span></th>
			<th scope="col" width="110"></th>
		</thead>

		<tbody>
			<?php foreach ($objects as $object) { ?>
				<tr>
					<td><?php echo $object->getId(); ?></td>
					<td><a href="<?php echo $this->getEditUrl($object->getId()); ?>"><?php echo $object->getFormName(); ?></a></td>
					<td>
						<a href="<?php echo $this->getEditUrl($object->getId()); ?>" class="button button-small">View</a>

						<a class="button button-primary button-small" href="<?php echo $this->getObjectDeleteUrl($object->getId()); ?>" onclick="return confirm('Are you sure you want to delete the result?')">Delete</a>
					</td>
				</tr>
			<?php } ?>

			<?php if (count($objects) === 0) { ?>
				<tr>
					<td colspan="3">No results found</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>