<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>
	
	<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
		<?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>

		<?php if($row && $answered_test_row && $answered_test_row->submitted):?>

		<div class="row">
	 	<center><h4><?=esc(ucwords($row->test))?></h4></center>
	 	<center class="row">

	 		<h5 class="col">Team:
	 			<a href="<?=ROOT?>/single_team/<?=$row->team_id?>?tab=students">
	 				<?=$row->team->team?>
	 			</a> 
	 		</h5>
	 		
	 		<h5 class="col">Team Leader:
	 			<a href="<?=ROOT?>/profile/<?=$teamLeader_row->user_id?>?tab=tests">
	 				<?=$teamLeader_row->firstname?> <?=$teamLeader_row->lastname?>
	 			</a> 
	 		</h5>
	 	</center>

			<table class="table table-hover table-striped table-bordered">
				<tr>
					<th>Created by:</th>
					<td>
						<a href="<?=ROOT?>/profile/<?=$row->user->user_id?>?tab=tests">
							<?=esc($row->user->firstname)?> <?=esc($row->user->lastname)?>
						</a>
					</td>
					<th>Date Created:</th><td><?=get_date($row->date)?></td>
				 
				</tr>

				<?php $active = $row->disabled ? "No":"Yes";?>
				<tr>
					<td><b>Team:</b> <?=$row->team->team?></td>
					<td colspan="5"><b>Quality Check Description:</b><br><?=esc($row->description)?></td></tr>
			</table>
			<a href="<?=ROOT?>/make_pdf/<?=$row->test_id?>/<?=$teamLeader_row->user_id?>?type=test">
			<button class="btn btn-primary float-end">Save as PDF</button>
			</a>
 		</div>
 		 
		
		 		<?php

		 			switch ($page_tab) {
		 				case 'view':
		 					// code...
		 					include(views_path('marked-single-tab-view'));
		 					break;
 		 	 
		 				
		 				default:
		 					// code...
		 					break;
		 			}


		 		?>
		 
		<?php else:?>
			<center><h4>That Quality Check was not found!</h4></center>
		<?php endif;?>

	</div>

<?php $this->view('includes/footer')?>
