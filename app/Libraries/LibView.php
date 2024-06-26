<?php

namespace App\Libraries;

class LibView
{
    public function header()
    {
        return view('common/header');
    }

    public function navBarMenu()
    {
        return view('common/navbar');
    }

    public function menuVertical()
    {
        return view('common/menu');
    }

    public function footer()
    {
        return view('common/footer');
    }
}
