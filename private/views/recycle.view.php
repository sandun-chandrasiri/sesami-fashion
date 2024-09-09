<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>
	
	<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
		<?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>

		<h5>Recycle</h5>
 		<nav class="navbar navbar-light bg-light">
		  <form class="form-inline">
		    <div class="input-group">
		      <div class="input-group-prepend">
		        <button class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i>&nbsp</button>
		      </div>
		      <input name="find" value="<?=isset($_GET['find'])?$_GET['find']:'';?>" type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
		    </div>
		  </form>
 				<?php if(Auth::access('dataEntryClerk')):?>
 					<div style="justify-content-end;">
 						<!-- <?php var_dump($_SESSION);?> -->
 						<a href="<?= ROOT ?>/Recycle_pdf/">
 							<!-- <?= var_dump($rows)?> -->
							<button class="btn btn-sm btn-success">Print</button>
						</a>
						<a href="<?=ROOT?>/recycle/add">
							<button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>Add New</button>
						</a>
 					</div>
				<?php endif;?>
 		</nav>

		<?php include(views_path('recycle'))?>

		<?php $pager->display()?>
 
	</div>
 
<?php $this->view('includes/footer')?>