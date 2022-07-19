<?php $this->load->view('partials/back/head'); ?>

<link rel="stylesheet" href="<?= base_url('assets/libs/datatables/dataTables.bootstrap4.css'); ?>">

<style>
	/* Embedded CSS */
	.thumbnail {
		width: 40px;
		height: 40px;
	}
</style>

</head>

<body>
	<?php $this->load->view('partials/back/sidebar'); ?>

	<section class="content-wrapper">
		<?php $this->load->view('partials/back/topbar'); ?>

		<div class="content">
			<div class="container-fluid">
				<div id="locations" class="mb-lg-4 mb-1">

					<?= $this->session->flashdata('message') ?>

					<div class="d-flex justify-content-between align-items-start">
						<div>
							<h4 class="text-black font-semibold mb-1">
								Saved Location
							</h4>

							<p class="text-gray-400 fw-normal mb-4"><?= count($locations) ?> Total Location</p>
						</div>
						<a href="<?= base_url('location/add'); ?>" class="btn btn-primary d-flex align-items-center">
							<i class='bx bx-plus mr-1'></i>
							<span>Add Location</span>
						</a>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="card border-0">
								<div class="card-body">
									<div class="table-responsive">
										<table id="dt-location" class="table">
											<thead>
												<tr>
													<th scope="col">Lat</th>
													<th scope="col">Lon</th>
													<th scope="col">Timezone</th>
													<th scope="col">Category</th>
													<th scope="col"></th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($locations as $location) : ?>
													<tr>
														<td><?= round($location->lat, 4); ?></td>
														<td><?= round($location->lon, 4); ?></td>
														<td><?= $location->timezone; ?></td>
														<td>
															<?php if ($location->forecast_category == 1) : ?>
																current
															<?php elseif ($location->forecast_category == 2) : ?>
																hourly
															<?php else : ?>
																daily
															<?php endif; ?>
														</td>
														<td>
															<?= form_open('location/update', ['id' => 'location-form', 'method' => 'POST', 'novalidate' => '']); ?>
															<input type="hidden" name="lat" value="<?= $location->lat; ?>">
															<input type="hidden" name="lon" value="<?= $location->lon; ?>">
															<input type="hidden" name="exclude" value="<?php if ($location->forecast_category == 1) : ?>hourly,daily<?php elseif ($location->forecast_category == 2) : ?>current,daily<?php else : ?>current,hourly<?php endif; ?>">
															<button type="submit" class="btn btn-primary btn-sm">Update</button>
															<?= form_close(); ?>
														</td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php $this->load->view('partials/back/script'); ?>

	<script src="<?= base_url('assets/libs/datatables/jquery.dataTables.min.js') ?>"></script>
	<script src="<?= base_url('assets/libs/datatables/dataTables.bootstrap4.min.js') ?>"></script>

	<script>
		$(document).ready(() => {
			"use strict";

			let dt_location = $("#dt-location").DataTable();
		});
	</script>
</body>

</html>
