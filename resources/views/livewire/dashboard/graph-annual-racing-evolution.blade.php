<div>
    <div class="card evolucao-card">
        <div class="card-header bg-white border-0">
            <h2 class="h5 mb-0">Evolução do ano</h2>
        </div>
        
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-text">Nº de inscrições nas corridas</span>
                        <span class="info-box-number">{{ number_format($totalInscricoes, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-text">Previsão do mês</span>
                        <span class="info-box-number">{{ $mesAtual }} {{ $anoAtual }}</span>
                    </div>
                </div>
            </div>
            
            <div class="filtros mb-4">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <select wire:model.live="mesSelecionado" class="form-control">
                            <option value="">Todos os meses</option>
                            @foreach($meses as $key => $mes)
                                <option value="{{ $key }}" @if($mesSelecionado == $key) selected @endif>
                                    {{ $mes }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <select wire:model.live="anoSelecionado" class="form-control">
                            @foreach($anos as $ano)
                                <option value="{{ $ano }}" @if($anoSelecionado == $ano) selected @endif>
                                    {{ $ano }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="diagrama-container">
                <div class="diagrama-box">
                    <h4>Diagrama</h4>
                    <div class="diagrama-valores">
                        @if($mesSelecionado)
                            <!-- Visualização de mês único -->
                            @php
                                $dadosMes = $dadosGrafico->first();
                            @endphp
                            <div class="valor">{{ number_format($dadosMes['total_inscricoes'], 0, ',', '.') }}</div>
                            <div class="valor">{{ number_format($dadosMes['estimativa'], 0, ',', '.') }}</div>
                            <div class="legenda">Alcançado</div>
                            <div class="legenda">Estimativa</div>
                        @else
                            <!-- Gráfico Chart.js -->
                            <div class="progressivo-container">
                                <div class="progressivo-total">
                                    Total Anual: {{ number_format($totalInscricoes, 0, ',', '.') }} inscrições
                                </div>
                                @isset($chartData)
                                    @if(count($chartData['labels']) > 0)
                                        <div class="chart-container" style="position: relative; height:400px; width:100%">
                                            <canvas id="annualEvolutionChart"></canvas>
                                        </div>
                                    @else
                                        <div class="alert alert-info mt-3">
                                            Nenhum dado disponível para o período selecionado
                                        </div>
                                    @endif
                                @else
                                    <div class="alert alert-warning mt-3">
                                        Dados do gráfico não disponíveis
                                    </div>
                                @endisset
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="diagrama-meses">
                    @foreach($dadosMensais as $mes)
                        <div class="mes-item @if($mes['ativo']) active @endif" 
                             wire:click="setMes('{{ str_pad($mes['mes'], 2, '0', STR_PAD_LEFT) }}')">
                            {{ $mes['nome_mes'] }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {
        const ctx = document.getElementById('annualEvolutionChart');
        
        if (ctx) {
            // Inicializa o gráfico com dados vazios
            const chart = new Chart(ctx, {
                type: 'bar',
                data: { labels: [], datasets: [] },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString('pt-BR');
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label}: ${context.raw.toLocaleString('pt-BR')}`;
                                }
                            }
                        },
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });

            // Atualiza o gráfico quando receber novos dados
            Livewire.on('chartUpdated', (data) => {
                chart.data = data;
                chart.update();
            });
        }
    });
</script>
@endpush