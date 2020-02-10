<?php

class RestrictedController extends Controller {
    public function __construct($control_name, $action_name) {
    parent::__construct($control_name, $action_name);
  }

  public function index_action() {
    $this->view->render('restricted/index');
  }
}
