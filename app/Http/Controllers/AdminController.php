<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class Admin extends Controller { 

    function __construct() {
        $this->user = $this->model('User');
    }

    function index() {
        $this->redirect('admin/login');
    }

    function login() {
        if ($this->user->isLoggedIn()) {
            $this->redirect('dashboard');
            return;
        }
        if (isset($_POST['username'], $_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $result = $this->user->doLogin($username, $password);
            switch($result) {
                case 0:
                    $this->view('view_login', ['error' => 'Username not found.']);
                    break;
                case 1:
                    $this->view('view_login', ['error' => 'Wrong password.']);
                    break;
                default:
                    if (isset($result['id'], $result['role'])) {
                        $session = array(
                            'id' => $result['id'],
                            'role' => $result['role']
                        );
                        foreach($session as $key => $value) {
                            $_SESSION[$key] = $value;
                        }
                        $this->redirect('dashboard');
                        break;
                    }
                    $this->view('view_login');
                    break;
            }
        }
        $this->view('view_login');
    }

    function logout() {
        if (isset($_SESSION['id'], $_SESSION['role'])) {
            session_destroy();
            $this->redirect('auth/login');
            return;
        }
    }
}