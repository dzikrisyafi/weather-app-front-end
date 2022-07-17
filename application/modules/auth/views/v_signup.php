<?php $this->load->view('partials/front/head'); ?>

<link rel="stylesheet" href="<?= base_url('assets/libs/select2/css/select2.min.css'); ?>">

<style>
	/* Embedded CSS */
</style>

</head>

<body>
	<main>
		<section id="login">
			<div class="container">
				<div class="row d-flex justify-content-center align-items-center" style="min-height: 100vh;">
					<div class="col-sm-10 col-md-8 col-lg-5">

						<?= $this->session->flashdata('message') ?>

						<div class="card border-0">
							<div class="card-body mx-2 my-2">
								<h4 class="font-weight-bold text-center mb-1">
									Sign Up to Weather App
								</h4>

								<p class="font-weight-normal text-center text-gray-400 mb-4" style="font-size: 15px;">
									Create an account on weather app and get started
								</p>

								<?= form_open('auth/signup', ['id' => 'form-signup', 'method' => 'POST', 'novalidate' => '']) ?>

								<div class="form-group">
									<label for="name">Name <span class="text-danger">*</span></label>

									<input type="text" class="form-control px-3 <?php if (form_error('name')) : ?>is-invalid<?php endif ?>" id="name" name="name" placeholder="Your name" value="<?= set_value('name') ?>" autofocus>

									<?php if (form_error('name')) : ?>
										<?= form_error('name', '<div class="invalid-feedback">', '</div>') ?>
									<?php endif ?>
								</div>

								<div class="form-group">
									<label for="email">Email <span class="text-danger">*</span></label>

									<input type="email" class="form-control px-3 <?php if (form_error('email')) : ?>is-invalid<?php endif ?>" id="email" name="email" placeholder="name@domain.com" value="<?= set_value('email') ?>">

									<?php if (form_error('email')) : ?>
										<?= form_error('email', '<div class="invalid-feedback">', '</div>') ?>
									<?php endif ?>
								</div>

								<div class="form-group">
									<label for="password">Password <span class="text-danger">*</span></label>

									<input type="password" class="form-control px-3 <?php if (form_error('password')) : ?>is-invalid<?php endif ?>" id="password" name="password" placeholder="At least 8 characters">

									<?php if (form_error('password')) : ?>
										<?= form_error('password', '<div class="invalid-feedback">', '</div>') ?>
									<?php endif ?>
								</div>

								<div class="form-group">
									<label for="confirm_password">Confirm Password <span class="text-danger">*</span></label>

									<input type="password" class="form-control px-3 <?php if (form_error('confirm_password')) : ?>is-invalid<?php endif ?>" id="confirm_password" name="confirm_password" placeholder="At least 8 characters">

									<?php if (form_error('confirm_password')) : ?>
										<?= form_error('confirm_password', '<div class="invalid-feedback">', '</div>') ?>
									<?php endif ?>
								</div>

								<div class="form-check mb-4">
									<input type="checkbox" name="remember" id="remember" class="form-check-input">
									<label class="form-check-label text-gray-400" for="remember" style="font-size: 14px;">I agree to the <span>Terms & Conditions</span></label>
								</div>

								<button type="submit" class="btn btn-prodia btn-block font-semibold px-3 py-2 mb-4">Sign up</button>

								<div class="text-center">
									<span style="font-size: 15px;">
										Already have account?
										<a href="<?= base_url('auth/login'); ?>">Log in</a>
									</span>
								</div>

								<?= form_close() ?>
							</div>
						</div>

					</div>
				</div>
			</div>
		</section>
	</main>

	<?php $this->load->view('partials/front/script'); ?>
</body>

</html>
