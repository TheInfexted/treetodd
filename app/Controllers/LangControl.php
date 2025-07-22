<?php namespace App\Controllers;

use App\Controllers\BaseController;

class LangControl extends BaseController
{
    // Translation
    public function translateLocale()
    {
        $session = session();
        $locale = $this->request->getLocale();
        $session->remove('lang');
        $session->set('lang', $locale);

        // Cookies
        set_cookie("lang", $locale);
        // echo $_COOKIE["locale"];
        // End Cookies

        // $url = base_url();
        // return redirect()->to($url);
        return json_encode(['code'=>1]);
    }
}