<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\AuthModel;
use App\Models\ClassroomModel;
use App\Models\TeacherModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['cookie','url','form','text','filesystem','date','array','email','language','security','number'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    protected $session;
    protected $language;
    protected $validation;
    protected $AuthModel;
    protected $ClassroomModel;
    protected $TeacherModel;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = service('session');

        // Libraries
        $this->session = \Config\Services::session();
		$this->language = \Config\Services::language();
		$security = \Config\Services::security();
		$this->validation = \Config\Services::validation();

        if( !$this->session->lang && !isset($_COOKIE["lang"]) ):
            $this->session->set('lang', 'en');
            set_cookie("lang", 'en');
        elseif( !$this->session->lang && isset($_COOKIE["lang"]) ):
            $this->session->set('lang', $_COOKIE["lang"]);
            set_cookie("lang", 'en');
        else:
            // $_COOKIE["lang"];
        endif;
		$this->language->setLocale($this->session->lang);
        // End Libraries

        /*
        * Model
        */

        $this->AuthModel = new AuthModel();
        $this->ClassroomModel = new ClassroomModel();
        $this->TeacherModel = new TeacherModel();

        /*
        * End Model
        */

        /*
        * Global
        */

        $client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];

		if(filter_var($client, FILTER_VALIDATE_IP)) {
			$ip = $client;
		} elseif(filter_var($forward, FILTER_VALIDATE_IP)) {
			$ip = $forward;
		} else {
			$ip = $remote;
		}
		$this->session->set('ip', $ip);

        /*
        * End Global
        */
    }

    public function checkDevice()
    {
        $device = $this->request->getUserAgent();
        $isMobile = $device->isMobile();
        $isBrowser = $device->isBrowser();
        $currentMobile = $device->getMobile();
		$currentPlatform = $device->getPlatform();
		$result = [
            'code' => 0,
			'isMobile' => $isMobile,
            'isBrowser' => $isBrowser,
            'mobile' => $currentMobile,
			'platform' => $currentPlatform
		];
        echo json_encode($result);
    }

    /*
    * Protected - Session
    */

    protected function verifyLoggedUser()
    {
        $res = $this->AuthModel->selectUserAfterLogin();
        if( $res['code']==1 && $res['data']!=[] ):
            return [
                'timeout' => false
            ];
        else:
            return [
                'timeout' => true
            ];
        endif;
    }

    /*
    * Protected - Helper Methods
    */

    protected function checkSession()
    {
        if( !session()->get('isLoggedIn') ): 
            return false; 
        endif;
        return true;
    }

    protected function prepareData($pageName, $additionalData = [])
    {
        $data = [
            'session' => session()->get('isLoggedIn') ? true : false,
            'pageName' => $pageName
        ];
        
        return array_merge($data, $additionalData);
    }

    protected function renderView($viewName, $data = [])
    {
        echo view('template/start');
        echo view('template/header');
        echo view($viewName, $data);
        echo view('template/footer');
        echo view('template/end', $data);
    }

    /*
    * End Protected - Helper Methods
    */

    /*
    * End Protected - Session
    */
}
