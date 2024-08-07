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
Route::middleware(['auth', 'can:create,App\Models\Agence'])->group(function () {
    Route::post('/agencies', [AgenceController::class, 'store']);
    Route::get('/ajouter-agence', [AgenceController::class, 'showFormAjouterAgence']);
});
Route::get('/agencies', [AgenceController::class, 'getAgences']);
Route::middleware(['auth', 'can:viewAny,App\Models\Agence'])->group(function () {
    Route::get('/agences', [AgenceController::class, 'getAgences']);
});
Route::middleware(['auth', 'can:view,agence'])->group(function () {
    Route::get('/agences/{agence}', [AgenceController::class, 'getAgence']);
});
Route::middleware(['auth', 'can:delete,agence'])->group(function () {
    Route::delete('/agences/{agence}', [AgenceController::class, 'deleteAgence']);
});
Route::middleware(['auth', 'can:update,agence'])->group(function () {
    Route::post('/agencies/{agence}/update', [AgenceController::class, 'updateAgence']);
    Route::get('/editer-agence', [AgenceController::class, 'showFormEditerAgence']);
});

// Routes for services
Route::middleware(['auth', 'can:create,App\Models\Service'])->group(function () {
    Route::post('/agence/{agence}/ajouter-service', [ServiceController::class, 'store']);
    Route::get('/ajouter-service', [ServiceController::class, 'showFormAjouterService']);
    Route::get('/agence/{agence}/ajouter-service', [ServiceController::class, 'showFormAjouterService']);
    Route::get('/editer-service', [ServiceController::class, 'showFormEditerService']);
    Route::get('/agence/{agence}/editer-service', [ServiceController::class, 'showFormEditerService']);
});
Route::get('/agence/{agence}/services', [ServiceController::class, 'getServices2']);
Route::middleware(['auth', 'can:view,service'])->group(function () {
    Route::get('/service/{service}', [ServiceController::class, 'serviceInfo']);
    Route::get('/edit-agent/services', [ServiceController::class, 'getServices2']);
});
Route::middleware(['auth', 'can:viewAny,App\Models\Service'])->group(function () {
    Route::get('/services', [ServiceController::class, 'getServices']);
    Route::get('/services/{user}', [ServiceController::class, 'getServicesOfAgent']);
});
Route::middleware(['auth', 'can:delete,service'])->group(function () {
    Route::delete('/services/{service}', [ServiceController::class, 'deleteService']);
});
Route::middleware(['auth', 'can:update,service'])->group(function () {
    Route::post('/services/{service}/update', [ServiceController::class, 'updateService']);
    Route::get('/service/{service}/etat', [ServiceController::class, 'changeEtatService']);
});

// Routes for tickets
Route::middleware(['auth', 'can:prendreTicket,service'])->group(function () {
    Route::post('/agence/{agence}/ticket-dispenser/services/{service}/ticket', [TicketController::class, 'createTicket']);
    Route::get('/agence/{agence}/ticket-dispenser/services/{service}', [TicketDispenserController::class, 'showTDStatistiques']);
    Route::get('/agence/{agence}/ticket-dispenser/services/{service}/ticket', [TicketDispenserController::class, 'showTDTicket']);
});
Route::get('/{service}/tickets', [TicketController::class, 'getServiceTickets']);
Route::middleware(['auth', 'can:delete,ticket'])->group(function () {
    Route::put('/tickets/{ticket}/validate', [TicketController::class, 'validerTicket']);
    Route::delete('/tickets/{ticket}', [TicketController::class, 'supprimerTicket']);
});
Route::middleware(['auth', 'can:viewAny,App\Models\Ticket'])->group(function () {
    Route::get('/tickets', [TicketController::class, 'getAllTickets']);
    Route::get('/agences/{agence}/tickets', [TicketController::class, 'getAgenceTickets']);
    Route::get('/agent/{user}/tickets', [TicketController::class, 'getAgentTickets']);
});

// Routes for statistics
Route::get('/services/{service}/statistics', [StatistiqueController::class, 'getServiceStatistiques']);
Route::get('/agences/{agence}/statistics', [StatistiqueController::class, 'getAgenceStatistiques']);
Route::get('/agencies/statistics', [StatistiqueController::class, 'getAgencesStatistiques']);
Route::get('/LineChartStatAgences/{time}', [StatistiqueController::class, 'getLineChartStatAgences']);
Route::get('/service/{service}/LineChartStat/{time}', [StatistiqueController::class, 'getLineChartStatService']);
Route::get('/agence/{agence}/LineChartStat/{time}', [StatistiqueController::class, 'getLineChartStatAgence']);
Route::get('/TopAgences/{type}', [StatistiqueController::class, 'getTopAgences']);
Route::get('/TopServices/{type}', [StatistiqueController::class, 'getTopServices']);
Route::get('/TopServices/{agence}/{type}', [StatistiqueController::class, 'getAgenceTopServices']);

// Routes for agents
Route::middleware(['auth', 'can:create,App\Models\Agent'])->group(function () {
    Route::post('/create-agent-acount', [AgentController::class, 'createAcount']);
    Route::get('/ajouter-agent', [AgentController::class, 'showFormAjouterAgent']);
    Route::get('/editer-agent', [AgentController::class, 'showFormEditerAgent']);
});
Route::middleware(['auth', 'can:view,App\Models\Agent'])->group(function () {
    Route::get('/agent/services', [AgentController::class, 'getServices']);
});
Route::middleware(['auth', 'can:viewAny,App\Models\Agent'])->group(function () {
    Route::get('/agents', [AgentController::class, 'getAgents']);
    Route::get('/agence/{agence}/agents', [AgentController::class, 'getAgenceAgents']);
    Route::get('/edit/agents', [AgentController::class, 'getAgents']);
});
Route::middleware(['auth', 'can:delete,agent'])->group(function () {
    Route::delete('/agents/{agent}', [AgentController::class, 'deleteAgent']);
});
Route::middleware(['auth', 'can:update,user'])->group(function () {
    Route::post('/agents/{user}/update', [AgentController::class, 'updateAgent']);
});
Route::middleware(['auth', 'can:view,App\Models\Agent'])->group(function () {
    Route::get('/service/{service}/agents', [AgentController::class, 'getServiceAgents']);
});

// Routes for profile
Route::get('/profile/dataAgenceService', [ProfileController::class, 'getNmbrServiceAgence']);
Route::middleware('auth')->group(function () {
    Route::get('/profile/user', [ProfileController::class, 'user']);
    Route::get('/profile/{user}', [ProfileController::class, 'user2'])->middleware('can:view,user');
    Route::post('/user/{user}/update-profile-image', [ProfileController::class, 'updateProfileImage'])->middleware('can:update,user');
});
Route::get('/logo', [ProfileController::class, 'getLogo']);

// Auth routes
Auth::routes();

// Routes for Ticket Dispenser
Route::get('/ticket-dispenser', [TicketDispenserController::class, 'showTDHome1']);
Route::get('/ticket-dispenser/agences', [TicketDispenserController::class, 'showTDAgences']);
Route::get('/ticket-dispenser/agences/{agence}', [TicketDispenserController::class, 'showTDHome2']);
Route::get('/agence/{agence}/ticket-dispenser/language', [TicketDispenserController::class, 'showTDLanguages']);
Route::get('/agence/{agence}/ticket-dispenser/services', [TicketDispenserController::class, 'showTDServices']);

// Routes for Home
Route::get('/', function () { return view('home'); });
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard']);
    Route::get('/statistiques', [HomeController::class, 'statistiques']);
    Route::get('/profile', [HomeController::class, 'profile']);
});

// Additional routes
Route::get('/live-search', [HomeController::class, 'liveSearch'])->name('liveSearch');
Route::get('/live-queue', [HomeController::class, 'liveQueue']);
Route::get('/live-queue/agences/{agence}', [HomeController::class, 'homeQueue']);
Route::get('/queue/agence/{agence}/services', [ServiceController::class, 'getServicesForQueue']);
