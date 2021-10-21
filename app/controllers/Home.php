<?php
class Home extends Controller
{
    private $data;
    public function __construct()
    {
        $this->data = array();
        $this->data['title_web'] = "Home";
    }
    public function index()
    {

        $this->view("templates/header", $this->data);
        $this->view("home/index");
        $this->view("templates/footer");
    }
}
