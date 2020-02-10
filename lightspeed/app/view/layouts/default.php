<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X_UA_Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$this->sitle();?></title>
    <link rel="stylesheet" href="<?=SROOT;?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=SROOT;?>css/lightspeed.css">
    <script src="<?=SROOT;?>js/jQuery-3.4.1.min.js"></script>
    <script src="<?=SROOT;?>js/bootstrap.min.js"></script>
    <?=$this->content('head');?>
  </head>
  <body>
    <?php include 'main_menu.php' ?>
    <div class="container-fluid frame">
    <?=$this->content('body');?>
    </div>
  </body>
</html>
