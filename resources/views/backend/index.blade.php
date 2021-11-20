@extends('layouts.admin_auth_app')

@section('title', 'Dashboard')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <!-- Content Row -->
        <livewire:backend.dashboard.statistics-component />

        <!-- Content Row -->
        <livewire:backend.dashboard.chart-component />

    </div>
    <!-- /.container-fluid -->


@endsection
