<?php

class MainController extends AbstractController
{
    public $model;
    public $view;

    public function __construct()
    {
    }

    public function indexAction()
    {
        $this->render('index');
    }
}
