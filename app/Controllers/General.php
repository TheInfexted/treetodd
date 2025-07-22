<?php

namespace App\Controllers;

class General extends BaseController
{
    /*
    * Teacher
    */

    public function index_teacher()
    {
        if( !session()->get('isLoggedIn') ): return false; endif;
        $data['session'] = session()->get('isLoggedIn') ? true : false;

        $data['pageName'] = lang('Nav.teacher');

        echo view('template/start');
        echo view('template/header');
        echo view('teacher/index',$data);
        echo view('template/footer');
        echo view('template/end',$data);
    }

    /*
    * End Teacher
    */

    /*
    * Children
    */

    public function index_children()
    {
        if( !session()->get('isLoggedIn') ): return false; endif;
        $data['session'] = session()->get('isLoggedIn') ? true : false;

        $data['pageName'] = lang('Nav.children');

        echo view('template/start');
        echo view('template/header');
        echo view('children/index',$data);
        echo view('template/footer');
        echo view('template/end',$data);
    }

    /*
    * End Children
    */

    /*
    * Settings
    */

    public function index_classroom()
    {
        if( !session()->get('isLoggedIn') ): return false; endif;
        $data['session'] = session()->get('isLoggedIn') ? true : false;

        $data['pageName'] = lang('Nav.classroom');

        echo view('template/start');
        echo view('template/header');
        echo view('classroom/index',$data);
        echo view('template/footer');
        echo view('template/end',$data);
    }

    /*
    * End Settings
    */

    /*
    * Dashboard
    */

    public function index_dashboard()
    {
        if( !session()->get('isLoggedIn') ): return false; endif;
        $data['session'] = session()->get('isLoggedIn') ? true : false;

        $data['pageName'] = lang('Nav.dashboard');

        echo view('template/start');
        echo view('template/header');
        echo view('dashboard',$data);
        echo view('template/footer');
        echo view('template/end',$data);
    }

    /*
    * End Dashboard
    */

    /*
    * Authentication
    */

    public function index()
    {
        $data['session'] = session()->get('isLoggedIn') ? true : false;

        echo view('template/start');
        echo view('index');
        echo view('template/end',$data);
    }

    public function index_blank()
    {
        echo view('template/start');
        echo view('template/header');
        echo view('blank');
        echo view('template/footer');
        echo view('template/end');
    }

    /*
    * End Authentication
    */

    /*
    * 404
    */

    public function index_pageNotFound404()
    {
        // $data['session'] = session()->get('isLoggedIn') ? true : false;
        
        echo view('template/start');
        echo view('404');
        echo view('template/end');
    }

    /*
    * End 404
    */
}
