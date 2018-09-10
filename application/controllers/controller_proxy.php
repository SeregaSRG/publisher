<?php
class Controller_Proxy extends Controller
{
    function __construct()
    {
        if( $_SESSION['suLogin'] != true ) {
            header('Location: /login');
        }
        $this->model = new Model_Proxy();
        $this->view  = new View();
    }

    function action_index()
    {
        $data = $this->model->getAllProxy();
        $this->view->generate('proxy_view.php', 'template_view.php', $data);
    }

    function action_add()
    {
        $this->view->generate('proxy_add_view.php', 'template_view.php');
    }

    function action_add_process()
    {
        $this->model->addProxy();
        header('Location: /proxy');
    }

    function action_delete()
    {
        $this->model->delete();
        header('Location: /proxy');
    }
}