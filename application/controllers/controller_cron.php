<?php
class Controller_Cron extends Controller
{
    function __construct()
    {
        $this->model = new Model_Cron();
    }

    function action_index()
    {
        $this->model->cron();
    }
}