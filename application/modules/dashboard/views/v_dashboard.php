<?php $this->load->view('partials/back/head'); ?>

<link rel="stylesheet" href="<?= base_url('assets/libs/datatables/dataTables.bootstrap4.css'); ?>">

<style>
	.overviews img {
		width: 32px;
		margin-bottom: 10px;
	}
</style>

</head>

<body>
	<?php $this->load->view('partials/back/sidebar'); ?>

	<section class="content-wrapper">
		<?php $this->load->view('partials/back/topbar'); ?>

		<div class="content">
			<div class="container-fluid">
				<div class="overviews mb-lg-4 mb-1">
					<h4 class="text-black font-semibold mb-2">
						Today Overviews
					</h4>

					<p class="text-gray-400 text-sm fw-normal mb-1">Latitude: <?= $lat; ?>, Longitude: <?= $lon; ?></p>

					<p class="text-gray-400 text-sm fw-normal mb-4">
						<?php if (isset($current_weather->timezone)) : ?>
							Timezone: <?= $current_weather->timezone; ?>
						<?php else : ?>
							Your location is not available! <a href="<?= base_url('location/add'); ?>" target="_blank">Add location</a>
						<?php endif; ?>
					</p>


					<div class="row">
						<div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
							<div class="card border-0 mb-lg-0 mb-3">
								<div class="card-body">
									<img src="<?= base_url('assets/img/icons/bx-water.svg') ?>" alt="pressure">
									<h4 class="text-black"><?= $current_weather->pressure ?? 0; ?></h4>
									<p class="text-left text-sm text-gray-500">Pressure</p>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
							<div class="card border-0 mb-lg-0 mb-3">
								<div class="card-body">
									<img src="<?= base_url('assets/img/icons/bx-cloud.svg') ?>" alt="humidity">
									<h4 class="text-black"><?= $current_weather->humidity ?? 0; ?></h4>
									<p class="text-left text-sm text-gray-500">Humidity</p>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
							<div class="card border-0 mb-lg-0 mb-3">
								<div class="card-body">
									<img src="<?= base_url('assets/img/icons/bx-wind.svg') ?>" alt="windspeed">
									<h4 class="text-black"><?= $current_weather->wind_speed ?? 0; ?></h4>
									<p class="text-left text-sm text-gray-500">Wind Speed</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="weathers mb-lg-4 mb-1">
					<div class="row">
						<div class="col-md-12 col-lg-12">
							<div class="card border-0 mb-lg-0 mb-3">
								<div class="card-body">
									<nav class="mb-4">
										<div class="nav nav-tabs" id="nav-tab" role="tablist">
											<a class="nav-item nav-link active" id="hourly-tab" data-toggle="tab" href="#hourly" role="tab" aria-controls="hourly" aria-selected="true">Hourly</a>
											<a class="nav-item nav-link" id="daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily" aria-selected="false">Daily</a>
										</div>
									</nav>
									<div class="tab-content" id="nav-tabContent">
										<div class="tab-pane fade show active" id="hourly" role="tabpanel" aria-labelledby="hourly-tab">
											<h5 class="text-black font-semibold mb-1">
												Hourly Forecast
											</h5>

											<p class="text-gray-400 text-sm font-weight-normal mb-4">
												Ramalan cuaca beberapa jam ke depan
											</p>

											<div class="table-responsive">
												<table id="dt-hourly-weather" class="table" width="100%">
													<thead class="border-bottom">
														<tr>
															<th>Id</th>
															<th>Main</th>
															<th>Description</th>
														</tr>
													</thead>
													<tbody>
														<?php if ($hourly_weather) : ?>
															<?php foreach ($hourly_weather as $weather) : ?>
																<tr>
																	<td><?= $weather->weather->id ?? ''; ?></td>
																	<td><?= $weather->weather->main ?? ''; ?></td>
																	<td><?= $weather->weather->description ?? ''; ?></td>
																</tr>
															<?php endforeach; ?>
														<?php endif; ?>
													</tbody>
												</table>
											</div>
										</div>
										<div class="tab-pane fade" id="daily" role="tabpanel" aria-labelledby="daily-tab">
											<h5 class="text-black font-semibold mb-1">
												Daily Forecast
											</h5>

											<p class="text-gray-400 text-sm font-weight-normal mb-4">
												Ramalan cuaca beberapa hari ke depan
											</p>

											<div class="table-responsive">
												<table id="dt-daily-weather" class="table" width="100%">
													<thead class="border-bottom">
														<tr>
															<th>Id</th>
															<th>Main</th>
															<th>Description</th>
														</tr>
													</thead>
													<tbody>
														<?php if ($daily_weather) : ?>
															<?php foreach ($daily_weather as $weather) : ?>
																<tr>
																	<td><?= $weather->weather->id ?? ''; ?></td>
																	<td><?= $weather->weather->main ?? ''; ?></td>
																	<td><?= $weather->weather->description ?? ''; ?></td>
																</tr>
															<?php endforeach; ?>
														<?php endif; ?>
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
			</div>
		</div>
	</section>

	<?php $this->load->view('partials/back/script'); ?>

	<script src="<?= base_url('assets/libs/datatables/jquery.dataTables.min.js') ?>"></script>
	<script src="<?= base_url('assets/libs/datatables/dataTables.bootstrap4.min.js') ?>"></script>


	<script>
		$(document).ready(() => {
			"use strict";

			let dt_hourly_weather = $("#dt-hourly-weather").DataTable();
			let dt_daily_weather = $("#dt-daily-weather").DataTable();
		});
	</script>
</body>

</html>
