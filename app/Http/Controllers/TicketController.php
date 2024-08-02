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
        // Get the latest ticket for the service
        $fil = $service->fileAttente()->with('tickets')->latest()->first();
        $dernierTicket = $fil->tickets()->latest()->first();

        // Create a new ticket
        $ticket = Ticket::create([
            'numéro' => $dernierTicket ? $dernierTicket->numéro + 1 : 1,
            'files_attente_id' => $fil->id,
            'statut' => "EN_ATTENT",
        ]);
        
        $fil->increment('ClientsEnAttentes');
        $fil->save();

        return response()->json(['message' => 'Ticket created successfully!', 'ticket' => $ticket], 201);
    }

    public function showValidateTicket()
    {
        return view('validateTicket');
    }

    public function validerTicket(Ticket $ticket)
    {
        $ticket->update(['statut' => 'TRAITE']);

        $fil = Files_Attente::find($ticket->files_attente_id);

        if (!$fil) {
            return response()->json(["error" => "FileAttente not found"], 404);
        }

        $fil->decrement('ClientsEnAttentes');
        $fil->increment('ClientsTraites');

        $tempsAttente = (strtotime($ticket->updated_at) - strtotime($ticket->created_at)) / 60;
        $fil->tempsMoyenAttente = (($fil->tempsMoyenAttente * ($fil->ClientsTraites - 1)) + $tempsAttente) / $fil->ClientsTraites;

        $fil->save();

        return response()->json(["message" => "Ticket validated successfully"]);
    }

    public function supprimerTicket(Ticket $ticket)
    {
        $ticket->delete();
        return response()->json(["message" => "Ticket deleted successfully"]);
    }

    public function getServiceTickets(Service $service)
    {
        if (auth()->user()->role === 'Agent' && $service->user_id != auth()->user()->id) {
            return response()->json("Accés refusé", 403);
        }

        $tickets = $this->getLatestTickets($service->fileAttente()->latest()->first());

        return response()->json($this->addServiceAndAgenceNames($tickets));
    }

    public function getAllTickets()
    {
        $userId = auth()->user()->id;
        if (auth()->user()->role === 'AGENT') {
            $tickets = Ticket::whereHas('fileAttente.service', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->get();
        } else {
            $tickets = Ticket::get();
        }

        return response()->json($this->addServiceAndAgenceNames($tickets));
    }

    public function getAgenceTickets(Agence $agence)
    {
        // Check if the user is an agent and belongs to the correct agency
        if (auth()->user()->role === 'AGENT' && auth()->user()->agence->id != $agence->id) {
            return response()->json("Accés refusé", 403);
        }
    
        // Fetch all tickets related to the agency's services
        $tickets = Ticket::whereHas('fileAttente.service', function ($query) use ($agence) {
            $query->where('agence_id', $agence->id);
        })->get();
    
        // Add service and agency names to the tickets
        return response()->json($this->addServiceAndAgenceNames($tickets));
    }

    public function getAgentTickets(User $user)
    {
        $tickets = Ticket::whereHas('fileAttente.service', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
    
        // Add service and agency names to the tickets
        return response()->json($this->addServiceAndAgenceNames($tickets));
    }

    private function getLatestTickets($fileAttente)
    {
        return $fileAttente ? $fileAttente->tickets()->get() : collect();
    }

    private function addServiceAndAgenceNames($tickets)
    {
        foreach ($tickets as $ticket) {
            $ticket->service = $ticket->service;
            $ticket->nom_agence = $ticket->service->agence->nom;
            
        }

        return $tickets;
    }
}
