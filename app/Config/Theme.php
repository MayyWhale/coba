<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Theme extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Used theme
     * --------------------------------------------------------------------------
     *
     * Theme to be used. One from selected list,
     *
     *    http://example.com/
     *
     * If this is not set then we will use the default theme
     * Our default theme is SB Admin 2
     *
     * @var null|string
     */
    public $theme  = [
        'landing'       => '',
        'auth'          => '',
        'panel'         => 'App\Views\Panel\Layout\Panel\\',
    ];

    public $viewLayout  = [
        'adminkit'      => 'App\Views\Theme\AdminKit\\',
        'adminlte'      => 'App\Views\Theme\AdminLTE\\',
        'architect'     => 'App\Views\Theme\ArchitectUI\\',
        'argon'         => 'App\Views\Theme\Argon\\',
        'flexy'         => 'App\Views\Theme\Flexy\\',
        'materialpro'   => 'App\Views\Theme\MaterialPro\\',
        'portal'        => 'App\Views\Theme\Portal\\',
        'purple'        => 'App\Views\Theme\Purple\\',
        'sbadmin'       => 'App\Views\Theme\SBAdmin\\',
    ];
}
