<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agence;
use App\Models\Ticket;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Files_Attente;

class TicketController extends Controller
{
    public function createTicket(Agence $agence, Service $service)
    {
        // Get the latest ticket number from the latest file attente
        $latestFileAttente = $service->fileAttente()->latest()->first();
        $latestTicket = $latestFileAttente ? $latestFileAttente->tickets()->latest()->first() : null;

        // Create a new ticket
        $ticketNumber = $latestTicket ? $latestTicket->numéro + 1 : 1;
        $ticket = Ticket::create([
            'numéro' => $ticketNumber,
            'files_attente_id' => $latestFileAttente->id,
            'statut' => "EN_ATTENT",
        ]);

        $latestFileAttente->increment('ClientsEnAttentes');

        return response()->json(['message' => 'Ticket created successfully!', 'ticket' => $ticket], 201);
    }

    public function showValidateTicket()
    {
        return view('validateTicket');
    }

    public function validerTicket(Ticket $ticket)
    {
        $ticket->update(['statut' => 'TRAITE']);

        $fileAttente = Files_Attente::find($ticket->files_attente_id);

        if (!$fileAttente) {
            return response()->json(["error" => "FileAttente not found"], 404);
        }

        $fileAttente->decrement('ClientsEnAttentes');
        $fileAttente->increment('ClientsTraites');

        $waitingTime = (strtotime($ticket->updated_at) - strtotime($ticket->created_at)) / 60;
        $totalWaitingTime = $fileAttente->tempsMoyenAttente * ($fileAttente->ClientsTraites - 1);
        $fileAttente->tempsMoyenAttente = ($totalWaitingTime + $waitingTime) / $fileAttente->ClientsTraites;

        $fileAttente->save();

        return response()->json(["message" => "Ticket validated successfully"]);
    }

    public function supprimerTicket(Ticket $ticket)
    {
        $ticket->delete();
        return response()->json(["message" => "Ticket deleted successfully"]);
    }

    public function getServiceTickets(Service $service)
    {
        if (auth()->user()->role === 'AGENT' && $service->user_id != auth()->user()->id) {
            return response()->json("Accés refusé", 403);
        }

        $fileAttente = $service->fileAttente()->latest()->first();
        $tickets = $fileAttente ? $fileAttente->tickets : collect();

        return response()->json($this->addServiceAndAgenceNames($tickets));
    }

    public function getAllTickets()
    {
        $userId = auth()->user()->id;
        $tickets = Ticket::whereHas('fileAttente.service', function ($query) use ($userId) {
            if (auth()->user()->role === 'AGENT') {
                $query->where('user_id', $userId);
            }
        })->get();

        return response()->json($this->addServiceAndAgenceNames($tickets));
    }

    public function getAgenceTickets(Agence $agence)
    {
        if (auth()->user()->role === 'AGENT' && auth()->user()->agence->id != $agence->id) {
            return response()->json("Accés refusé", 403);
        }

        $tickets = Ticket::whereHas('fileAttente.service', function ($query) use ($agence) {
            $query->where('agence_id', $agence->id);
        })->get();

        return response()->json($this->addServiceAndAgenceNames($tickets));
    }

    public function getAgentTickets(User $user)
    {
        $tickets = Ticket::whereHas('fileAttente.service', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        return response()->json($this->addServiceAndAgenceNames($tickets));
    }

    private function addServiceAndAgenceNames($tickets)
    {
        foreach ($tickets as $ticket) {
            $ticket->service = $ticket->service;
            $ticket->nom_agence = $ticket->service->agence->nom;
            $ticket->id_agence =  $ticket->service->agence->id;
        }

        return $tickets;
    }
}
