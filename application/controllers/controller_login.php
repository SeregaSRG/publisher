<?php
class Controller_Login extends Controller
{
    function __construct()
    {
        $this->view  = new View();
    }

    function action_index()
    {
        $this->view->generate('login_view.php', 'template_view.php');
    }

    function action_process()
    {
        $login      = Parameters::Post('login');
        $password   = Parameters::Post('password');

        if ($login == SUPERLOGIN && password_verify($password, SUPERPASSWORDHASH) ) {
            $_SESSION['suLogin'] = true;
            header('Location: /');
        } else {
            header('Location: /login?error=-2');
        }
    }
}