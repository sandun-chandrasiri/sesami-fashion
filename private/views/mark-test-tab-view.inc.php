
<?php $percentage = get_answer_percentage($row->test_id,$user_id)?>
<?php $marked_percentage = get_mark_percentage($row->test_id,$user_id)?>

<div class="container-fluid text-center">
	<div class="text-danger"><?=$percentage?>% Checked by the Team Leader</div>
	<div class="bg-primary" style="width: <?=$percentage?>%;height: 5px;"></div>

	<div class="text-danger"><?=$marked_percentage?>% Supervised by the Manager</div>
	<div class="bg-primary" style="width: <?=$marked_percentage?>%;height: 5px;"></div>
	
	<?php if($answered_test_row):?>
		<?php if($answered_test_row->submitted && !$marked):?>
			<div class="text-success">This Quality Check has been submitted</div>
			<a onclick="unsubmit_test(event)" href="<?=ROOT?>/mark_test/<?=$row->test_id?>/<?=$answered_test_row->user_id?>/?unsubmit=true">
				<button class="btn mx-1 btn-danger float-end">unSubmit Test</button>
			</a>
			<a onclick="set_test_as_marked(event)" href="<?=ROOT?>/mark_test/<?=$row->test_id?>/<?=$answered_test_row->user_id?>/?set_marked=true">
				<button class="btn mx-1 btn-secondary float-end">Set Quality Check as Marked</button>
			</a>
			
			<a onclick="auto_mark(event)" href="<?=ROOT?>/mark_test/<?=$row->test_id?>/<?=$answered_test_row->user_id?>/?auto_mark=true">
				<button class="btn mx-1 btn-warning float-end">Auto mark</button>
			</a>
			

		<?php endif;?>

	<?php endif;?>

</div>

<?php if($marked):?>
<center>
	<?php $score_percentage = get_score_percentage($row->test_id,$user_id)?>
	<small style="font-size:20px">Quality Check Satisfaction:<br></small> <div style="font-size: 60px;margin-top: -20px;"><?=$score_percentage?>%</div>
</center>
<?php endif;?>

<nav class="navbar">
	<center>
		<h5>Quality Check Criteria</h5>
		<p><b>Total Number of Criteria:</b> <?=$total_questions?></p>
	</center>
 
</nav>

<hr>

<?php if(isset($questions) && is_array($questions)):?>

<form method="post">

	<?php $num = $pager->offset;; ?>
	<?php foreach($questions as $question): $num++?>

	    	<?php  

	    		$myanswer = get_answer($saved_answers,$question->id);
	    		$mymark = get_answer_mark($saved_answers,$question->id);
	    	?>
 
		<div class="card mb-4 ">
		  <div class="card-header">
		    <span  class="bg-primary p-1 text-white rounded">Check #<?=$num?></span> <span class="badge bg-primary float-end p-2"><?=date("F jS, Y H:i:s a",strtotime($question->date))?></span>
		  </div>
		  <div class="card-body">
		    <h5 class="card-title"><?=esc($question->question)?></h5>

		    <?php if(file_exists($question->image)):?>
		    	<img src="<?=ROOT . '/'.$question->image?>" style="width:50%">
		  	<?php endif;?>

		    <p class="card-text"><?=esc($question->comment)?></p>
			  <?php
			  	$type = '';
			  ?>

		    	<?php if($question->question_type == 'objective'):
		    		$type = '?type=objective';
		    	?>
		    	
		    	<?php endif;?>

		    	<?php if($question->question_type == 'multiple'):
		    		$type = '?type=multiple';
		    	?>

		    		<div class="card" style="width: 18rem;">
						  <div class="card-header">
						    Select your choice
						  </div>
						  <ul class="list-group list-group-flush">

						  	<?php $choices = json_decode($question->choices);?>
						  	<?php foreach($choices as $letter => $answer):?>
						    	<li class="list-group-item"><?=$letter?>: <?=$answer?> 

							    	<?php if($myanswer == $letter):?>
							    		<i class="fa fa-check float-end"></i>
							    	<?php endif;?>
						    </li>
						    <?php endforeach;?>

 						  </ul>
						</div>

						<hr>
		  				Manager's remark:
		  				<?php if(!$marked):?>
			  				<div class="form-check">
							  <input <?=($mymark == 1) ? ' checked ':''?>  class="form-check-input" type="radio" name="<?=$question->id?>" value="1" id="flexRadioDefaultcorrect<?=$num?>">
							  <label class="form-check-label" for="flexRadioDefaultcorrect<?=$num?>">
							    Correct
							  </label>
							</div>
							<div class="form-check">
							  <input <?=($mymark == 2) ? ' checked ':''?>  class="form-check-input" type="radio" name="<?=$question->id?>" value="2" id="flexRadioDefaultwrong<?=$num?>">
							  <label class="form-check-label" for="flexRadioDefaultwrong<?=$num?>">
							    Wrong
							  </label>
							</div>
		    			<?php else:?>
		    				<div style="font-size: 45px;">
		    					<?=($mymark == 1) ? '<i class="fa fa-check float-end"></i>':'<i class="fa fa-times float-end"></i>'?>
		    				</div>
		    			<?php endif;?>

		    	<?php endif;?>

		    <?php if($question->question_type != 'multiple'):?>
  				<div>Team Leader's Input: <?=$myanswer?></div>
  				<hr>
  				Manager's remark:
  				<?php if(!$marked):?>
	  				<div class="form-check">
					  <input <?=($mymark == 1) ? ' checked ':''?> class="form-check-input" type="radio" name="<?=$question->id?>" value="1" id="flexRadioDefaultcorrect<?=$num?>">
					  <label class="form-check-label" for="flexRadioDefaultcorrect<?=$num?>">
					    Correct
					  </label>
					</div>
					<div class="form-check">
					  <input <?=($mymark == 2) ? ' checked ':''?> class="form-check-input" type="radio" name="<?=$question->id?>" value="2" id="flexRadioDefaultwrong<?=$num?>">
					  <label class="form-check-label" for="flexRadioDefaultwrong<?=$num?>">
					    Wrong
					  </label>
					</div>
				<?php else:?>
	    				<div style="font-size: 45px;">
	    					<?=($mymark == 1) ? '<i class="fa fa-check float-end"></i>':'<i class="fa fa-times float-end"></i>'?>
	    				</div>
  				<?php endif;?>

  			<?php endif;?>
		  </div>
		 
		</div>
	<?php endforeach;?>

	<?php if(!$marked):?>
		<center>
			<small>Click save remarks before moving to another page to save</small><br>
			<button class="btn btn-primary">Save Marks</button>
		</center>
		</form>
	<?php endif;?>
<?php endif;?>

<?php $pager->display()?>

<script>
	
	function unsubmit_test(e)
	{

		if(!confirm("Are you sure you want to remove this Quality Check from the submission list!?")){
			e.preventDefault();
			return;
		}
 
	}


	function auto_mark(e)
	{
		if(!confirm("This action may override any custom remarks you have saved. Are you sure you want to auto remark this Quality criteria?!")){
			e.preventDefault();
			return;
		}
	}

	function set_test_as_marked(e)
	{
		var percent = <?=$marked_percentage?>;

		if(percent < 100){
			e.preventDefault();
			alert("You have only remarked "+percent+"% of the Quality criteria. You can only set a Quality Check as supervised after remarking all Quality criteris");
			return;
		}
		if(!confirm("You won't be able to remark Quality criteris after this action. continue?!")){
			e.preventDefault();
			return;
		}
	}

</script>

