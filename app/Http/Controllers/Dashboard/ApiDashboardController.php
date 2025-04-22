<?php

namespace App\Http\Controllers\Dashboard;

use App\Application\Dashboard\EvolutionAnnual;
use App\Application\Dashboard\FinanceData;
use App\Application\Dashboard\RacesData;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiDashboardController extends Controller
{
    public function __construct(
        protected EvolutionAnnual $evolutionAnnual,
        protected FinanceData $financeData,
        protected RacesData $racesData,
    ) {}

    /**
     * Retorna dados de evolução anual de corridas
     * 
     * @param Request $request
     * @param int $year
     * @param int|null $month
     * @return JsonResponse
     */
    public function evolutionAnnual($year, $month = null): JsonResponse
    {
        // Validação dos parâmetros
        $validator = validator([
            'year' => $year,
            'month' => $month
        ], [
            'year' => 'required|digits:4',
            'month' => 'nullable|between:1,12'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Parâmetros inválidos',
                'details' => $validator->errors()
            ], 400);
        }

        try {
            $data = $this->evolutionAnnual->execute($year, $month);

            return response()->json([
                'success' => true,
                'data' => $data,
                'totals' => [
                    'inscriptions' => $data->sum('total_inscription'),
                    'races' => $data->sum('total_races'),
                    'estimated' => $data->sum('estimated')
                ],
                'period' => [
                    'year' => $year,
                    'month' => $month ? str_pad($month, 2, '0', STR_PAD_LEFT) : null
                ]
            ],
            200,
            ['Content-Type' => 'application/json'],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erro ao processar requisição',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Retorna dados financeiros
     * 
     * @return JsonResponse
     */
    public function financeData(): JsonResponse
    {
        try {
            $data = $this->financeData->execute();
            $currentYear = now()->year;
            $currentMonth = now()->month;


            return response()->json([
                'success' => true,
                'data' => $data,
                'period' => [
                    'current_month' => $currentMonth,
                    'last_month' => $currentMonth - 1,
                    'current_year' => $currentYear
                ],
            ],
            200,
            ['Content-Type' => 'application/json'],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            );

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erro ao processar requisição',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Retorna dados de corridas
     * 
     * @return JsonResponse
     */
    public function racesData(): JsonResponse
    {
        try {
            $data = $this->racesData->execute();

            return response()->json([
                'success' => true,
                'data' => $data,
                'periodInNumber' => [
                    'start_date' => now()->subMonths(5)->startOfMonth()->format('Y-m-d'),
                    'end_date' => now()->endOfMonth()->format('Y-m-d')
                ]
            ],
            200,
            ['Content-Type' => 'application/json'],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            );

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erro ao processar dados de corridas',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
