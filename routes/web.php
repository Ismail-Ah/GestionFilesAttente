<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AgenceController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\TicketDispenserController;

// Routes for agencies
Route::post('/agencies', [AgenceController::class, 'store'])->middleware('can:create,App\Models\Agence');
Route::get('/agencies', [AgenceController::class, 'agencies']);
Route::get('/agences', [AgenceController::class, 'getAgences'])->middleware('can:viewAny,App\Models\Agence');
Route::get('/agences/{agence}', [AgenceController::class, 'getAgence'])->middleware('can:view,agence');
Route::delete('/agences/{agence}', [AgenceController::class, 'deleteAgence'])->middleware('can:delete,agence');
Route::post('/agencies/{agence}/update', [AgenceController::class, 'updateAgence'])->middleware('can:update,agence');

// Routes for services
Route::post('/agence/{agence}/ajouter-service', [ServiceController::class, 'store'])->middleware('can:create,App\Models\Service');
Route::get('/agence/{agence}/services', [ServiceController::class, 'getServices2']);
Route::get('/service/{service}', [ServiceController::class, 'serviceInfo'])->middleware('can:view,service');
Route::get('/services', [ServiceController::class, 'getServices'])->middleware('can:viewAny,App\Models\Service');
Route::get('/edit-agent/services', [ServiceController::class, 'getServices2'])->middleware('can:view,service');
Route::delete('/services/{service}', [ServiceController::class, 'deleteService'])->middleware('can:delete,service');
Route::post('/services/{service}/update', [ServiceController::class, 'updateService'])->middleware('can:update,service');
Route::get('/services/{user}', [ServiceController::class, 'getServicesOfAgent'])->middleware('can:viewAny,App\Models\Service');
Route::get('/service/{service}/etat', [ServiceController::class, 'changeEtatService'])->middleware('can:update,service');


// Routes for tickets
Route::post('/agence/{agence}/ticket-dispenser/services/{service}/ticket', [TicketController::class, 'createTicket'])->middleware('can:prendreTicket,service');
Route::get('/{service}/tickets', [TicketController::class, 'getServiceTickets']);
Route::put('/tickets/{ticket}/validate', [TicketController::class, 'validerTicket'])->middleware(['auth', 'can:delete,ticket']);
Route::get('/tickets', [TicketController::class, 'getAllTickets'])->middleware(['auth', 'can:viewAny,App\Models\Ticket']);
Route::get('/agences/{agence}/tickets', [TicketController::class, 'getAgenceTickets'])->middleware(['auth', 'can:viewAny,App\Models\Ticket']);
Route::delete('/tickets/{ticket}', [TicketController::class, 'supprimerTicket'])->middleware(['auth', 'can:delete,ticket']);
Route::get('/agent/{user}/tickets', [TicketController::class, 'getAgentTickets'])->middleware(['auth', 'can:viewAny,App\Models\Ticket']);

// Routes for statistics
Route::get('/services/{service}/statistics', [StatistiqueController::class, 'getServiceStatistiques']);
Route::get('/agences/{agence}/statistics', [StatistiqueController::class, 'getAgenceStatistiques']);
Route::get('/agencies/statistics', [StatistiqueController::class, 'getAgencesStatistiques']);

// Routes for agents
Route::post('/create-agent-acount', [AgentController::class, 'createAcount'])->middleware(['auth', 'can:create,App\Models\Agent']);
Route::get('/agent/services', [AgentController::class, 'getServices'])->middleware(['auth', 'can:view,App\Models\Agent']);
Route::get('/agents', [AgentController::class, 'getAgents'])->middleware(['auth', 'can:viewAny,App\Models\Agent']);
Route::delete('/agents/{agent}', [AgentController::class, 'deleteAgent'])->middleware(['auth', 'can:delete,agent']);
Route::get('/service/{service}/agents', [AgentController::class, 'getServiceAgents'])->middleware(['auth', 'can:view,App\Models\Agent']);
Route::get('/agence/{agence}/agents', [AgentController::class, 'getAgenceAgents'])->middleware(['auth', 'can:viewAny,App\Models\Agent']);
Route::get('/edit/agents', [AgentController::class, 'getAgents2'])->middleware(['auth', 'can:viewAny,App\Models\Agent']);
Route::post('/agents/{user}/update', [AgentController::class, 'updateAgent'])->middleware(['auth', 'can:update,user']);

// Routes for statistics
Route::get('/LineChartStatAgences/{time}', [StatistiqueController::class, 'getLineChartStatAgences']);
Route::get('/service/{service}/LineChartStat/{time}', [StatistiqueController::class, 'getLineChartStatService']);
Route::get('/agence/{agence}/LineChartStat/{time}', [StatistiqueController::class, 'getLineChartStatAgence']);
Route::get('/TopAgences/{type}', [StatistiqueController::class, 'getTopAgences']);
Route::get('/TopServices/{type}', [StatistiqueController::class, 'getTopServices']);
Route::get('/TopServices/{agence}/{type}', [StatistiqueController::class, 'getAgenceTopServices']);

// Route for profile
Route::get('/profile/dataAgenceService', [ProfileController::class, 'getNmbrServiceAgence']);

// Auth routes
Auth::routes();

// Routes for Ticket Dispenser
Route::get('/ticket-dispenser', [TicketDispenserController::class, 'showTDHome1']);
Route::get('/ticket-dispenser/agences', [TicketDispenserController::class, 'showTDAgences']);
Route::get('/ticket-dispenser/agences/{agence}', [TicketDispenserController::class, 'showTDHome2']);
Route::get('/agence/{agence}/ticket-dispenser/language', [TicketDispenserController::class, 'showTDLanguages']);
Route::get('/agence/{agence}/ticket-dispenser/services', [TicketDispenserController::class, 'showTDServices']);
Route::get('/agence/{agence}/ticket-dispenser/services/{service}', [TicketDispenserController::class, 'showTDStatistiques'])->middleware('can:prendreTicket,service');
Route::get('/agence/{agence}/ticket-dispenser/services/{service}/ticket', [TicketDispenserController::class, 'showTDTicket'])->middleware('can:prendreTicket,service');

// Routes for Home
Route::get('/', function () { return view('home'); });
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->middleware('auth');
Route::get('/statistiques', [App\Http\Controllers\HomeController::class, 'statistiques'])->middleware('auth');
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->middleware('auth');

// Routes for Profile
Route::get('/profile/user', [ProfileController::class, 'user'])->middleware('auth');
Route::get('/profile/{user}', [ProfileController::class, 'user2'])->middleware(['auth', 'can:view,user']);

// Routes for agencies (additional routes)
Route::get('/ajouter-agence', [AgenceController::class, 'showFormAjouterAgence'])->middleware(['auth', 'can:create,App\Models\Agence']);
Route::get('/editer-agence', [AgenceController::class, 'showFormEditerAgence'])->middleware(['auth', 'can:update,App\Models\Agence']);

// Routes for services (additional routes)
Route::get('/agence/{agence}/ajouter-service', [ServiceController::class, 'showFormAjouterService'])->middleware(['auth', 'can:create,App\Models\Service']);
Route::get('/editer-service', [ServiceController::class, 'showFormEditerService'])->middleware(['auth', 'can:update,App\Models\Service']);

// Routes for agents (additional routes)
Route::get('/ajouter-agent', [AgentController::class, 'showFormAjouterAgent'])->middleware(['auth', 'can:create,App\Models\User']);
Route::get('/editer-agent', [AgentController::class, 'showFormEditerAgent'])->middleware(['auth', 'can:update,App\Models\User']);

//search route
Route::get('/live-search', [HomeController::class, 'liveSearch'])->name('liveSearch');

//queue routes
Route::get('/live-queue', [HomeController::class, 'liveQueue']);
Route::get('/live-queue/agences/{agence}', [HomeController::class, 'homeQueue']);
Route::get('/queue/agence/{agence}/services', [ServiceController::class, 'getServicesForQueue']);
