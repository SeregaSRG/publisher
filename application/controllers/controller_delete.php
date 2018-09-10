<?php
class Controller_Delete extends Controller
{
    function __construct()
    {
        if( $_SESSION['suLogin'] != true ) {
            header('Location: /login');
        }
        $this->model = new Model_Delete();
        $this->view  = new View();
    }

    function action_index()
    {
        $data = $this->model->delete();
        header('Location: /');
    }
}