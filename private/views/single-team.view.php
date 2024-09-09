<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>
	
	<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
		<?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>

		<?php if($row):?>
 
		<div class="row">
	 	<center><h4><?=esc(ucwords($row->team))?></h4></center>
			<table class="table table-hover table-striped table-bordered">
				<tr><th>Created by:</th><td><?=esc($row->user->firstname)?> <?=esc($row->user->lastname)?></td>
				<th>Date Created:</th><td><?=get_date($row->date)?></td></tr>

			</table>
 		</div>
 		 
			<ul class="nav nav-tabs">
				<?php if(Auth::access('manager')):?>

				  <li class="nav-item">
				    <a class="nav-link <?=$page_tab=='managers'?'active':'';?> " href="<?=ROOT?>/single_team/<?=$row->team_id?>?tab=managers">Managers</a>
				  </li>
				<?php endif;?>

			  <li class="nav-item">
			    <a class="nav-link <?=$page_tab=='teamLeaders'?'active':'';?> " href="<?=ROOT?>/single_team/<?=$row->team_id?>?tab=teamLeaders">Team Leaders</a>
			  </li>

			  <?php if(Auth::access('manager')):?>
				  <li class="nav-item">
				    <a class="nav-link <?=$page_tab=='tests'?'active':'';?> " href="<?=ROOT?>/single_team/<?=$row->team_id?>?tab=tests">Quality Checks</a>
				  </li>
		 		<?php endif;?>

			</ul>

			

		 		<?php

		 			switch ($page_tab) {
		 				case 'managers':
		 					// code...
		 					if(Auth::access('manager')){
		 						include(views_path('team-tab-managers'));
		 					}else{
		 						include(views_path('access-denied'));
		 					}
		 					break;

		 				case 'teamLeaders':
		 					// code...
		 					include(views_path('team-tab-teamLeaders'));
		 					break;

		 				case 'tests':
		 					// code...
		 					if(Auth::access('manager')){
		 						include(views_path('team-tab-tests'));
		 					}else{
		 						include(views_path('access-denied'));
		 					}
		 					break;

		 				case 'test-add':
		 					// code...
		 					if(Auth::access('manager')){
		 						include(views_path('team-tab-test-add'));
		 					}else{
		 						include(views_path('access-denied'));
		 					}

		 					break;

		 				case 'test-edit':
		 					// code...
		 					include(views_path('team-tab-test-edit'));
		 					break;

		 				case 'test-delete':
		 					// code...
		 					include(views_path('team-tab-test-delete'));
		 					break;

		 					
		 				case 'manager-add':
		 					// code...
		 					if(Auth::access('manager')){
		 						include(views_path('team-tab-managers-add'));
			 				}else{
		 						include(views_path('access-denied'));
		 					}

		 					break;
		 				case 'teamLeader-add':
		 					// code...
		 					if(Auth::access('manager')){
		 						include(views_path('team-tab-teamLeaders-add'));
			 				}else{
		 						include(views_path('access-denied'));
		 					}

		 					break;
		 					
		 				case 'manager-remove':
		 					// code...
		 					include(views_path('team-tab-managers-remove'));

		 					break;
		 				case 'teamLeader-remove':
		 					// code...
		 					if(Auth::access('manager')){
		 						include(views_path('team-tab-teamLeaders-remove'));
		 					}else{
		 						include(views_path('access-denied'));
		 					}


		 					break;
		 					
		 				case 'teamLeaders-add':
		 					// code...
		 					if(Auth::access('manager')){
		 						include(views_path('team-tab-teamLeaders-add'));
		 					}else{
		 						include(views_path('access-denied'));
		 					}

		 					break;
		 				case 'tests-add':
		 					// code...
		 					include(views_path('team-tab-tests-add'));

		 					break;
		 				
		 				default:
		 					// code...
		 					break;
		 			}


		 		?>
		 
		<?php else:?>
			<center><h4>That team was not found!</h4></center>
		<?php endif;?>

	</div>

<?php $this->view('includes/footer')?>
