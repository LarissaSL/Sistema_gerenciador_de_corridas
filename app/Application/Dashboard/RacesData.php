<?php

namespace App\Application\Dashboard;

use App\Models\races\RacesModel;
use Carbon\Carbon;

class RacesData
{
    public function execute()
    {
        return $this->getRacesLastSixMonths();
    }

    /**
     * Obtém os dados das corridas dos últimos 6 meses
     *
     * @return array
     */
    public function getRacesLastSixMonths(): array
    {
        $endDate = Carbon::now()->endOfMonth();
        $startDate = Carbon::now()->subMonths(5)->startOfMonth();

        // Obter todas as corridas dos últimos 6 meses, convertendo date para Carbon
        $races = RacesModel::whereBetween('date', [$startDate, $endDate])
            ->get()
            ->map(function($race) {
                $race->date = Carbon::parse($race->date); // Converter string para Carbon
                return $race;
            })
            ->groupBy(function($race) {
                return $race->date->format('Y-m');
            });

        // Inicializar arrays para armazenar os resultados
        $months = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $monthKey = $currentDate->format('Y-m');
            $monthName = $currentDate->format('F Y');
            
            $months[$monthKey] = [
                'month_name' => $monthName,
                'total' => 0,
                'avulsas' => 0,
                'campeonatos' => 0,
                'avulsas_percentage' => 0,
                'campeonatos_percentage' => 0
            ];
            
            $currentDate->addMonth();
        }

        // Calcular totais por mês
        foreach ($races as $month => $monthRaces) {
            $avulsas = $monthRaces->whereNull('championship_id')->count();
            $campeonatos = $monthRaces->whereNotNull('championship_id')->count();
            $total = $monthRaces->count();

            $months[$month] = [
                'month_name' => Carbon::createFromFormat('Y-m', $month)->format('F Y'),
                'total' => $total,
                'avulsas' => $avulsas,
                'campeonatos' => $campeonatos,
                'avulsas_percentage' => $total > 0 ? round(($avulsas / $total) * 100, 2) : 0,
                'campeonatos_percentage' => $total > 0 ? round(($campeonatos / $total) * 100, 2) : 0
            ];
        }

        // Calcular totais gerais dos 6 meses
        $totalAvulsas = array_sum(array_column($months, 'avulsas'));
        $totalCampeonatos = array_sum(array_column($months, 'campeonatos'));
        $grandTotal = $totalAvulsas + $totalCampeonatos;

        return [
            'months' => array_values($months),
            'totals' => [
                'avulsas' => $totalAvulsas,
                'campeonatos' => $totalCampeonatos,
                'total' => $grandTotal,
                'avulsas_percentage' => $grandTotal > 0 ? round(($totalAvulsas / $grandTotal) * 100, 2) : 0,
                'campeonatos_percentage' => $grandTotal > 0 ? round(($totalCampeonatos / $grandTotal) * 100, 2) : 0
            ],
            'period' => [
                'start' => $startDate->format('F Y'),
                'end' => $endDate->format('F Y')
            ]
        ];
    }
}