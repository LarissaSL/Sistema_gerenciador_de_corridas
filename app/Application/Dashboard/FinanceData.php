<?php

namespace App\Application\Dashboard;

use App\Models\inscriptions\InscriptionsModel;
use Carbon\Carbon;

class FinanceData
{
    public function execute()
    {
        return $this->getPaymentMonthlyStatus();
    }

    /**
     * Calcula a porcentagem de um valor em relação a outro
     *
     * @param int $count
     * @param int $total
     * @return float
     */
    private function calculatePercentage(int $count, int $total): float
    {
        if ($total <= 0) {
            return 0.0;
        }
        return ($count / $total) * 100;
    }

    /**
     * Obtém o status de pagamento mensal
     *
     * @return array
     */
    public function getPaymentMonthlyStatus(): array
    {
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // Corridas pagas (payment_status = 'Confirmado')
        $currentMonthPaid = InscriptionsModel::where('payment_status', 'Confirmado')
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();

        $lastMonthPaid = InscriptionsModel::where('payment_status', 'Confirmado')
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->count();

        // Cálculo da variação percentual
        $paidPercentageChange = $lastMonthPaid > 0 
            ? (($currentMonthPaid - $lastMonthPaid) / $lastMonthPaid) * 100
            : ($currentMonthPaid > 0 ? 100 : 0);

        // Métodos de pagamento este mês
        $currentMonthMethods = InscriptionsModel::where('payment_status', 'Confirmado')
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->selectRaw('payment_method, COUNT(*) as count')
            ->groupBy('payment_method')
            ->get()
            ->keyBy('payment_method');

        $lastMonthMethods = InscriptionsModel::where('payment_status', 'Confirmado')
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->selectRaw('payment_method, COUNT(*) as count')
            ->groupBy('payment_method')
            ->get()
            ->keyBy('payment_method');

        // Totais
        $currentMonthTotal = $currentMonthMethods->sum('count');
        $lastMonthTotal = max(1, $lastMonthMethods->sum('count'));

        // Percentuais dos métodos de pagamento
        $methodPercentages = [
            'card' => [
                'current_percentage' => round($this->calculatePercentage(
                    $currentMonthMethods->get(0)?->count ?? 0,
                    $currentMonthTotal
                ), 2),
                'last_percentage' => round($this->calculatePercentage(
                    $lastMonthMethods->get(0)?->count ?? 0,
                    $lastMonthTotal
                ), 2),
            ],
            'boleto' => [
                'current_percentage' => round($this->calculatePercentage(
                    $currentMonthMethods->get(1)?->count ?? 0,
                    $currentMonthTotal
                ), 2),
                'last_percentage' => round($this->calculatePercentage(
                    $lastMonthMethods->get(1)?->count ?? 0,
                    $lastMonthTotal
                ), 2),
            ],
            'pix' => [
                'current_percentage' => round($this->calculatePercentage(
                    $currentMonthMethods->get(2)?->count ?? 0,
                    $currentMonthTotal
                ), 2),
                'last_percentage' => round($this->calculatePercentage(
                    $lastMonthMethods->get(2)?->count ?? 0,
                    $lastMonthTotal
                ), 2),
            ],
            'transfer' => [
                'current_percentage' => round($this->calculatePercentage(
                    $currentMonthMethods->get(3)?->count ?? 0,
                    $currentMonthTotal
                ), 2),
                'last_percentage' => round($this->calculatePercentage(
                    $lastMonthMethods->get(3)?->count ?? 0,
                    $lastMonthTotal
                ), 2),
            ],
        ];

        return [
            'paid_races' => [
                'current' => $currentMonthPaid,
                'last' => $lastMonthPaid,
                'percentage_change' => round($paidPercentageChange, 2),
                'trend' => $paidPercentageChange >= 0 ? 'up' : 'down',
            ],
            'payment_methods' => $methodPercentages,
            'time_periods' => [
                'current_month' => $currentMonthStart->format('F Y'),
                'last_month' => $lastMonthStart->format('F Y'),
            ],
            'totals' => [
                'current' => $currentMonthTotal,
                'last' => $lastMonthMethods->sum('count'),
            ],
        ];
    }
}