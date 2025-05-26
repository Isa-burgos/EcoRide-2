<?php

namespace App\Controllers;

class TestController extends Controller
{
    public function test(){
        return $this->view('app.test-mongo');
    }
}
