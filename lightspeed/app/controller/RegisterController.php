<?php
//register user class extending functionality of core controller and
class RegisterController extends Controller {

  public function __construct($control_name, $action_name) {
    parent::__construct($control_name, $action_name);
    $this->load_model('Users');
    $this->view->set_layout('default');
  }

  public function login_action($user = '') {
    $validation = new Validate();
    if($_POST) {
      //form validation
      $validation->check($_POST, [
        'uname' => [
          'display' => "Username",
          'required' => true,
          'min' => 8,
          'max' => 32
        ],
        'upass' => [
          'display' => "Password",
          'required' => true,
          'min' => 8,
          'max' => 32
        ],
      ]);
      if($validation->passed()) {
        $user = $this->UsersModel->find_username(Input::get('uname'));
        if($user && password_verify(Input::get('upass'),$user->password)){
          $remem = (isset($_POST['remem']) && Input::get('remem') )? true : false;
          $user->login($remem);
          Router::redirect('');
        } else {
          $validation->add_error("Incorrect username or password.");
        }
      }
    }
    $this->view->display_errors = $validation->display_errors();
    $this->view->render('register/login');
  }

  public function logout_action() {
    if(current_user()) {
      current_user()->logout();
    }
    Router::redirect('register/login');
  }

  public function register_action() {
    //new validation instance
    $validation = new Validate();
    //define and clear post variables on load
    $post_values = ['username'=>'','email'=>'','password'=>'','first_name'=>'','last_name'=>'','passwordMatch'=>''];
    //on submit call validate switch case
    if($_POST) {
      $post_values =  posted_values($_POST);
      $validation->check($_POST,[
        'email'=> [
          'display' => "Email",
          'required' => true,
          'valid_email'=> true,
          'unique' => "users"
        ],
        'username'=> [
          'display' => "Username",
          'required' => true,
          'min' => 8,
          'max' => 32,
          'unique' => "users"
        ],
        'first_name'=> [
          'display' => "First name",
          'required' => true,
          'min' => 2,
          'max' => 32
        ],
        'last_name'=> [
          'display' => "Last name",
          'required' => true,
          'min' => 2,
          'max' => 32
        ],
        'password' => [
          'display' => "Password",
          'required' => true,
          'min' => 6,
          'max' => 32
        ],
        'passwordMatch' => [
          'display' => "Confirm password",
          'required' => true,
          'min' => 6,
          'max' => 32,
          'matches' => "password"
        ]
      ]);

      if($validation->passed()) {
        $new_user = new Users();
        $new_user->reg_new_user($post_values);
        Router::redirect('register/login');
      }

    }
    $this->view->post = $post_values;
    $this->view->display_errors = $validation->display_errors();
    $this->view->render('register/register');
  }
}
