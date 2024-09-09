<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>
	
<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
    <?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>

    <div class="card-group justify-content-center">
        <form method="post">
            <h3>Add New Product</h3>

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
                <input autofocus class="form-control" value="<?=get_var('product')?>" type="text" name="product" placeholder="Product Name">
            </div>
            <div class="mb-3">
                <input class="form-control" value="<?=get_var('description')?>" type="text" name="description" placeholder="Description">
            </div>
            <div class="mb-3">
                <input class="form-control" value="<?=get_var('bom')?>" type="text" name="bom" placeholder="Bill of Material">
            </div>
            <div class="mb-3">
                <select class="my-2 form-control" name="status">
                    <option <?=get_select('status','')?> value="">--Select a Status--</option>
                    <option <?=get_select('status','Not Started')?> value="Not Started">Not Started</option>
                    <option <?=get_select('status','on-going')?> value="On-Going">On-Going</option>
                    <option <?=get_select('status','finished')?> value="Finished">Finished</option>
                </select>
            </div>

            <input class="btn btn-primary float-end" type="submit" value="Create">

            <a href="<?=ROOT?>/products">
                <input class="btn btn-danger" type="button" value="Cancel">
            </a>
        </form>
    </div>
</div>

<?php $this->view('includes/footer')?>
