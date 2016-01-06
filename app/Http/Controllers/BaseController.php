<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Teepluss\Theme\Contracts\Theme;



class BaseController extends Controller
{
    /**
     * Theme instance.
     *
     * @var \Teepluss\Theme\Theme
     */
    protected $theme;

    /**
     * BaseController constructor.
     *
     * @param Theme $theme
     */
    public function __construct(Theme $theme)
    {
        // Using theme as a global.
        // $this->theme = $theme->uses('default')->layout('ipad');
        $this->theme = $theme->uses(env('THEMA'))->layout(env('LAYOUT'));
    }
}
