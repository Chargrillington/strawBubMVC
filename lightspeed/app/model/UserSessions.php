<?php

class UserSessions extends Model {
  public function __construct() {
    $table = 'user_sessions';
    parent::__construct($table);
  }

  public static function get_from_cookie() {
    $user_session = new self();
    if(Cookie::exists(REMEMBER_ME_COOKIE_NAME)){  
      $user_session = $user_session->find_first([
        'conditions' => "user_agent = ? AND session = ?",
        'bind' => [Session::uagent_no_version(),Cookie::get(REMEMBER_ME_COOKIE_NAME)]
      ]);
    }
    if(!$user_session) return false;
    return $user_session;
  }
}
