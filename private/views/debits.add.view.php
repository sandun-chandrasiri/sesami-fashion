<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>
	
<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
    <?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>

    <div class="card-group justify-content-center">
        <form method="post">
            <h3>Add New Debit record</h3>

            <?php if(count($errors) > 0):?>
            <div class="alert alert-warning alert-dismissible fade show p-1" role="alert">
                <strong>Errors:</strong>
                <?php foreach($errors as $error):?>
                    <br><?=$error?>
                <?php endforeach;?>
                <span type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </span>
            </div>
            <?php endif;?>

            <div class="mb-3">
                <input autofocus class="form-control" value="<?=get_var('name')?>" type="text" name="name" placeholder="Name">
            </div>
            <div class="mb-3">
                <input class="form-control" value="<?=get_var('description')?>" type="text" name="description" placeholder="Description">
            </div>
            <div class="mb-3">
                <input class="form-control" value="<?=get_var('amount')?>" type="text" name="amount" placeholder="Amount">
            </div>
            <div class="mb-3">
                <select class="my-2 form-control" name="status">
                    <option <?=get_select('status','')?> value="">--Select a Status--</option>
                    <option <?=get_select('status','Paid')?> value="Paid">Paid</option>
                    <option <?=get_select('status','Payable')?> value="Payable">Payable</option>
                </select>
            </div>

            <input class="btn btn-primary float-end" type="submit" value="Create">

            <a href="<?=ROOT?>/debits">
                <input class="btn btn-danger" type="button" value="Cancel">
            </a>
        </form>
    </div>
</div>

<?php $this->view('includes/footer')?>
