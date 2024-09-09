<style>
	nav ul li a{
		width: 110px;
    text-align: center;
    border-left: solid thin #eee;
    border-right: solid thin #fff;
	}
  nav ul li a:hover{
    background-color: grey;
    color: white !important;
  }

  .active-nav{
    background-color: #1c77fd;
    color: white !important;
  }
</style>
<nav class="main-nav navbar navbar-expand-lg navbar-light bg-light p-2">
  <a class="navbar-brand" href="<?=ROOT?>">
  	<img src="<?=ROOT?>/assets/sesami.png" class="rounded-circle" style="width:45px;height:45px">
  		<?=Auth::getFactory_name()?>
	</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link <?=($this->controller_name() == 'Home') ? ' active-nav ':''?> " href="<?=ROOT?>">DASHBOARD</a>
      </li>

      <?php if(Auth::access('director')):?>
        <li class="nav-item">
          <a class="nav-link <?=($this->controller_name() == 'Factories') ? ' active-nav ':''?> " href="<?=ROOT?>/factories">FACTORIES</a>
        </li>
      <?php endif;?>

      <?php if(Auth::access('teamLeader')):?>
      <li class="nav-item" style="position: relative;">
        <a class="nav-link <?=($this->controller_name() == 'Tests') ? ' active-nav ':''?> " href="<?=ROOT?>/tests">QUALITY CHECK

          <?php  
              $unsubmitted_count = get_unsubmitted_tests();
            ?>
            <?php if($unsubmitted_count):?>
              <span class="badge bg-danger text-white" style="position: absolute;top:0px;right:0px"><?=$unsubmitted_count?></span>
            <?php endif;?>
        </a>
      </li>
      <?php endif;?>
      
      <?php if(Auth::access('manager')):?>
        <li class="nav-item" style="position: relative;">
          <a class="nav-link <?=($this->controller_name() == 'To_mark') ? ' active-nav ':''?> " href="<?=ROOT?>/to_mark">TO CHECK
            <?php  
              $to_mark_count = (new Tests_model())->get_to_mark_count();
            ?>
            <?php if($to_mark_count):?>
              <span class="badge bg-danger text-white" style="position: absolute;top:0px;right:0px"><?=$to_mark_count?></span>
            <?php endif;?>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?=($this->controller_name() == 'Marked') ? ' active-nav ':''?> " href="<?=ROOT?>/marked">CHECKED</a>
        </li>
      <?php endif;?>
      
    </ul>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?=Auth::getFirstname()?>
        </a>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="<?=ROOT?>/profile">Profile</a>
          <a class="dropdown-item" href="<?=ROOT?>">Dashboard</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?=ROOT?>/logout">Logout</a>
        </div>
      </li>

    </ul>

      <form class="form-inline">
        <div class="input-group">

          <?php $years = get_years()?>
          <select name="factory_year" class="form-select" style="max-width:100px">
            <option><?=get_var('factory_year',!empty($_SESSION['FACTORY_YEAR']->year) ? $_SESSION['FACTORY_YEAR']->year : date("Y",time()),"get")?></option>
            <?php foreach ($years as $year): ?>
              <option><?=$year?></option>
            <?php endforeach ?>
           </select>

           <?=add_get_vars()?>
           
          <div class="input-group-prepend">
            <button class="input-group-text" id="basic-addon1">&nbsp<i class="fa fa-chevron-right"></i></button>
          </div>
        </div>
      </form>

  </div>

</nav>


