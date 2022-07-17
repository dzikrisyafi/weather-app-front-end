<nav class="nav">
	<div class="sidebar-links m-auto">
		<div class="sidebar-brand">
			<div class="sidebar-brand-image">
				<img src="<?= base_url('assets/img/brand/logo-prodia.png') ?>" alt="logo">
			</div>
		</div>

		<div class="sidebar-profile">
			<div class="sidebar-profile-image">
				<img src="<?= base_url('assets/img/profile/default-profile.png') ?>" alt="profile">
			</div>
			<div class="sidebar-profile-text d-flex flex-column w-100">
				<p class="font-semibold mb-0"><?= get_session('name'); ?></p>
				<small class="text-truncate">Manusia Biasa</small>
			</div>
		</div>

		<div class="sidebar-menu">
			<ul class="navbar-nav">
				<li class="nav-item <?php if ($this->uri->segment(1) == 'dashboard') : ?>active<?php endif; ?>">
					<a href="<?= base_url('dashboard'); ?>" class="nav-link">
						<i class='bx bx-home-alt'></i>
						<div class="nav-text">
							<span>Dashboard</span>
						</div>
					</a>
				</li>
				<li class="nav-item <?php if ($this->uri->segment(1) == 'location') : ?>active<?php endif; ?>">
					<a href="<?= base_url('location'); ?>" class="nav-link">
						<i class='bx bx-map'></i>
						<div class="nav-text">
							<span>Saved Location</span>
						</div>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?= base_url('logout'); ?>" class="nav-link">
						<i class='bx bx-exit'></i>
						<div class="nav-text">
							<span>Logout</span>
						</div>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="sidebar__overlay"></div>
</nav>
