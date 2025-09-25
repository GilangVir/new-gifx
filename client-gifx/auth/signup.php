<?php
use App\Models\Helper;

$referral = Helper::form_input($_GET['referral'] ?? "");
?>

<div class="main-content login-panel">
	<div class="login-body">
		<div class="top d-flex justify-content-between align-items-center">
			<div class="logo">
				<img src="/assets/images/logo-black-new.png" alt="Logo">
			</div>
			<a href="/"><i class="fa-duotone fa-house-chimney"></i></a>
		</div>
		<div class="bottom">
			<h3 class="panel-title">Registration</h3>
			<form id="form-signup" method="post">
				<input type="hidden" name="csrf_token" value="">
				<div class="input-group mb-25">
					<span class="input-group-text"><i class="fa-regular fa-user"></i></span>
					<input type="text" name="fullname" required data-parsley-required class="form-control"
						autocomplete="off" placeholder="Full Name">
				</div>
				<div class="input-group mb-25">
					<span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
					<input type="email" required name="email" class="form-control" autocomplete="off"
						placeholder="Email">
				</div>
				<div class="input-group mb-20">
					<span class="input-group-text"><i class="fa-regular fa-lock"></i></span>
					<input type="password" required name="password" class="form-control rounded-end"
						autocomplete="off" placeholder="Password">
					<a role="button" class="password-show"><i class="fa-duotone fa-eye"></i></a>
				</div>
				<div class="input-group mb-25">
					<span class="input-group-text"><i class="fa-regular fa-at"></i></span>
					<input type="text" name="refferal" class="form-control" autocomplete="off" placeholder="Referal" value="<?= $referral ?>">
				</div>
				<div class="d-flex justify-content-between mb-25">
					<div class="form-check">
						<input class="form-check-input" name="terms" type="checkbox" required checked
							id="loginCheckbox">
						<label class="form-check-label text-white" for="loginCheckbox">
							Saya telah membaca dan menyetujui 
							<a href="#" data-bs-toggle="modal" data-bs-target="#addTaskModal" class="text-white text-decoration-underline">Syarat dan Ketentuan serta Kebijakan Privasi</a>
						</label>
					</div>
				</div>
				<button type="submit" name="submit_register" class="btn btn-primary w-100 login-btn">Sign up</button>
			</form>
			<!-- <div class="other-option">
				<p>Or continue with</p>
				<div class="social-box d-flex justify-content-center gap-20">
					<a href="#"><i class="fa-brands fa-facebook-f"></i></a>
					<a href="#"><i class="fa-brands fa-twitter"></i></a>
					<a href="#"><i class="fa-brands fa-google"></i></a>
					<a href="#"><i class="fa-brands fa-instagram"></i></a>
				</div>
			</div> -->
		</div>
	</div>

	<!-- footer start -->
	<?php require_once __DIR__ . "/footer.php"; ?>
	<!-- footer end -->
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$("#form-signup").on("submit", function(e) {
			e.preventDefault(); 
			let formData = $(this).serialize(), 
				button = $(this).find('button[type="submit"]');
			
			button.addClass('loading'); 
			$.post("/ajax/auth/signup", formData, function(resp) {
				button.removeClass('loading'); 
				Swal.fire(resp.alert).then(() => {
					if(resp.success) {
						location.href = resp.data.redirect;
					}
				});
			}, 'json'); 
		});
	})
</script>