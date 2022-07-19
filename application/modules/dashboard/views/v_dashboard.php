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

					<p class="text-gray-400 text-sm fw-normal mb-1">Latitude: <span id="lat"></span>, Longitude: <span id="lon"></span></p>

					<p id="timezone" class="text-gray-400 text-sm fw-normal mb-4">

					</p>


					<div class="row">
						<div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
							<div class="card border-0 mb-lg-0 mb-3">
								<div class="card-body">
									<img src="<?= base_url('assets/img/icons/bx-water.svg') ?>" alt="pressure">
									<!-- <h4 class="text-black"><?= $current_weather->pressure ?? 0; ?></h4> -->
									<h4 id="pressure" class="text-black"></h4>
									<p class="text-left text-sm text-gray-500">Pressure</p>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
							<div class="card border-0 mb-lg-0 mb-3">
								<div class="card-body">
									<img src="<?= base_url('assets/img/icons/bx-cloud.svg') ?>" alt="humidity">
									<!-- <h4 class="text-black"><?= $current_weather->humidity ?? 0; ?></h4> -->
									<h4 id="humidity" class="text-black"></h4>
									<p class="text-left text-sm text-gray-500">Humidity</p>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
							<div class="card border-0 mb-lg-0 mb-3">
								<div class="card-body">
									<img src="<?= base_url('assets/img/icons/bx-wind.svg') ?>" alt="windspeed">
									<!-- <h4 class="text-black"><?= $current_weather->wind_speed ?? 0; ?></h4> -->
									<h4 id="wind_speed" class="text-black"></h4>
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

	<script type="text/javascript">
		$(document).ready(() => {
			"use strict";

			initGeolocation();

			$.ajax({
				url: base_url('dashboard/get_current_weather'),
				method: 'GET',
				dataType: 'JSON',
				data: {
					lat: localStorage.getItem('lat'),
					lon: localStorage.getItem('lon')
				},
				success: function(data) {
					if (data) {
						$("#timezone").html('Timezone: ' + data.timezone);
						$("#pressure").html(data.pressure);
						$("#humidity").html(data.humidity);
						$("#wind_speed").html(data.wind_speed);
					} else {
						$("#timezone").html('Your location is not available, <a href="' + base_url('location/add') + '?lat=' + localStorage.getItem('lat') + '&lon=' + localStorage.getItem('lon') + '" target="_blank">Add location</a>');
						$("#pressure").html(0);
						$("#humidity").html(0);
						$("#wind_speed").html(0);
					}
				}
			});

			let dt_hourly_weather = $("#dt-hourly-weather");

			dt_hourly_weather.DataTable({
				processing: true,
				ordering: true,
				paging: true,
				info: true,
				filter: true,

				ajax: {
					url: base_url('dashboard/get_hourly_weather'),
					type: 'POST',
					data: function(d) {
						d.lat = localStorage.getItem('lat');
						d.lon = localStorage.getItem('lon');
					},
				},

				columns: [{
						"data": "id",
					},
					{
						"data": "main",
					},
					{
						"data": "description",
					},
				],
			});

			let dt_daily_weather = $("#dt-daily-weather");

			dt_daily_weather.DataTable({
				processing: true,
				ordering: true,
				paging: true,
				info: true,
				filter: true,

				ajax: {
					url: base_url('dashboard/get_daily_weather'),
					type: 'POST',
					data: function(d) {
						d.lat = localStorage.getItem('lat');
						d.lon = localStorage.getItem('lon');
					},
				},

				columns: [{
						"data": "id",
					},
					{
						"data": "main",
					},
					{
						"data": "description",
					},
				],
			});
		});

		function initGeolocation() {
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(setPosition, locationError);
			} else {
				alert('Geolocation is not supported by this browser');
			}
		}

		function setPosition(position) {
			$("#lat").html(position.coords.latitude);
			$("#lon").html(position.coords.longitude);

			localStorage.setItem('lat', position.coords.latitude);
			localStorage.setItem('lon', position.coords.longitude);
		}

		function locationError(error) {
			console.error(error);
		}

		function base_url(param) {
			var pathparts = location.pathname.split('/');
			if (location.host == 'localhost' || location.host == '127.0.0.1') {
				var url = location.origin + '/' + pathparts[1].trim('/') + '/';
			} else {
				var url = location.origin + '/';
			}
			return param ? url + param : url;
		}
	</script>
</body>

</html>
