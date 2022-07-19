<script src="<?= base_url('assets/libs/jquery/jquery.min.js'); ?>"></script>
<script src="<?= base_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/back/script.js'); ?>"></script>

<script type="text/javascript">
	let csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
	let csrfHash = '<?= $this->security->get_csrf_hash(); ?>';
	let csrf = {};

	csrf[csrfName] = csrfHash;

	$.ajaxSetup({
		"data": csrf
	});
</script>
