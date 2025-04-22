<?php

namespace App\Application\Dashboard;

use App\Models\inscriptions\InscriptionsModel;
use App\Models\races\RacesModel;
use Illuminate\Support\Collection; // Alterado para Support\Collection
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class EvolutionAnnual
{
    private array $monthNames = [
        '01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril',
        '05' => 'Maio', '06' => 'Junho', '07' => 'Julho', '08' => 'Agosto',
        '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro',
    ];

    /**
     * Executa a consulta de evolução anual
     */
    public function execute(int $year, ?int $month = null): Collection
    {
        return $this->getData($year, $month);
    }

    /**
     * Obtém os dados formatados
     */
    protected function getData(int $year, ?int $month = null): Collection
    {
        $races = $this->getRacesData($year, $month);
        
        // Converter Eloquent Collection para Support Collection se necessário
        if ($races instanceof EloquentCollection) {
            $races = new Collection($races->all());
        }

        return $races->map(function ($race) {
            $inscriptionsCount = $this->getInscriptionsCount($race->ano, $race->mes);
            
            return $this->formatRaceData($race, $inscriptionsCount);
        });
    }

    /**
     * Consulta os dados de corridas (retorna Eloquent Collection)
     */
    protected function getRacesData(int $year, ?int $month = null): EloquentCollection
    {
        $query = RacesModel::query()
            ->selectRaw('MONTH(date) as mes, YEAR(date) as ano')
            ->selectRaw('COUNT(id) as total_corridas')
            ->whereYear('date', $year)
            ->groupBy('mes', 'ano')
            ->orderBy('mes');

        if ($month) {
            $query->whereMonth('date', $month);
        }

        return $query->get();
    }

    protected function getInscriptionsCount(int $year, int $month): int
    {
        return InscriptionsModel::whereHas('race', function($query) use ($year, $month) {
            $query->whereYear('date', $year)
                  ->whereMonth('date', $month);
        })->count();
    }

    protected function formatRaceData($race, int $inscriptionsCount): array
    {
        $month = str_pad($race->mes, 2, '0', STR_PAD_LEFT);
        
        if (!isset($this->monthNames[$month])) {
            $month = '01'; // Valor padrão se o mês for inválido
        }

        return [
            'month' => $month,
            'name_month' => $this->monthNames[$month],
            'year' => $race->ano,
            'total_inscription' => $inscriptionsCount,
            'total_races' => $race->total_corridas,
            'estimated' => $race->total_corridas * 20,
            'completion_percentage' => ($race->total_corridas > 0 && ($race->total_corridas * 20) > 0)
                ? min(round(($inscriptionsCount / ($race->total_corridas * 20)) * 100, 2), 100)
                : 0
        ];
    }
}