<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>

<style>
	h1{
		font-size: 80px;
		color: limegreen;
	}

	a{
		text-decoration: none;
	}

	.card-header{
		font-weight: bold;
	}

	.card{
		min-width: 250px;
	}
</style>

	<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
		<?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>
	 
	 	<div class="row justify-content-center ">

		 	<?php if(Auth::access('head')):?>

		 		<div class="card col-3 shadow rounded m-4 p-0 border">
	 				<a href="<?=ROOT?>/credits">
		 			<div class="card-header text-center">Credits</div>
		 			<h1 class="text-center">
		 				<img src="<?=ROOT?>/assets/credit.png" class="border border-primary" style="width:248px; height:150px">
		 			</h1>
		 			<div class="card-footer text-center">View Credit Details</div>
	 				</a>
		 		</div>
		 		
		 	<?php endif;?>

		 	<?php if(Auth::access('head')):?>
		 		<div class="card col-3 shadow rounded m-4 p-0 border">
	 				<a href="<?=ROOT?>/debits">
		 			<div class="card-header text-center">Debits</div>
		 			<h1 class="text-center">
		 				<img src="<?=ROOT?>/assets/debit.jpeg" class="border border-primary" style="width:248px; height:150px">
		 			</h1>
		 			<div class="card-footer text-center">View Debit Details</div>
		 			</a>
		 		</div>

		 	<?php endif;?>

		 	<div style="text-align: center; margin-top: 20px; font-weight: bold; font-size: 18px;">
			    
			</div>

			<div class="col-md-3 col-md-offset-2">
                <div class="panel shadow rounded m-10 p-2 border" style="height: 200px;background: #005577">
                    <div class="panel-body">
                    	<h4 class="h4" align="center" style="color: #FFF">Total Receivable Amount:</h4>
                    	<br/>
                    	<h1 align="center" class="h1" style="color: #FFF">LKR <?= $totalReceivableAmount ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel shadow rounded m-10 p-2 border" style="height: 200px;background: #005577">
                    <div class="panel-body">
                        <h4 class="h4" align="center" style="color: #FFF">Total Received Amount:</h4>
                        <br/>
                        <h1 align="center" class="h1" style="color: #FFF">LKR <?= $totalReceivedAmount ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-md-offset-2">
                <div class="panel shadow rounded m-10 p-2 border" style="height: 200px;background: #005577">
                    <div class="panel-body">
                    	<h4 class="h4" align="center" style="color: #FFF">Total Payable Amount:</h4>
                    	<br/>
                    	<h1 align="center" class="h1" style="color: #FFF">LKR <?= $totalPayableAmount ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel shadow rounded m-10 p-2 border" style="height: 200px;background: #005577">
                    <div class="panel-body">
                        <h4 class="h4" align="center" style="color: #FFF">Total Paid Amount:</h4>
                        <br/>
                        <h1 align="center" class="h1" style="color: #FFF">LKR <?= $totalPaidAmount ?></h1>
                    </div>
                </div>
            </div>


	 	</div>
	</div>
 
<?php $this->view('includes/footer')?>
