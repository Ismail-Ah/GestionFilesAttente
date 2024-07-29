<?php

use App\Models\Ticket;
use App\Models\User;
use App\Models\Agence;
use App\Models\Service;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AgenceController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\TicketDispenserController;







//routes agences
Route::post('/agencies', [AgenceController::class, 'store'])->can('create',Agence::class);
Route::get('/agencies', [AgenceController::class, 'agencies'])->can('viewAny',Agence::class);
Route::get('/agences', [AgenceController::class, 'getAgences'])->can('viewAny',Agence::class);
Route::middleware('can:view,agence')->get('/agences/{agence}', [AgenceController::class, 'getAgence']);
Route::middleware('can:delete,agence')->delete('/agences/{agence}', [AgenceController::class, 'deleteAgence']);
Route::middleware('can:update,agence')->post('/agencies/{agence}/update', [AgenceController::class, 'updateAgence']);

// Routes for services
Route::post('/agence/{agence}/ajouter-service', [ServiceController::class, 'store'])->middleware('can:create,App\Models\Service');
Route::get('/agence/{agence}/services', [ServiceController::class, 'getServices2']);
Route::middleware('can:view,service')->get('/service/{service}', [ServiceController::class, 'serviceInfo']);
Route::middleware('can:viewAny,App\Models\Service')->get('/services', [ServiceController::class, 'getServices']);
Route::middleware('can:view,service')->get('/edit-agent/services', [ServiceController::class, 'getServices2']);
Route::middleware('can:delete,service')->delete('/services/{service}', [ServiceController::class, 'deleteService']);
Route::post('/services/{service}/update', [ServiceController::class, 'updateService'])->can('update,service',Service::class);

//routes Ticket
Route::post('/agence/{agence}/ticket-dispenser/services/{service}/ticket',[TicketController::class,'createTicket']);
Route::get('/{service}/tickets',[TicketController::class,'getServiceTickets']);
Route::put('/tickets/{ticket}/validate',[TicketController::class,'validerTicket'])->middleware(['auth','can:delete,ticket']);
Route::get('/tickets',[TicketController::class,'getAllTickets'])->middleware(['auth','can:viewAny,App\Models\Ticket']);
Route::get('/agences/{agence}/tickets',[TicketController::class,'getAgenceTickets'])->middleware(['auth','can:viewAny,App\Models\Ticket']);
Route::delete('/tickets/{ticket}',[TicketController::class,'supprimerTicket'])->middleware(['auth','can:delete,ticket']);

//routes statistique
Route::get('/services/{service}/statistics',[StatistiqueController::class,'getServiceStatistiques']);
Route::get('/agences/{agence}/statistics',[StatistiqueController::class,'getAgenceStatistiques']);
Route::get('/agencies/statistics',[StatistiqueController::class,'getAgencesStatistiques']);

//Route agent
Route::post('/create-agent-acount',[AgentController::class,'createAcount'])->middleware(['auth','can:create,App\Models\Agent']);
Route::get('/agent/services',[AgentController::class,'getServices'])->middleware(['auth','can:view,App\Models\Agent']);
Route::get('/agents',[AgentController::class,'getAgents'])->middleware(['auth','can:viewAny,App\Models\Agent']);
Route::delete('/agents/{agent}',[AgentController::class,'deleteAgent'])->middleware(['auth','can:delete,agent']);
Route::get('/service/{service}/agents',[AgentController::class,'getServiceAgents'])->middleware(['auth','can:view,App\Models\Agent']);
Route::get('/agence/{agence}/agents',[AgentController::class,'getAgenceAgents'])->middleware(['auth','can:viewAny,App\Models\Agent']);
Route::get('/edit/agents',[AgentController::class,'getAgents2'])->middleware(['auth','can:viewAny,App\Models\Agent']);
Route::post('/agents/{user}/update',[AgentController::class,'updateAgent'])->middleware(['auth','can:update,user']);


//Routes Statistiques
Route::get('/LineChartStatAgences/{time}',[StatistiqueController::class,'getLineChartStatAgences']);
Route::get('/service/{service}/LineChartStat/{time}',[StatistiqueController::class,'getLineChartStatService']);
Route::get('/agence/{agence}/LineChartStat/{time}',[StatistiqueController::class,'getLineChartStatAgence']);

Route::get('/TopAgences/{type}',[StatistiqueController::class,'getTopAgences']);
Route::get('/TopServices/{type}',[StatistiqueController::class,'getTopServices']);
Route::get('/TopServices/{agence}/{type}',[StatistiqueController::class,'getAgenceTopServices']);


//Route Profile
Route::get('/profile/dataAgenceService',[ProfileController::class,'getNmbrServiceAgence']);


//Auth routes
Auth::routes();




//Routes TicketDispenser
Route::get('/ticket-dispenser', [TicketDispenserController::class, 'showTDHome1']);
Route::get('/ticket-dispenser/agences', [TicketDispenserController::class, 'showTDAgences']);
Route::get('/ticket-dispenser/agences/{agence}', [TicketDispenserController::class, 'showTDHome2']);
Route::get('/agence/{agence}/ticket-dispenser/language', [TicketDispenserController::class, 'showTDLanguages']);
//langauge !!!!!!!!
Route::get('/agence/{agence}/ticket-dispenser/services', [TicketDispenserController::class, 'showTDServices']);
Route::get('/agence/{agence}/ticket-dispenser/services/{service}', [TicketDispenserController::class, 'showTDStatistiques']);
Route::get('/agence/{agence}/ticket-dispenser/services/{service}/ticket', [TicketDispenserController::class, 'showTDTicket']);


//language

//Routes Home
Route::get('/', function () { return view('home');});
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->middleware('auth');
Route::get('/statistiques', [App\Http\Controllers\HomeController::class, 'statistiques'])->middleware('auth');
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->middleware('auth');


//Route Agence
Route::get('/ajouter-agence',[AgenceController::class,'showFormAjouterAgence'])->middleware(['auth','can:create,App\Models\Agence']);
Route::get('/editer-agence',[AgenceController::class,'showFormEditerAgence'])->middleware(['auth','update,App\Models\Agence']);

//Routes Service 
Route::get('/agence/{agence}/ajouter-service',[ServiceController::class,'showFormAjouterService'])->middleware(['auth','can:create,App\Models\Service']);
Route::get('/editer-service',[ServiceController::class,'showFormEditerService'])->middleware(['auth','can:create,App\Models\Service']);


//Routes Agent
Route::get('/ajouter-agent',[AgentController::class,'showFormAjouterAgent'])->middleware(['auth','can:create,App\Models\User']);
Route::get('/editer-agent',[AgentController::class,'showFormEditerAgent'])->middleware(['auth','can:create,App\Models\User']);
