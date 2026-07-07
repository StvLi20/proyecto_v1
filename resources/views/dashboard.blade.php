@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Tarjetas de estadísticas --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded p-3" style="background: rgba(99,102,241,0.1)">
                    <i class="bi bi-code-square fs-3" style="color:#6366f1"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Scripts</div>
                    <div class="fw-bold fs-3">{{ $totalScripts }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded p-3" style="background: rgba(16,185,129,0.1)">
                    <i class="bi bi-star fs-3" style="color:#10b981"></i>
                </div>
                <div>
                    <div class="text-muted small">Mis Favoritos</div>
                    <div class="fw-bold fs-3">{{ $totalFavoritos }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded p-3" style="background: rgba(245,158,11,0.1)">
                    <i class="bi bi-tags fs-3" style="color:#f59e0b"></i>
                </div>
                <div>
                    <div class="text-muted small">Categorías</div>
                    <div class="fw-bold fs-3">{{ $totalCategorias }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded p-3" style="background: rgba(59,130,246,0.1)">
                    <i class="bi bi-people fs-3" style="color:#3b82f6"></i>
                </div>
                <div>
                    <div class="text-muted small">Usuarios</div>
                    <div class="fw-bold fs-3">{{ $totalUsuarios }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Gráficas --}}
<div class="row g-4 mb-4">

    {{-- Scripts por motor --}}
    <div class="col-md-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-bar-chart me-2 text-muted"></i>Scripts por Motor
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartMotores" height="200"></canvas>
            </div>
        </div>
    </div>

    {{-- Scripts por categoría --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-pie-chart me-2 text-muted"></i>Scripts por Categoría
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartCategorias" height="200"></canvas>
            </div>
        </div>
    </div>

    {{-- Scripts por tipo --}}
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-pie-chart me-2 text-muted"></i>SQL vs Bash
                </h6>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <canvas id="chartTipo" height="200"></canvas>
            </div>
        </div>
    </div>

</div>

{{-- Tablas --}}
<div class="row g-4">

    {{-- Últimos scripts --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-clock-history me-2 text-muted"></i>Últimos scripts agregados
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Título</th>
                                <th>Motor</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ultimosScripts as $script)
                            <tr>
                                <td>
                                    <a href="{{ route('scripts.show', $script) }}" class="text-decoration-none fw-semibold">
                                        {{ Str::limit($script->titulo, 40) }}
                                    </a>
                                </td>
                                <td>
                                    @foreach($script->motores as $motor)
                                        <span class="badge bg-primary bg-opacity-10 text-primary me-1">
                                            {{ $motor->nombre }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="text-muted small">{{ $script->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    No hay scripts registrados
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Top favoritos --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-star-fill text-warning me-2"></i>Scripts más populares
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Título</th>
                                <th>Categoría</th>
                                <th class="text-center">Favoritos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topFavoritos as $script)
                            <tr>
                                <td>
                                    <a href="{{ route('scripts.show', $script) }}" class="text-decoration-none fw-semibold">
                                        {{ Str::limit($script->titulo, 40) }}
                                    </a>
                                </td>
                                <td class="text-muted small">{{ $script->categoria->nombre }}</td>
                                <td class="text-center">
                                    <span class="badge bg-warning bg-opacity-10 text-warning">
                                        <i class="bi bi-star-fill me-1"></i>{{ $script->favoritos_count }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    No hay favoritos registrados
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Datos desde Laravel
    const dataMotores    = @json($scriptsPorMotor);
    const dataCategorias = @json($scriptsPorCategoria);
    const dataTipo       = @json($scriptsPorTipo);

    // Colores
    const colores = [
        'rgba(99,102,241,0.8)',
        'rgba(16,185,129,0.8)',
        'rgba(245,158,11,0.8)',
        'rgba(59,130,246,0.8)',
        'rgba(239,68,68,0.8)',
        'rgba(168,85,247,0.8)',
    ];

    // Gráfica de barras - Motores
    new Chart(document.getElementById('chartMotores'), {
        type: 'bar',
        data: {
            labels: dataMotores.map(m => m.nombre),
            datasets: [{
                label: 'Scripts',
                data: dataMotores.map(m => m.total),
                backgroundColor: colores,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    // Gráfica de dona - Categorías
    new Chart(document.getElementById('chartCategorias'), {
        type: 'doughnut',
        data: {
            labels: dataCategorias.map(c => c.nombre),
            datasets: [{
                data: dataCategorias.map(c => c.total),
                backgroundColor: colores,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } }
        }
    });

    // Gráfica de dona - Tipo SQL vs Bash
    new Chart(document.getElementById('chartTipo'), {
        type: 'doughnut',
        data: {
            labels: dataTipo.map(t => t.tipo),
            datasets: [{
                data: dataTipo.map(t => t.total),
                backgroundColor: ['rgba(99,102,241,0.8)', 'rgba(245,158,11,0.8)'],
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } }
        }
    });
</script>
@endpush