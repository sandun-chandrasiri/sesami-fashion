<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>
	
<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
    <?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>

    <div class="card-group justify-content-center">
        <form method="post">
            <h3>Add New Customer</h3>

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
                <input autofocus class="form-control" value="<?=get_var('customer')?>" type="text" name="customer" placeholder="Customer Name">
            </div>
            <div class="mb-3">
                <input class="form-control" value="<?=get_var('address')?>" type="text" name="address" placeholder="Address">
            </div>
            <div class="mb-3">
                <input class="form-control" value="<?=get_var('contact')?>" type="text" name="contact" placeholder="Contact Number">
            </div>

            <input class="btn btn-primary float-end" type="submit" value="Create">

            <a href="<?=ROOT?>/customers">
                <input class="btn btn-danger" type="button" value="Cancel">
            </a>
        </form>
    </div>
</div>

<?php $this->view('includes/footer')?>
