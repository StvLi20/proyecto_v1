@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Bienvenida --}}
<p class="text-muted mb-4">Bienvenido, <strong>{{ Auth::user()->nombre }}</strong></p>

{{-- Tarjetas --}}
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

    {{-- Barras - Scripts por motor --}}
    <div class="col-md-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-bar-chart me-2 text-muted"></i>Scripts por Motor
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartMotores" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- Dona - Scripts por categoría --}}
    <div class="col-md-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-pie-chart me-2 text-muted"></i>Scripts por Categoría
                </h6>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <div style="position:relative; width:100%; max-width:260px;">
                    <canvas id="chartCategorias"></canvas>
                    <div style="position:absolute;top:42%;left:50%;transform:translate(-50%,-50%);text-align:center;">
                        <div class="fw-bold fs-3">{{ $totalScripts }}</div>
                        <div class="text-muted" style="font-size:0.75rem;">Scripts</div>
                    </div>
                </div>
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
                                <a href="{{ route('scripts.show', $script) }}" class="text-decoration-none fw-semibold small">
                                    {{ Str::limit($script->titulo, 35) }}
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
                            <td colspan="3" class="text-center text-muted py-3">No hay scripts</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Título</th>
                            <th>Categoría</th>
                            <th class="text-center">⭐</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topFavoritos as $script)
                        <tr>
                            <td>
                                <a href="{{ route('scripts.show', $script) }}" class="text-decoration-none fw-semibold small">
                                    {{ Str::limit($script->titulo, 35) }}
                                </a>
                            </td>
                            <td class="text-muted small">{{ $script->categoria->nombre }}</td>
                            <td class="text-center">
                                <span class="badge bg-warning bg-opacity-10 text-warning">
                                    {{ $script->favoritos_count }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">No hay favoritos</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const dataMotores    = @json($scriptsPorMotor);
    const dataCategorias = @json($scriptsPorCategoria);

    const colores = [
        'rgba(99,102,241,0.85)',
        'rgba(16,185,129,0.85)',
        'rgba(245,158,11,0.85)',
        'rgba(59,130,246,0.85)',
        'rgba(239,68,68,0.85)',
        'rgba(168,85,247,0.85)',
        'rgba(20,184,166,0.85)',
    ];

    // Barras - Motores
    new Chart(document.getElementById('chartMotores'), {
        type: 'bar',
        data: {
            labels: dataMotores.map(m => m.nombre),
            datasets: [{
                label: 'Scripts',
                data: dataMotores.map(m => m.total),
                backgroundColor: colores,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: { grid: { display: false } }
            }
        }
    });

    // Dona - Categorías
    new Chart(document.getElementById('chartCategorias'), {
        type: 'doughnut',
        data: {
            labels: dataCategorias.map(c => c.nombre),
            datasets: [{
                data: dataCategorias.map(c => c.total),
                backgroundColor: colores,
                borderWidth: 2,
                borderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            cutout: '72%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 10 }, padding: 8, boxWidth: 10 }
                }
            }
        }
    });
</script>
@endpush