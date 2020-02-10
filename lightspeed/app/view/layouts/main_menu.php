<?php
  //call get menu functon in Router to decode acl_menu_json
  $menu = Router::get_menu('menu_acl');
  $current_page = current_page();
?>
<nav class="navbar navbar-expand-lg navbar-light">
  <a class="navbar-brand" href="#"><span class="impact">Strawberry&nbsp;</span>Bubblegum</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_menu" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="main_menu">
    <ul class="navbar-nav">
      <?php foreach($menu as $key => $val):
            $active = '';
            if(is_array($val)): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?=$key?><span class="caret">
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <?php foreach($val as $k => $v):
                            $active = ($v == $current_page)? ' active':'';?>
                      <?php if($k == 'seperator'): ?>
                            <a role="seperator" class="divider"></a>
                      <?php else: ?>
                        <a class="dropdown-item <?=$active?>" href="<?=$v?>"><?=$k?></a>
                      <?php endif; ?>
                      <?php endforeach; ?>
              </div>
            </li>
      <?php else:
        $active = ($val == $current_page) ? 'active':'';?>
        <li class="nav-item"><a class="nav-link <?=$active?>" href="<?=$val?>"><?=$key?></a></li>
      <?php endif; ?>
      <?php endforeach; ?>
    </ul>
    <ul class="navbar-nav greeting">
      <?php if(current_user()): ?>
        <li class="nav-item"><a href="#">Hello <?=current_user()->first_name?></a></li>
      <?php endif;?>
    </ul>
  </div>
</nav>
