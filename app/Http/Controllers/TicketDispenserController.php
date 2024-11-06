<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Service;
use Illuminate\Http\Request;

class TicketDispenserController extends Controller
{
    public function showTDHome1()
    {
        return view('TD/TD-home1');
    }
    public function showTDHome2(Agence $agence)
    {
        return view('TD/TD-home2');
    }
    public function showTDAgences()
    {
        return view('TD/TD-agences');
    }

    public function showTDLanguages(Agence $agence)
    {
        return view('TD/TD-languages');
    }
    public function showTDServices(Agence $agence)
    {
        return view('TD/TD-services');
    }
    public function showTDStatistiques(Agence $agence,Service $service)
    {
        return view('TD/TD-statistiques');
    }
    public function showTDTicket(Agence $agence,Service $service)
    {
        return view('TD/TD-ticket');
    }
}
