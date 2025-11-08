<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('build/images/logo.svg') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="17">
                    </span>
                </a>

                <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('build/images/logo-light.svg') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="30">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex">
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="bx bx-bell bx-tada"></i>
                    @if ($unreadCount > 0)
                        <span class="badge bg-danger rounded-pill">{{ $unreadCount }}</span>
                    @endif
                </button>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">

                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0">Notifications</h6>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('admin.notification.index') }}" class="small">View All</a>
                            </div>
                        </div>
                    </div>

                    <div data-simplebar style="max-height: 230px;">
                        @forelse($latestNotifications as $notification)
                            <a href="{{ route('admin.notification.show', $notification->id) }}"
                                class="text-reset notification-item">
                                <div class="d-flex">
                                    <div class="avatar-xs me-3">
                                        <span
                                            class="avatar-title {{ $notification->is_viewed ? 'bg-secondary' : 'bg-primary' }} rounded-circle font-size-16">
                                            <i class="bx bx-bell"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mt-0 mb-1">{{ Str::limit($notification->subject, 30) }}</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">{{ Str::limit($notification->message, 50) }}</p>
                                            <p class="mb-0">
                                                <i class="mdi mdi-clock-outline"></i>
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="text-center text-muted my-2">No notifications</p>
                        @endforelse
                    </div>

                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center"
                            href="{{ route('admin.notification.index') }}">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> View More
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                @php
                    $user = Auth::user();
                    $imagePath = $user->image_path ?? null;
                    $userInitials = strtoupper(substr($user->name, 0, 2));
                @endphp

                <button type="button" class="btn header-item waves-effect d-flex align-items-center gap-2"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    @if ($imagePath)
                        <img class="rounded-circle header-profile-user" src="{{ asset('storage/' . $imagePath) }}"
                            alt="User Avatar" style="width: 36px; height: 36px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center"
                            style="width: 36px; height: 36px; font-weight: bold; font-size: 14px;">
                            {{ $userInitials }}
                        </div>
                    @endif

                    <span class="d-none d-xl-inline-block">{{ ucfirst($user->name) }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    {{-- <a class="dropdown-item d-block" href="#" data-bs-toggle="modal"
                        data-bs-target=".change-password"><i class="bx bx-wrench font-size-16 align-middle me-1"></i>
                        <span key="t-settings">@lang('translation.Settings')</span></a> --}}

                    @php
                        $user = auth()->user();
                    @endphp

                    @if ($user->patient)
                        <a class="dropdown-item d-block"
                            href="{{ route('admin.patient.showPatient', $user->patient->id) }}">
                            <i class="bx bx-wrench font-size-16 align-middle me-1"></i> Profile
                        </a>
                    @elseif($user->doctor)
                        <a class="dropdown-item d-block"
                            href="{{ route('admin.doctor.showDoctor', $user->doctor->id) }}">
                            <i class="bx bx-wrench font-size-16 align-middle me-1"></i> Profile
                        </a>
                    @endif


                    <a class="dropdown-item text-danger" href="javascript:void();"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                            key="t-logout">@lang('translation.Logout')</span></a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
<!--  Change-Password example -->
<div class="modal fade change-password" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="change-password">
                    @csrf
                    <input type="hidden" value="{{ Auth::user()->id }}" id="data_id">
                    <div class="mb-3">
                        <label for="current_password">Current Password <span class="text-danger">*</span></label>
                        <input id="current-password" type="password"
                            class="form-control @error('current_password') is-invalid @enderror"
                            name="current_password" autocomplete="current_password"
                            placeholder="Enter Current Password" value="{{ old('current_password') }}">
                        <div class="text-danger" id="current_passwordError" data-ajax-feedback="current_password">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="newpassword">New Password <span class="text-danger">*</span></label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password"
                            autocomplete="new_password" placeholder="Enter New Password">
                        <div class="text-danger" id="passwordError" data-ajax-feedback="password"></div>
                    </div>

                    <div class="mb-3">
                        <label for="userpassword">Confirm Password <span class="text-danger">*</span></label>
                        <input id="password-confirm" type="password" class="form-control"
                            name="password_confirmation" autocomplete="new_password"
                            placeholder="Enter New Confirm password">
                        <div class="text-danger" id="password_confirmError" data-ajax-feedback="password-confirm">
                        </div>
                    </div>

                    <div class="mt-3 d-grid">
                        <button class="btn btn-primary waves-effect waves-light UpdatePassword"
                            data-id="{{ Auth::user()->id }}" type="submit">Update Password</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
