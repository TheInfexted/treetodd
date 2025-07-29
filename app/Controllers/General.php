<?php

namespace App\Controllers;

class General extends BaseController
{
    /*
    * Teacher
    */

    public function index_teacher()
    {
        if (!$this->checkSession()): return false; endif;
        
        // Get branches and kindergartens from database
        $branches = $this->TeacherModel->selectBranches();
        $kindergartens = $this->TeacherModel->selectKindergartens();

        $data = $this->prepareData(lang('Nav.teacher'), [
            'branches' => (isset($branches['data']) && is_array($branches['data'])) ? $branches['data'] : [],
            'kindergartens' => (isset($kindergartens['data']) && is_array($kindergartens['data'])) ? $kindergartens['data'] : [],
        ]);

        $this->renderView('teacher/index', $data);
    }

    public function index_teacher_view($teacherId)
    {
        if (!$this->checkSession()): return false; endif;
        
        $teacher = $this->TeacherModel->selectTeacherDetails(['teacher_id' => $teacherId]);
        
        if (!$teacher || $teacher['code'] != 1) {
            return redirect()->to('/teachers')->with('error', 'Teacher not found');
        }

        $data = $this->prepareData('Teacher Details - ' . $teacher['data']['teacher_name'], [
            'teacher' => $teacher['data']
        ]);

        $this->renderView('teacher/view', $data);
    }

    public function index_teacher_edit($teacherId)
    {
        if (!$this->checkSession()): return false; endif;
        
        $teacher = $this->TeacherModel->selectTeacherDetails(['teacher_id' => $teacherId]);
        $branches = $this->TeacherModel->selectBranches();
        $kindergartens = $this->TeacherModel->selectKindergartens();
        
        if (!$teacher || $teacher['code'] != 1) {
            return redirect()->to('/teachers')->with('error', 'Teacher not found');
        }

        $data = $this->prepareData('Edit Teacher - ' . $teacher['data']['teacher_name'], [
            'teacher' => $teacher['data'],
            'branches' => $branches['data'] ?? [],
            'kindergartens' => $kindergartens['data'] ?? [],
        ]);

        $this->renderView('teacher/edit', $data);
    }

    public function index_teacher_add()
    {
        if (!$this->checkSession()): return false; endif;
        
        $branches = $this->TeacherModel->selectBranches();
        $kindergartens = $this->TeacherModel->selectKindergartens();

        $data = $this->prepareData('Add New Teacher', [
            'branches' => $branches['data'] ?? [],
            'kindergartens' => $kindergartens['data'] ?? [],
        ]);

        $this->renderView('teacher/add', $data);
    }

    /*
    * End Teacher
    */

    /*
    * Children
    */

    public function index_children()
    {
        if (!$this->checkSession()): return false; endif;
        
        $data = $this->prepareData(lang('Nav.children'));
        $this->renderView('children/index', $data);
    }

    /*
    * End Children
    */

    /*
    * Settings
    */

    public function index_classroom()
    {
        if (!$this->checkSession()): return false; endif;
        
        $data = $this->prepareData(lang('Nav.classroom'));
        $this->renderView('classroom/index', $data);
    }

    /*
    * End Settings
    */

    /*
    * Dashboard
    */

    public function index_dashboard()
    {
        if (!$this->checkSession()): return false; endif;
        
        $data = $this->prepareData(lang('Nav.dashboard'));
        $this->renderView('dashboard', $data);
    }

    /*
    * End Dashboard
    */

    /*
    * Authentication
    */

    public function index()
    {
        $data = $this->prepareData('Login');
        echo view('template/start');
        echo view('index');
        echo view('template/end', $data);
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
        echo view('template/start');
        echo view('404');
        echo view('template/end');
    }

    /*
    * End 404
    */
}