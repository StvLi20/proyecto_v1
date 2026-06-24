@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">
        <i class="bi bi-speedometer2"></i> Dashboard
    </h4>
    <span class="text-muted">Bienvenido, {{ Auth::user()->nombre }}</span>
</div>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 p-3 rounded">
                    <i class="bi bi-code-square fs-3 text-primary"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Scripts</div>
                    <div class="fw-bold fs-4">0</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 p-3 rounded">
                    <i class="bi bi-star fs-3 text-success"></i>
                </div>
                <div>
                    <div class="text-muted small">Mis Favoritos</div>
                    <div class="fw-bold fs-4">0</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-warning bg-opacity-10 p-3 rounded">
                    <i class="bi bi-tags fs-3 text-warning"></i>
                </div>
                <div>
                    <div class="text-muted small">Categorías</div>
                    <div class="fw-bold fs-4">0</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-info bg-opacity-10 p-3 rounded">
                    <i class="bi bi-people fs-3 text-info"></i>
                </div>
                <div>
                    <div class="text-muted small">Usuarios</div>
                    <div class="fw-bold fs-4">0</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection