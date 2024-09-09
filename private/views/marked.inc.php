<div class="card-group justify-content-center">

<div class="table-responsive container-fluid p-0" >
	<table class="table table-striped table-hover">
		<tr><th></th><th>Quality Check</th><th>Team Leader</th><th>Date Submitted</th><th>Supervised by</th><th>Date Checked</th>
			<th>Checked</th>
			<th>Satisfaction</th>
			<th></th>
		</tr>
		<?php if(isset($test_rows) && $test_rows):?>
			 
			<?php foreach ($test_rows as $test_row):?>
			 
			 <tr>
			 	<td>
			 	
			 	</td>
			 	<td><?=$test_row->test_details->test?></td>
			 	<td><?=$test_row->user->firstname?> <?=$test_row->user->lastname?></td>
			 	<td><?=get_date($test_row->submitted_date)?></td>

			 	<td>

			 		<?php
			 			$user = new User();
			 			$my_marker = $user->first('user_id',$test_row->marked_by);
			 			if($my_marker){
			 				echo $my_marker->firstname . ' ' . $my_marker->lastname;
			 			}
			 		?>
			 		
			 	</td>
			 	<td><?=get_date($test_row->marked_date)?></td>

			 	<td>
			 		<?php
			 			$percentage = get_answer_percentage($test_row->test_id,$test_row->user_id);
			 		?>
 					<?=$percentage?>%
			 	</td>
			 	<td>
			 		<?= get_score_percentage($test_row->test_details->test_id,$test_row->user->user_id)?>%
			 	</td>
				<td>
			  
			 		<a href="<?=ROOT?>/marked_single/<?=$test_row->test_id?>/<?=$test_row->user->user_id?>">
			 			<button class="btn btn-sm btn-primary">View <i class="fa fa-chevron-right"></i></button>
			 		</a>

			 	</td>

			 </tr>

 			<?php endforeach;?>
			<?php else:?>
				<tr><td colspan="10"><center>No Quality Check were found at this time.</center></td></tr>
			<?php endif;?>

	</table>
</div>
</div>