<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public array $loginUser = [
        // 'params.loginUsername' => [
        //     'label' => 'Username',
        //     'rules' => 'required|min_length[4]|max_length[50]|alpha_numeric',
        // ],
        'params.loginUsername' => [
            'label' => 'Email',
            'rules' => 'required|max_length[254]|valid_email',
        ],
        'params.loginPass' => [
            'label' => 'Password',
            'rules' => 'required|min_length[6]|max_length[255]',
        ],
    ];

    public array $insertUser = [
        // 'params.mobileNo' => [
        //     'label' => 'Username',
        //     'rules' => 'required|min_length[6]|max_length[12]|alpha_numeric',
        // ],
        'params.password' => [
            'label' => 'Current Password',
            'rules' => 'required|min_length[6]|max_length[255]',
        ],
        // 'params.regionCode' => [
        //     'label' => 'Region Code',
        //     'rules' => 'required',
        // ],
        // 'params.mobileNo' => [
        //     'label' => 'Mobile.No',
        //     'rules' => 'required|min_length[7]',
        // ],
        // 'params.fname' => [
        //     'label' => 'Full Name',
        //     'rules' => 'required|min_length[3]|max_length[255]|alpha_space',
        // ],
        // 'params.email' => [
        //     'label' => 'Email',
        //     'rules' => 'required|max_length[254]|valid_email',
        // ],
    ];
}
