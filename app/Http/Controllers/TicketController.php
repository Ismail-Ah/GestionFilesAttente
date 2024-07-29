<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Ticket;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Files_Attente;
use Illuminate\Support\Facades\Validator;

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

        $tickets = $this->getLatestTickets($service->fileAttente()->latest()->first(), 3);

        return response()->json($this->addServiceAndAgenceNames($tickets));
    }

    public function getAllTickets()
    {
        $userId = auth()->user()->id;
        if (auth()->user()->role === 'AGENT') {
            $tickets = Ticket::whereHas('fileAttente.service', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->latest()->paginate(5);
        } else {
            $tickets = Ticket::latest()->paginate(5);
        }

        return response()->json($this->addServiceAndAgenceNames($tickets));
    }

    public function getAgenceTickets(Agence $agence)
    {
        if (auth()->user()->role === 'AGENT' && auth()->user()->agence->id != $agence->id) {
            return response()->json("Accés refusé", 403);
        }

        $tickets = collect();
        foreach ($agence->services as $service) {
            $tickets = $tickets->merge($this->getLatestTickets($service->fileAttente()->latest()->first()));
        }

        $paginatedTickets = $this->paginateCollection($tickets, 3);

        return response()->json($this->addServiceAndAgenceNames($paginatedTickets));
    }

    private function getLatestTickets($fileAttente, $perPage = null)
    {
        return $fileAttente ? $fileAttente->tickets()->paginate($perPage) : collect()->paginate($perPage);
    }

    private function addServiceAndAgenceNames($tickets)
    {
        foreach ($tickets as $ticket) {
            $ticket->nom_service = $ticket->service->nom;
            $ticket->nom_agence = $ticket->service->agence->nom;
        }

        return $tickets;
    }

    private function paginateCollection($collection, $perPage)
    {
        $currentPage = (int) request()->input('page', 1);

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $collection->forPage($currentPage, $perPage),
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
