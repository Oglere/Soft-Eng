<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PdfController
{
    public function layouts() {
        return view('asd');
    }

    public function plain_layout() {
        return view('layout.pdf.plain');
    }

    public function sidenav_layout() {
        return view('layout.pdf.sidenavbar');
    }

    public function static_pdf_layout() {
        return view('layout.pdf.static');
    }

    public function dynamic_pdf_layout() {
        return view('layout.pdf.dynamic');
    }
}
