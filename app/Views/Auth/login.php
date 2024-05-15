<?= $this->extend($config->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">
	<div class="row">
		<div class="col-sm-6 offset-sm-3">
			<div class="card">
				<div class="card-body">
					<div class="card-header">
						<h3 class="text-center">Autentikasi</h3>
					</div>

					<!-- Pills navs -->
					<ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
						<li class="nav-item" role="presentation">
							<a class="nav-link active" id="tab-login" data-mdb-toggle="pill" href="#pills-login" role="tab" aria-controls="pills-login" aria-selected="true">Login</a>
						</li>
						<li class="nav-item" role="presentation">
							<a class="nav-link" id="tab-register" data-mdb-toggle="pill" href="#pills-register" role="tab" aria-controls="pills-register" aria-selected="false">Register</a>
						</li>
					</ul>
					<!-- Pills navs -->

					<!-- Pills content -->
					<div class="tab-content">
						<div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
							<?= view('Myth\Auth\Views\_message_block') ?>

							<form action="<?= url_to('login') ?>" method="post">
								<?= csrf_field() ?>

								<?php if ($config->validFields === ['email']) : ?>
									<!-- Email input -->
									<div class="form-outline mb-4">
										<input type="email" id="loginName" name="login" class="form-control" />
										<label class="form-label" for="loginName">Email or username</label>
									</div>
								<?php else : ?>
									<!-- Username input -->
									<div class="form-outline mb-4">
										<input type="text" id="loginName" name="login" class="form-control" />
										<label class="form-label" for="loginName">Email or username</label>
									</div>
								<?php endif; ?>

								<!-- Password input -->
								<div class="form-outline mb-4">
									<input type="password" id="loginPassword" name="password" class="form-control" />
									<label class="form-label" for="loginPassword">Password</label>
								</div>
								<!-- 2 column grid layout -->
								<div class="row mb-4">
									<div class="col-md-6 d-flex justify-content-center">
										<!-- Checkbox -->
										<?php if ($config->allowRemembering) : ?>
											<div class="form-check">
												<label class="form-check-label">
													<input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked <?php endif ?>>
													<?= lang('Auth.rememberMe') ?>
												</label>
											</div>
										<?php endif; ?>
									</div>
									<?php if ($config->activeResetter) : ?>

										<div class="col-md-6 d-flex justify-content-center">
											<!-- Simple link -->
											<a href="<?= url_to('forgot') ?>">Lupa password?</a>
										</div>
									<?php endif ?>
								</div>

								<!-- Submit button -->
								<button type="submit" class="btn btn-primary btn-block mb-4">Masuk</button>

							</form>
						</div>
						<div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="tab-register">
							<?= view('Myth\Auth\Views\_message_block') ?>
							<form action="<?= url_to('register') ?>" method="post">
								<?= csrf_field() ?>

								<!-- Username input -->
								<div class="form-outline mb-4">
									<input type="text" id="registerUsername" name="username" class="form-control" />
									<label class="form-label" for="registerUsername">Username</label>
								</div>

								<!-- Email input -->
								<div class="form-outline mb-4">
									<input type="email" id="registerEmail" name="email" class="form-control" />
									<label class="form-label" for="registerEmail">Email</label>
								</div>

								<!-- Password input -->
								<div class="form-outline mb-4">
									<input type="password" id="registerPassword" name="password" class="form-control" />
									<label class="form-label" for="registerPassword">Password</label>
								</div>

								<!-- Repeat Password input -->
								<div class="form-outline mb-4">
									<input type="password" id="registerRepeatPassword" name="pass_confirm" class="form-control" />
									<label class="form-label" for="registerRepeatPassword">Ulangi password</label>
								</div>

								<!-- Submit button -->
								<button type="submit" class="btn btn-primary btn-block mb-3">Daftar</button>
							</form>
						</div>
					</div>
					<!-- Pills content -->

				</div>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection() ?>