<?php $this->load->view('partials/back/head'); ?>

<style>
	/* Embedded CSS */
</style>

</head>

<body>
	<?php $this->load->view('partials/back/sidebar'); ?>

	<section class="content-wrapper">
		<div class="content">
			<div class="container-fluid">
				<div id="location" class="mb-lg-4 mb-1">

					<?= $this->session->flashdata('message') ?>

					<div class="d-flex justify-content-between align-items-start">
						<div>
							<h4 class="text-black font-semibold mb-1">
								<?= $title; ?>
							</h4>

							<nav aria-label="breadcrumb">
								<ol class="breadcrumb bg-transparent p-0 py-2">
									<li class="breadcrumb-item"><a href="<?= base_url() . $this->uri->segment(1); ?>">Location</a></li>
									<li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
								</ol>
							</nav>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="card border-0">
								<div class="card-body">
									<?= form_open('location/add', ['id' => 'location-form', 'method' => 'POST', 'novalidate' => '']); ?>
									<div class="form-group">
										<label for="lat">Latitude <span class="text-danger">*</span></label>
										<input type="text" name="lat" id="lat" class="form-control decimal <?php if (form_error('lat')) : ?>is-invalid<?php endif ?>" value="<?= $_GET['lat'] ?? set_value('lat'); ?>" required>
										<?php if (form_error('lat')) : ?>
											<?= form_error('lat', '<div class="invalid-feedback">', '</div>') ?>
										<?php endif ?>
									</div>

									<div class="form-group">
										<label for="lon">Longitude <span class="text-danger">*</span></label>
										<input type="text" name="lon" id="lon" class="form-control decimal <?php if (form_error('lon')) : ?>is-invalid<?php endif ?>" value="<?= $_GET['lon'] ?? set_value('lon'); ?>" required>
										<?php if (form_error('lon')) : ?>
											<?= form_error('lon', '<div class="invalid-feedback">', '</div>') ?>
										<?php endif ?>
									</div>

									<div class="form-group">
										<label for="exclude">Include <span class="text-danger">*</span></label>
										<select name="exclude" id="exclude" class="form-control <?php if (form_error('exclude')) : ?>is-invalid<?php endif ?>" required>
											<option value="hourly,daily">Current</option>
											<option value="current,daily">Hourly</option>
											<option value="current,hourly">Daily</option>
										</select>
										<?php if (form_error('exclude')) : ?>
											<?= form_error('exclude', '<div class="invalid-feedback">', '</div>') ?>
										<?php endif ?>
									</div>

									<div class="d-flex justify-content-end mt-4">
										<a class="btn btn-outline-secondary mr-3" href="<?= base_url() . $this->uri->segment(1); ?>">Cancel</a>
										<button type="submit" class="btn btn-success">Add Location</button>
									</div>
									<?= form_close(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php $this->load->view('partials/back/script'); ?>

	<script src="<?= base_url('assets/libs/jquery-inputmask/jquery.inputmask.min.js'); ?>"></script>

	<script type="text/javascript">
		$(document).ready(() => {
			"use strict";

			$(".decimal").inputmask({
				alias: "decimal",
				rightAlign: false
			});
		});
	</script>
</body>

</html>
