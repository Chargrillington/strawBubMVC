<?php

class Users extends Model {
  private $_logged_in, $_session_name, $_cookie_name;
  public static $current_user = null;



  public function __construct($user='') {
    $table='users';

    parent::__construct($table);
    $this->_session_name = CURRENT_USER_SESSION_NAME;
    $this->_cookie_name = REMEMBER_ME_COOKIE_NAME;
    $this->_archived = true;
    if($user !='') {
      if(is_int($user)) {
        $u = $this->_db->find_first($table,[
          'conditions'=>'id = ?',
          'bind'=>[$user]
        ]);
      } else {
        $u = $this->_db->find_first($table,[
          'conditions'=>'username = ?',
          'bind'=>[$user]
        ]);
      }
      if($u) {
        foreach($u as $key => $val) {
          $this->$key=$val;
        }
      }
    }
  }
  public function find_username($username) {
    return $this->find_first(['conditions'=>'username = ?','bind'=>[$username]]);
  }

  public static function current_logged_user() {
    if(!isset(self::$current_user) && Session::exists(CURRENT_USER_SESSION_NAME)) {
      $u = new Users((int)Session::get(CURRENT_USER_SESSION_NAME));
      self::$current_user = $u;
    }
  return self::$current_user;
  }


  public function login($remem=false) {
    Session::set($this->_session_name, $this->id);
    if ($remem) {
      $hash = md5(uniqid());
      $user_agent = Session::uagent_no_version();
      Cookie::set($this->_cookie_name, $hash, REMEMBER_ME_COOKIE_EXPIRY);
      $fields = ['session'=>$hash, 'user_agent'=>$user_agent, 'user_id'=>$this->id];
      $this->_db->query("DELETE FROM user_sessions WHERE user_id = ? AND user_agent = ?",[$this->id, $user_agent]);
      $this->_db->insert("user_sessions", $fields);
    }
  }

  public static function user_login_cookie() {
    $user_session = UserSessions::get_from_cookie();
    if($user_session->user_id != '') {
      $remem = true;
      $user = new self((int)$user_session->user_id);
    }
    if($user) {
      $user->login($remem);
      return $user;
    }
  }

  public function logout() {
    $user_session = UserSessions::get_from_cookie();
    if($user_session) $user_session->delete();
    $result = $this->_db->query("DELETE FROM user_sessions WHERE user_id = ? AND user_agent = ?",[$this->id, $user_agent]);
    Session::delete(CURRENT_USER_SESSION_NAME);
    if(Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
     Cookie::delete(REMEMBER_ME_COOKIE_NAME);
    }
    self::$current_user = null;
    return true;
  }

  public function reg_new_user($params) {
    $this->assign($params);
    $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    $this->save();
  }

  public function acls() {
    if(empty($this->acl)) return [];
    return json_decode($this->acl, true);
  }
}
