<?php
if (isset($_POST['search'])) {
?>
	<div class="container d-flex justify-content-center ">
		<table class="table mt-2 table-borderless">
			<thead class="alert-info">
			</thead>
			<tbody>
				<?php
				$id = $_POST['userID'];
				$keyword = $_POST['user_items'];
				$getWord = $conn->prepare("SELECT * FROM `items` WHERE `user_id` LIKE '%$id%' AND `user_items` LIKE '%$keyword%'");
				$getWord->execute();
				foreach ($getWord as $word) {
				?>
					<tr>
						<td><?= $word['user_items'] ?></td>
						<td><?= $word['user_price'] ?></td>
						<td><?= $word['quantity'] ?></td>
					</tr>


				<?php
				}
				?>
			</tbody>
		</table>
	</div>
<?php
}
?>