<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('404', 'General::index_pageNotFound404');
$routes->get('translate/{locale}', 'LangControl::translateLocale');
$routes->get('device/check', 'General::checkDevice');

$routes->get('/blank', 'General::index_blank', ['filter' => 'noauth']);

$routes->get('/', 'General::index', ['filter' => 'noauth']);
$routes->get('dashboard', 'General::index_dashboard', ['filter' => 'auth']);
$routes->get('settings/classroom', 'General::index_classroom', ['filter' => 'auth']);
$routes->get('teachers', 'General::index_teacher', ['filter' => 'auth']);
$routes->get('children', 'General::index_children', ['filter' => 'auth']);

// Auth
$routes->resource('AuthControl');
$routes->post('user-login', 'AuthControl::userLogin', ['filter' => 'noauth']);
$routes->get('user-logout', 'AuthControl::userLogOut');
// End Auth

// Teacher
$routes->resource('teachers', ['controller' => 'TeacherController','filter' => 'auth']);
$routes->get('teacher/view/(:num)', 'TeacherController::view/$1', ['filter' => 'auth']);
$routes->post('list-teachers', 'TeacherController::teacherListWithPagination', ['filter' => 'auth']);
$routes->post('teacher/add-new', 'TeacherController::addNewTeacher', ['filter' => 'auth']);
$routes->get('teacher/details/(:num)', 'TeacherController::getTeacherDetails/$1', ['filter' => 'auth']);
$routes->post('teacher/update', 'TeacherController::updateTeacher', ['filter' => 'auth']);
$routes->post('teacher/change-status', 'TeacherController::updateTeacherStatus', ['filter' => 'auth']);
// End Teacher

// Classroom
$routes->resource('ClassroomControl');
$routes->post('list-classroom', 'ClassroomControl::classroomListWithPagination', ['filter' => 'auth']);
$routes->post('classroom/add-new', 'ClassroomControl::addNewClassroom', ['filter' => 'auth']);
$routes->post('classroom/modify-status', 'ClassroomControl::updateClassroomStatus', ['filter' => 'auth']);
// End Classroom

// User
$routes->resource('UserControl');
$routes->post('user/get-profile', 'UserControl::getUserProfile', ['filter' => 'auth']);
// End User
