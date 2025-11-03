<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Agenda::query()->orderBy('start_date', 'desc');

        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status) {
            $status = $request->status;
            
            // Get semua agenda dulu, lalu filter berdasarkan status accessor
            $allAgendas = $query->get();
            $filteredAgendas = $allAgendas->filter(function($agenda) use ($status) {
                return $agenda->status === $status;
            });
            
            // Convert ke collection dan paginate manual
            $currentPage = $request->get('page', 1);
            $perPage = 10;
            $total = $filteredAgendas->count();
            $currentItems = $filteredAgendas->slice(($currentPage - 1) * $perPage, $perPage)->values();
            
            $agendas = new \Illuminate\Pagination\LengthAwarePaginator(
                $currentItems,
                $total,
                $perPage,
                $currentPage,
                [
                    'path' => $request->url(),
                    'pageName' => 'page',
                    'query' => $request->query()
                ]
            );
        } else {
            // Jika tidak ada filter, tampilkan semua dengan pagination
            $agendas = $query->paginate(10)->withQueryString();
        }

        return view('public.agenda.index', compact('agendas'));
    }
}