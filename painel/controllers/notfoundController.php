<?php

class notfoundController extends Controller{
    public function index(){

        $this->loadView('404',array());

    }
}