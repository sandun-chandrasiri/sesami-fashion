<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>
	
<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
    <?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>

    <div class="card-group justify-content-center">
        <form method="post">
            <h3>Add New Item</h3>

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
                <input autofocus class="form-control" value="<?=get_var('inventory')?>" type="text" name="inventory" placeholder="Inventory Name">
            </div>
            <div class="mb-3">
                <input class="form-control" value="<?=get_var('description')?>" type="text" name="description" placeholder="Description">
            </div>
            <div class="mb-3">
                <input class="form-control" value="<?=get_var('quantity')?>" type="text" name="quantity" placeholder="Quantity">
            </div>
            <div class="mb-3">
                <select class="my-2 form-control" name="type">
                <option <?=get_select('type','')?> value="">--Select a Type--</option>
                <option <?=get_select('type','Fixed Asset')?> value="Fixed Asset">Fixed Asset</option>
                <option <?=get_select('type','Other')?> value="Other">Other</option>
            </div>
            <input class="btn btn-primary float-end" type="submit" value="Create">

            <a href="<?=ROOT?>/inventory">
                <input class="btn btn-danger" type="button" value="Cancel">
            </a>
        </form>
    </div>
</div>

<?php $this->view('includes/footer')?>
