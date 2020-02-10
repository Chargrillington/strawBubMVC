<?php

  class ToolsController extends Controller {
    public function __contruct($control_name, $action_name) {
      parent::__construct($control_name, $action_name);
      $this->view->set_layout('default');
    }

    public function index_action() {
      $this->view->render('tools/index');
    }

    public function first_action() {
      $this->view->render('tools/first');
    }

    public function second_action() {
      $this->view->render('tools/second');
    }

    public function third_action() {
      $this->view->render('tools/third');
    }

  }
