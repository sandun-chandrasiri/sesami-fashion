<?php $this->view('includes/header')?>
	
	<div class="container-fluid">
		
	<form method="post">
		<div class="p-4 mx-auto mr-4 shadow rounded" style="margin-top: 50px;width:100%;max-width: 340px;">
			<h2 class="text-center">Nisala Fashion</h2>
			<img src="<?=ROOT?>/assets/sesami.png" class="border border-primary d-block mx-auto rounded-circle" style="width:100px;height:100px">
			<h3>Login</h3>
			<br>

			<?php if(count($errors) > 0):?>
			<div class="alert alert-warning alert-dismissible fade show p-1" role="alert">
			  <strong>Errors:</strong>
			   <?php foreach($errors as $error):?>
			  	<br><?=$error?>
			  <?php endforeach;?>
			  <span  type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </span>
			</div>
			<?php endif;?>
			
			<input class="form-control" value="<?=get_var('email')?>" type="email" name="email" placeholder="Email" autofocus autocomplete="off">
			<br>
			<input class="form-control" value="<?=get_var('password')?>" type="password" name="password" placeholder="Password">
			<br>
			<div class="d-flex justify-content-between align-items-center">
                <button class="btn btn-primary">Login</button>
                <p class="text-start mb-0">Forgot Password?</p>
            </div>
		</div>
	</form>
	</div>

<?php $this->view('includes/footer')?>