<?php $this->view('includes/header')?>
 
	<div class="container-fluid">

		<form method="post">
		<div class="p-4 mx-auto mr-4 shadow rounded" style="margin-top: 50px;width:100%;max-width: 340px;">
			<h2 class="text-center">Nisala Fashion</h2>
			<img src="<?=ROOT?>/assets/sesami.png" class="border border-primary d-block mx-auto rounded-circle" style="width:100px;height:100px">
			<h3>Add User</h3>

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

			<input class="my-2 form-control" value="<?=get_var('firstname')?>" type="firstname" name="firstname" placeholder="First Name" >
			<input class="my-2 form-control" value="<?=get_var('lastname')?>" type="lastname" name="lastname" placeholder="Last Name" >
			<input class="my-2 form-control" value="<?=get_var('email')?>" type="email" name="email" placeholder="Email" >

			<select class="my-2 form-control" name="gender">
				<option <?=get_select('gender','')?> value="">--Select a Gender--</option>
				<option <?=get_select('gender','male')?> value="male">Male</option>
				<option <?=get_select('gender','female')?> value="female">Female</option>
			</select>

			<?php if($mode == 'teamLeaders'):?>
				<input type="hidden" value="teamLeader" name="rank">
			<?php else:?>
				<select class="my-2 form-control" name="rank">
					<option <?=get_select('rank','')?> value="">--Select a Rank--</option>
					<option <?=get_select('rank','teamLeader')?> value="teamLeader">Team Leader</option>
					<option <?=get_select('rank','dataEntryClerk')?> value="dataEntryClerk">Data Entry Clerk</option>
					<option <?=get_select('rank','manager')?> value="manager">Manager</option>
					<option <?=get_select('rank','head')?> value="head">Head</option>

					<?php if(Auth::getRank() == 'director'):?>
					<option <?=get_select('rank','director')?> value="director">Director</option>
					<?php endif;?>

				</select>
			<?php endif;?>

			<input class="my-2 form-control" value="<?=get_var('password')?>" type="text" name="password" placeholder="Password">
			<input class="my-2 form-control" value="<?=get_var('password2')?>" type="text" name="password2" placeholder="Retype Password">
			<br>
			<button class="btn btn-primary float-end">Add User</button>

			<?php if($mode == 'teamLeaders'):?>
				<a href="<?=ROOT?>/teamLeaders">
					<button type="button" class="btn btn-danger">Cancel</button>
				</a>
			<?php else:?>
				<a href="<?=ROOT?>/users">
					<button type="button" class="btn btn-danger">Cancel</button>
				</a>
			<?php endif;?>
			
		</div>
		</form>
	</div>

<?php $this->view('includes/footer')?>