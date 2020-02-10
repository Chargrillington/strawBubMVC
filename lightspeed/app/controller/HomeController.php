<?php

class HomeController extends Controller {
  public function __construct($control_name, $action_name) {
    parent::__construct($control_name, $action_name);
  }
// call index action on home page visit
  public function index_action(){
    $this->view->render('home/index');
  }
}
