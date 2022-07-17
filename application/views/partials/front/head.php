<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="<?= DEV_NAME; ?>">
	<meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>">

	<title><?= APP_NAME . ' | ' . $title; ?></title>

	<link rel="shortcut icon" href="<?= base_url('assets/img/favicon/favicon.ico'); ?>" type="image/x-icon" />

	<link rel="stylesheet" href="<?= base_url('assets/libs/bootstrap/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" href="<?= base_url('assets/css/front/style.css'); ?>">
