<?php
class Controller_Exit extends Controller
{
    function action_index()
    {
        session_destroy();
        header('Location: /login');
    }
}