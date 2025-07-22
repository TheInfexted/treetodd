<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

class AuthControl extends BaseController
{
    /*
    * Protected
    */

    protected function userSessionGenerator($username,$password)
    {
        $recentDateTime = date('YmdHis');
        $hashToken = md5($username.$password.$recentDateTime);
        return $hashToken;
    }

    /*
    * End Protected
    */

    /*
    * Public
    */

    public function userLogin()
    {
        if( session()->get('isLoggedIn') ): return false; endif;

        $this->validation->setRuleGroup('loginUser');
        $checkValidate = $this->validation->run($this->request->getpost());
        // $validatedData = $this->validation->getErrors();
        // echo json_encode($validatedData);

        $username = strtoupper($this->request->getpost('params')['loginUsername']);
        $password = $this->request->getpost('params')['loginPass'];

        if( $checkValidate ):
            // Matching
            $userMatch = $this->AuthModel->selectUserBeforeLogin(['email'=>$username]);
            if( $userMatch['code']==0 ):
                echo json_encode([
                    'code' => $userMatch['code'],
                    'message' => lang('Response.unotfound')
                ]);
                return false;
            endif;

            $user = $userMatch['data'];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            if( !password_verify($password,$user['password']) ):
                echo json_encode([
                    'code' => -1,
                    'message' => lang('Response.invaliduser')
                ]);
                return false;
            endif;
            // End Matching

            // Token
            $sessionToken = $this->userSessionGenerator($username,$password);
            // End Token

            $payload = [
                'email' => $username,
                'user_token' => $sessionToken,
                'lastlogin_ip' => $_SESSION['ip'],
                'lastlogin_date' => date('Y-m-d H:i:s'),
            ];
            $res = $this->AuthModel->updateUserLogin($payload);
            // Create Login Session
            if( $res['code']==1 && $res['data']!=[] ):
                $us = $res['data'];
                $user_session = [
                    'isLoggedIn' => true,
                    'username' => $us['username'],
                    'session' => $us['user_token'],
                    'role' => $us['role'],
                ];
                $this->session->set($user_session);

                if( !empty($us['permission']) ):
                    $permission = json_decode($us['permission']);
                    $user_permission = [
                        'agent' => $permission->major->agent,
                        'transaction' => $permission->major->transaction,
                        'currency' => $permission->major->currency,
                        'broadcast' => $permission->major->broadcast,
                        'settings' => $permission->major->settings,
                    ];
                else:
                    $user_permission = [
                        'agent' => false,
                        'transaction' => false,
                        'currency' => false,
                        'broadcast' => false,
                        'settings' => false,
                    ];
                endif;
                $this->session->set($user_permission);

                echo json_encode([
                    'code' => $res['code'],
                    'message' => $res['message']
                ]);
            else:
                echo json_encode($res);
            endif;
            // End Create Login Session
        else:
            if( $this->validation->hasError('params.loginUsername') ):
                $err = $this->validation->getError('params.loginUsername');
            elseif( $this->validation->hasError('params.loginPass') ):
                $err = $this->validation->getError('params.loginPass');
            endif;

            echo json_encode([
                'code' => -1,
                'message' => $err,
            ]);
        endif;
    }

    public function userLogOut()
    {
        $res = $this->AuthModel->updateUserLogOut();
        // echo json_encode($res);
        $this->session->destroy();
        clearstatcache();
    }

    /*
    * End Public
    */
}