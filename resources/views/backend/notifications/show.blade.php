@extends('backend.layouts.master')

@section('title', 'Notification Details')

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Notifications @endslot
        @slot('title') Notification Details @endslot
    @endcomponent

    @include('backend.layouts.alert')

    @php
        $user = $notification->user ?? null;
        $avatar = $user && method_exists($user, 'image_path') ? $user->image_path() : null;
        $initials = $user ? strtoupper(substr($user->name, 0, 1)) : '?';

        $appointment = $notification->appointment ?? null;
        $doctor = $appointment->doctor ?? null;
        $patient = $appointment->patient ?? null;

        $statusColors = [
            'pending' => 'warning',
            'confirmed' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
            'next appointment' => 'primary',
        ];
    @endphp

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body d-flex align-items-center p-4 bg-light">
                    {{-- Avatar --}}
                    @if ($avatar)
                        <img src="{{ $avatar }}" alt="Avatar"
                             class="rounded-circle border border-primary me-3"
                             width="80" height="80" style="object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                             style="width: 80px; height: 80px; font-size: 32px; font-weight: bold;">
                            {{ $initials }}
                        </div>
                    @endif

                    {{-- User Info --}}
                    <div>
                        <h4 class="mb-1">{{ $user->name ?? 'Unknown User' }}</h4>
                        <small class="text-muted">{{ $notification->created_at->format('F j, Y, g:i A') }}</small>
                    </div>
                </div>
            </div>

            {{-- Notification Card --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Notification Details</h5>

                    <div class="mb-3">
                        <strong>Subject:</strong>
                        <p class="mb-0">{{ $notification->subject ?? 'No subject' }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Content:</strong>
                        <p class="mb-0">{{ $notification->message ?? 'No content available.' }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Status:</strong>
                        <span class="badge bg-{{ $statusColors[strtolower($notification->status)] ?? 'secondary' }}">
                            {{ ucfirst($notification->status ?? 'pending') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Appointment Card --}}
            @if ($appointment)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Appointment Details</h5>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <strong>Date:</strong>
                                <p class="mb-0">{{ $appointment->appointment_date ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Time:</strong>
                                <p class="mb-0">{{ $appointment->appointment_time ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <strong>Doctor:</strong>
                                <p class="mb-0">{{ $doctor->user->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Patient:</strong>
                                <p class="mb-0">{{ $patient->user->name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <strong>Next Appointment:</strong>
                                <p class="mb-0">{{ $appointment->next_appointment_date ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Notes:</strong>
                                <p class="mb-0">{{ $appointment->notes ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Action Buttons --}}
            <div class="d-flex justify-content-start gap-2 mb-4">
                <a href="{{ route('admin.notification.index') }}" class="btn btn-secondary">
                    <i class="bx bx-left-arrow-alt"></i> Back to Notifications
                </a>

                @if (!$notification->is_viewed)
                    <a href="{{ route('admin.notification.mark-as-read', $notification->id) }}" 
                       class="btn btn-success">
                        <i class="bx bx-check-double"></i> Mark as Read
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
