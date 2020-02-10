<?php
//dump and die, development only function
  function dnd($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
  }
//escape special characters
  function sanitize($dirty) {
    return htmlentities($dirty, ENT_QUOTES, 'UTF-8');
  }
//return current user from anywhere in application
  function current_user() {
    return Users::current_logged_user();
  }

  function posted_values($post) {
    $clean_array=[];
    foreach($post as $key => $value) {
      $clean_array[$key] = sanitize($value);
    }
    return $clean_array;
  }

  function get_action($action_name) {
    $a = explode('_',$action_name);
    $action = $a[0];
    return $action;
  }

  function current_page() {
    $current_page = $_SERVER['REQUEST_URI'];
    if($current_page == SROOT || $current_page == SROOT.'home/index'){
      $current_page = SROOT.'home';
    }
    return $current_page;
  }
