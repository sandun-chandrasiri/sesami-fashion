<div class="card-group justify-content-center">
	<div id="chart_div" style="width: 100%; height: 400px;"></div>
	<table class="table table-striped table-hover">
		<tr><th></th><th>Month</th><th>Units used</th>
			<th>
				
			</th>
		</tr>
		<?php if(isset($rows) && $rows):?>
			 
			<?php foreach ($rows as $row):?>
			 
			 <tr>
			 	<td>
			 		<a href="">
			 			<button class="btn btn-sm btn-primary"><i class="fa fa-chevron-right"></i></button>
			 		</a>
			 	</td>
			 	<td><?=$row->month?></td><td><?=$row->units?></td>

			 	<td>
			 		<?php if(Auth::access('dataEntryClerk')):?>
				 		<a href="<?=ROOT?>/electricity/edit/<?=$row->id?>">
				 			<button class="btn-sm btn btn-info text-white"><i class="fa fa-edit"></i></button>
				 		</a>

				 		<a href="<?=ROOT?>/electricity/delete/<?=$row->id?>">
				 			<button class="btn-sm btn btn-danger"><i class="fa fa-trash-alt"></i></button>
				 		</a>
				 	<?php endif;?>
			 	</td>

			 </tr>

 			<?php endforeach;?>
			<?php else:?>
				<tr><td colspan="5"><center>No electricity usage records were found at this time</center></td></tr>
			<?php endif;?>

	</table>
	
</div>   