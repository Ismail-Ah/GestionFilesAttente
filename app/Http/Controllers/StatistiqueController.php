<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Agence;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Files_Attente;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\IsEmpty;

class StatistiqueController extends Controller
{
    


    private function calculateStatistics($fileAttente)
    {
        $clientsEnAttente = $fileAttente->ClientsEnAttentes;
        $clientsServis = $fileAttente->ClientsTraites;
        $tempsMoyenAttente = $fileAttente->tempsMoyenAttente;
    
        return [
            'clientsEnAttente' => $clientsEnAttente,
            'clientsServis' => $clientsServis,
            'tempsMoyenAttente' => $tempsMoyenAttente,
        ];
    }
    
    public function getServiceStatistiques(Service $service)
    {
        if (auth()->user()->role === 'AGENT' && auth()->user()->id != $service->user_id) {
            return response()->json('Accès Refusé');
        }
        
        $fileAttente = $service->fileAttente()->latest()->first();
        $statistics = $fileAttente ? $this->calculateStatistics($fileAttente) : [
            'clientsEnAttente' => 0,
            'clientsServis' => 0,
            'tempsMoyenAttente' => 0,
        ];
    
        return response()->json($statistics);
    }
    
    private function agenceStatistiques(Agence $agence, $userId = null)
    {
        $clientsEnAttente = 0;
        $clientsServis = 0;
        $tempsMoyenAttente = 0;
        $i = 0;
        
        $services = $userId ? $agence->services->where('user_id', $userId) : $agence->services;
    
        foreach ($services as $service) {
            $fileAttente = $service->fileAttente()->latest()->first();
            if ($fileAttente) {
                $statistics = $this->calculateStatistics($fileAttente);
                $clientsServis += $statistics['clientsServis'];
                $clientsEnAttente += $statistics['clientsEnAttente'];
                $tempsMoyenAttente += $statistics['tempsMoyenAttente'];
                $i++;
            }
        }
    
        $averageTempsMoyenAttente = $i > 0 ? $tempsMoyenAttente / $i : 0;
    
        return [
            'clientsEnAttente' => $clientsEnAttente,
            'clientsServis' => $clientsServis,
            'tempsMoyenAttente' => $averageTempsMoyenAttente,
        ];
    }
    
    public function getAgenceStatistiques(Agence $agence)
    {
        if (auth()->user()->role === 'AGENT' && auth()->user()->agence->id != $agence->id) {
            return response()->json('Accès Refusé');
        }
    
        $userId = auth()->user()->role === 'AGENT' ? auth()->user()->id : null;
        $statistiques = $this->agenceStatistiques($agence, $userId);
    
        return response()->json($statistiques);
    }
    
    public function getAgencesStatistiques()
    {
        $clientsEnAttente = 0;
        $clientsServis = 0;
        $tempsMoyenAttente = 0;
        $i = 0;
    
        if (auth()->user()->role === 'AGENT') {
            $agencies = auth()->user()->services()->latest()->first()->agence->all();
        } else {
            $agencies = Agence::all();
        }
    
        foreach ($agencies as $agence) {
            $statistics = $this->agenceStatistiques($agence);
            $clientsServis += $statistics['clientsServis'];
            $clientsEnAttente += $statistics['clientsEnAttente'];
            $tempsMoyenAttente += $statistics['tempsMoyenAttente'];
            $i++;
        }
    
        $averageTempsMoyenAttente = $i > 0 ? $tempsMoyenAttente / $i : 0;
    
        return response()->json([
            'clientsEnAttente' => $clientsEnAttente,
            'clientsServis' => $clientsServis,
            'tempsMoyenAttente' => $averageTempsMoyenAttente,
        ]);
    }
    






    private function LineChartStat($fils, $l, $time) {
        // Determine the data structure based on time
        if ($time == 1) {
            // Hourly data from 8 AM to 7 PM
            $data = array_fill(0, 5, array_fill(0, 12, 0)); // 12 hours
            $data[] = 0; // Total Clients
            $data[] = 0; // Clients Non Servis
            $data[] = 0; // Clients Servis
            $data[] = 0; // Temps Moyen d'Attente
        } elseif ($time == 365) {
            // Monthly data for the last 12 months
            $data = array_fill(0, 5, array_fill(0, 12, 0)); // 12 months
            $data[] = 0; // Total Clients
            $data[] = 0; // Clients Non Servis
            $data[] = 0; // Clients Servis
            $data[] = 0; // Temps Moyen d'Attente
        } else {
            // General case
            $data = array_fill(0, 5, array_fill(0, $time, 0));
            $data[] = 0; // Total Clients
            $data[] = 0; // Clients Non Servis
            $data[] = 0; // Clients Servis
            $data[] = 0; // Temps Moyen d'Attente
        }
        
        $j = count($data[0]) - 1; // Start from the end
        $TM = 0;
        $CT = 0;
        $CNT = 0;
        $len_fils = $fils->count();
        
        foreach ($fils as $fil) {
            if ($time == 1) {
                $tickets = $fil->tickets;
                foreach ($tickets as $ticket) {
                    if ($ticket->statut=='EN_ATTENT'){
                        $datetime = new DateTime($ticket->created_at);
                        $hour = $datetime->format('H');
                        $index = $hour - 8;
                        if($index>=12 || $index<0) continue;
                        $data[1][$index]+=1;
                    }
                    else{
                        $datetime = new DateTime($ticket->updated_at);
                        $hour = $datetime->format('H');
                        $index = $hour - 8;
                        if($index>=12 || $index<0) continue;
                        $data[0][$index]+=1;
                    }
                    $data[2][$index] = $data[0][$index] + $data[1][$index];
                    $data[3][$index] = ($data[0][$index] + $data[1][$index]) ? (($data[0][$index] / ($data[0][$index] + $data[1][$index])) * 60) / $l : 0;
                    $data[4][$index] = ($data[0][$index] + $data[1][$index]) ? ($data[0][$index] / ($data[0][$index] + $data[1][$index])) * 100 / $l : 0;
                    

                }
                $TM += $fil->tempsMoyenAttente /(60*60* $len_fils);
                $CT += $fil->ClientsTraites;
                $CNT += $fil->ClientsEnAttentes;

            } elseif ($time == 365) {
                // Monthly data
                $month = date('n', strtotime($fil->created_at)) - 1;
                $data[0][$month] += $fil->ClientsTraites;
                $data[1][$month] += $fil->ClientsEnAttentes;
                $data[2][$month] = $data[0][$month] + $data[1][$month];
                $data[3][$month] += ($fil->tempsMoyenAttente / 60) / $l;
                $data[4][$month] = ($data[0][$month] + $data[1][$month]) ? ($data[0][$month] / ($data[0][$month] + $data[1][$month])) * 100 / $l : 0;
                $TM += $data[3][$month] / $len_fils;
                $CT += $data[0][$month];
                $CNT += $data[1][$month];
            } else {
                // General case
                $data[0][$j] = $fil->ClientsTraites;
                $data[1][$j] = $fil->ClientsEnAttentes;
                $data[2][$j] = $data[0][$j] + $data[1][$j];
                $data[3][$j] = ($fil->tempsMoyenAttente / 60) / $l;
                $data[4][$j] = ($data[0][$j] + $data[1][$j]) ? ($data[0][$j] / ($data[0][$j] + $data[1][$j])) * 100 / $l : 0;
                $TM += $data[3][$j] / $len_fils;
                $CT += $data[0][$j];
                $CNT += $data[1][$j];
                $j--;
        
                if ($j < 0) {
                    break;
                }
            }
        }
        
        $data[5] = $CT; // Total Clients
        $data[6] = $CNT; // Clients Non Servis
        $data[7] = $TM;  // Average Wait Time
        
        return $data;
    }
    
    public function getLineChartStatService(Service $service, $time) {
        $fileAttentes = $service->fileAttente()->latest()->take($time)->get();
        $data = $this->LineChartStat($fileAttentes, 1, $time);
        return response()->json($data); 
    }
    
    private function LineChartStatAgence(Agence $agence, $time) {

        $services = $agence->services;
        if ($time == 1) {
            $data = array_fill(0, 5, array_fill(0, 12, 0)); // 12 hours
        } elseif ($time == 365) {
            $data = array_fill(0, 5, array_fill(0, 12, 0)); // 12 months
        } else {
            $data = array_fill(0, 5, array_fill(0, $time, 0));
        }
        $data[] = 0; // Total Clients
        $data[] = 0; // Clients Non Servis
        $data[] = 0; // Clients Servis
        $data[] = 0; // Temps Moyen d'Attente
        $length_services = $services->count();
 
        foreach ($services as $service) {
            $fils = $service->fileAttente()->latest()->take($time)->get();
            $data_2 = $this->LineChartStat($fils, $length_services, $time);
            // Ensure data_2 is an array
            if (is_array($data_2)) {
                for ($i = 0; $i < count($data_2); $i++) {
                    if (is_array($data_2[$i])) {
                        for ($j = 0; $j < count($data_2[$i]); $j++) {
                            $data[$i][$j] += $data_2[$i][$j];
                        }
                    } else {

                        $data[$i] += $data_2[$i];
                    }
                }
            }
        }
        
        return $data;
    }
    
    public function getLineChartStatAgence(Agence $agence, $time) {
        $data = $this->LineChartStatAgence($agence, $time);
        return response()->json($data); 
    }
    
    public function getLineChartStatAgences($time) {
        
        $agences = Agence::all();
        if ($time == 1) {
            
            $data = array_fill(0, 5, array_fill(0, 12, 0)); // 12 hours
        } elseif ($time == 365) {
            $data = array_fill(0, 5, array_fill(0, 12, 0)); // 12 months
        } else {
            $data = array_fill(0, 5, array_fill(0, $time, 0));
        }
        $data[] = 0; // Total Clients
        $data[] = 0; // Clients Non Servis
        $data[] = 0; // Clients Servis
        $data[] = 0; // Temps Moyen d'Attente
        $l = $agences->count();
        foreach ($agences as $agence) {
            $data_2 = $this->LineChartStatAgence($agence, $time);
            // Ensure data_2 is an array
            if (is_array($data_2)) {    
                for ($i= 0; $i < count($data_2); $i++) {
                    if (is_array($data_2[$i])) {
                        for ($j = 0; $j < count($data_2[$i]); $j++) {
                            $data[$i][$j] += $data_2[$i][$j];
                        }
                    } else {
                        if($i==7){
                            $data[$i] += $data_2[$i]/$l;    
                        }
                        else $data[$i] += $data_2[$i];
                    }
                }
            }
        }
        
        return response()->json($data); 
    }
    
    









    private function TotalClientsTraiteEnAgence($agence) {
        // Utiliser une seule requête pour obtenir le total des clients traités
        $clientsTraites = $agence->services()
            ->join('files_attentes', 'services.id', '=', 'files_attentes.service_id')
            ->where('files_attentes.created_at', '>=', now()->subDays(30))
            ->sum('files_attentes.ClientsTraites');
    
        return $clientsTraites;
    }
    private function TotalClientsNonTraitesEnAgence($agence) {
        // Utiliser une seule requête pour obtenir le total des clients traités
        $clientsNonTraites = $agence->services()
            ->join('files_attentes', 'services.id', '=', 'files_attentes.service_id')
            ->where('files_attentes.created_at', '>=', now()->subDays(30))
            ->sum('files_attentes.ClientsEnAttentes');
    
        return $clientsNonTraites;
    }
    private function TempsMoyenEnAgence($agence) {
        $tempsMoyen = $agence->services()
            ->join('files_attentes', 'services.id', '=', 'files_attentes.service_id')
            ->where('files_attentes.created_at', '>=', now()->subDays(30))
            ->avg('files_attentes.tempsMoyenAttente');
    
        return $tempsMoyen;
    }
    public function getTopAgences($type) {
        $data = [];
        $agencies = [];
        $cl = SORT_DESC;
        $agences = Agence::all();
        $param='';
        foreach ($agences as $agence) {
            if ($type=='tauxDeServire'){
                $val1 = $this->TotalClientsTraiteEnAgence($agence);
                $val2 = $this->TotalClientsNonTraitesEnAgence($agence);
                $val3 = $val1+$val2;
                $val = $val3? ($val1 /$val3)*100:0;
                $param='%';
            }
            elseif ($type=='nmbClientsServis') {
                $val = $this->TotalClientsTraiteEnAgence($agence);
            }
            elseif ($type=='nmbClients') {
                $val1 = $this->TotalClientsTraiteEnAgence($agence);
                $val2 = $this->TotalClientsNonTraitesEnAgence($agence);
                $val = $val1+$val2;
            }
            elseif ($type=='nmbClientsNonServis') {
                $val = $this->TotalClientsNonTraitesEnAgence($agence);
                $cl = SORT_ASC;
            }
            elseif($type='tempsMoyenAttente'){
                $val = $this->TempsMoyenEnAgence($agence);
                $cl = SORT_ASC;
                $param='h';
            }    
            $data[] = $val;
            $agencies[] = $agence;
        }
        array_multisort($data, $cl, $agencies);
        $data = array_slice($data, 0, 3);
        $data[]=$param;
        $agencies = array_slice($agencies, 0, 3);
        return response()->json(["data" => $data, "agences" => $agencies]);
    }
    public function getTopServices($type) {
        $data = [];
        $services = Service::all();
        $cl = SORT_DESC;
        $param = '';
        $query = Service::join('files_attentes', 'services.id', '=', 'files_attentes.service_id')
            ->where('files_attentes.created_at', '>=', now()->subDays(30));
        
        foreach ($services as $service) {
            $serviceQuery = clone $query; // Clone the query builder
            $serviceQuery = $serviceQuery->where('services.id', $service->id);
        
            if ($type == 'tauxDeServire') {
                $val1 = $serviceQuery->sum('files_attentes.ClientsTraites');
                $val2 = $serviceQuery->sum('files_attentes.ClientsEnAttentes');
                $val3 = $val1 + $val2;
                $val = $val3 ? ($val1 / $val3) * 100 : 0;
                $param = '%';
            } elseif ($type == 'nmbClientsServis') {
                $val = $serviceQuery->sum('files_attentes.ClientsTraites');
            } elseif ($type == 'nmbClients') {
                $val = $serviceQuery->sum(DB::raw('files_attentes.ClientsTraites + files_attentes.ClientsEnAttentes'));
            } elseif ($type == 'nmbClientsNonServis') {
                $val = $serviceQuery->sum('files_attentes.ClientsEnAttentes');
                $cl = SORT_ASC;
            } elseif ($type == 'tempsMoyenAttente') {
                $val = $serviceQuery->avg('files_attentes.tempsMoyenAttente');
                $cl = SORT_ASC;
                $param = 'h';
            }
        
            $data[] = [
                'service' => $service,
                'value' => $val
            ];
        }
        
        usort($data, function ($a, $b) use ($cl) {
            if ($a['value'] == $b['value']) {
                return 0;
            }
            return ($cl == SORT_DESC) ? ($b['value'] <=> $a['value']) : ($a['value'] <=> $b['value']);
        });
        
        $data = array_slice($data, 0, 3);
        $topServices = array_map(function ($item) {
            return $item['service'];
        }, $data);
        $values = array_map(function ($item) {
            return $item['value'];
        }, $data);
        
        $values[] = $param;
        
        return response()->json(["data" => $values, "services" => $topServices]);
    }
    public function getAgenceTopServices(Agence $agence,$type) {
        $data = [];
        $services = $agence->services;
        $cl = SORT_DESC;
        $param = '';
        $query = Service::join('files_attentes', 'services.id', '=', 'files_attentes.service_id')
            ->where('files_attentes.created_at', '>=', now()->subDays(30));
        
        foreach ($services as $service) {
            $serviceQuery = clone $query; // Clone the query builder
            $serviceQuery = $serviceQuery->where('services.id', $service->id);
        
            if ($type == 'tauxDeServire') {
                $val1 = $serviceQuery->sum('files_attentes.ClientsTraites');
                $val2 = $serviceQuery->sum('files_attentes.ClientsEnAttentes');
                $val3 = $val1 + $val2;
                $val = $val3 ? ($val1 / $val3) * 100 : 0;
                $param = '%';
            } elseif ($type == 'nmbClientsServis') {
                $val = $serviceQuery->sum('files_attentes.ClientsTraites');
            } elseif ($type == 'nmbClients') {
                $val = $serviceQuery->sum(DB::raw('files_attentes.ClientsTraites + files_attentes.ClientsEnAttentes'));
            } elseif ($type == 'nmbClientsNonServis') {
                $val = $serviceQuery->sum('files_attentes.ClientsEnAttentes');
                $cl = SORT_ASC;
            } elseif ($type == 'tempsMoyenAttente') {
                $val = $serviceQuery->avg('files_attentes.tempsMoyenAttente');
                $cl = SORT_ASC;
                $param = 'h';
            }
        
            $data[] = [
                'service' => $service,
                'value' => $val
            ];
        }
        
        usort($data, function ($a, $b) use ($cl) {
            if ($a['value'] == $b['value']) {
                return 0;
            }
            return ($cl == SORT_DESC) ? ($b['value'] <=> $a['value']) : ($a['value'] <=> $b['value']);
        });
        
        $data = array_slice($data, 0, 3);
        $topServices = array_map(function ($item) {
            return $item['service'];
        }, $data);
        $values = array_map(function ($item) {
            return $item['value'];
        }, $data);
        
        $values[] = $param;
        
        return response()->json(["data" => $values, "services" => $topServices]);
    }
    
    
}
