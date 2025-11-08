@extends('backend.layouts.master')

@section('title', 'Notifications')

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Notifications
        @endslot
        @slot('title')
            Notifications
        @endslot
    @endcomponent

    @include('backend.layouts.alert')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="card-body border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 card-title">Notifications</h5>
                        <a href="{{ route('admin.notification.mark-all-as-read') }}" class="btn btn-soft-dark w-md">
                            <i class="bx bx-check-double"></i> Mark all as Read
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle dt-responsive nowrap w-100 table-check">
                            <thead class="table-light">
                                <tr>
                                    <th>Profile</th>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifications as $notification)
                                    <tr>
                                        <td>
                                            @php
                                                $user = $notification->user;
                                                $avatar =
                                                    $user && method_exists($user, 'image_path')
                                                        ? $user->image_path()
                                                        : null;
                                                $initials = $user ? strtoupper(substr($user->name, 0, 1)) : '?';
                                            @endphp

                                            @if ($avatar)
                                                <img src="{{ $avatar }}" alt="Avatar"
                                                    class="rounded-circle border border-primary" width="50"
                                                    height="50" style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                    style="width: 50px; height: 50px; font-size: 20px; font-weight: bold;">
                                                    {{ $initials }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $notification->subject ?? 'N/A' }}</td>
                                        <td>{{ Str::limit($notification->message, 80) }}</td>
                                        <td>{{ $notification->created_at->diffForHumans() }}</td>
                                        <td class="text-center">
                                            @if ($notification->is_viewed)
                                                <i class="fas fa-envelope-open text-success font-size-18"></i>
                                            @else
                                                <i class="fas fa-envelope text-warning font-size-18"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group text-nowrap">
                                                <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bx bx-dots-horizontal-rounded fs-5" style="color:#898787"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.notification.show', $notification->id) }}">
                                                        <i class="bx bx-show-alt"></i> View
                                                    </a>

                                                    @if (!$notification->is_viewed)
                                                        <a href="{{ route('admin.notification.mark-as-read', $notification->id) }}"
                                                            class="dropdown-item">
                                                            <i class="bx bx-check-double"></i> Mark as Read
                                                        </a>
                                                    @endif

                                                </div>
                                            </div>
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="text-end">
                    <ul class="pagination-rounded">
                        {{ $notifications->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection
