<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">@lang('translation.Menu')</li>

                <li>
                    <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-chat">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.appointment.index') }}" class="waves-effect">
                        <i class="bx bx-calendar"></i>
                        <span key="t-chat">Appointments</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.doctor.index') }}" class="waves-effect">
                        <i class="bx bx-user-circle"></i>
                        <span key="t-chat">Doctors</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.patient.index') }}" class="waves-effect">
                        <i class="bx bx-user"></i>
                        <span key="t-chat">Patients</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.ehr.index') }}" class="waves-effect">
                        <i class="bx bx-folder-open"></i>
                        <span key="t-chat">EHR Records</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.dashboard')  }}" class="waves-effect">
                        <i class="bx bx-chat"></i>
                        <span key="t-chat">AI Chatbot Logs</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.dashboard')  }}" class="waves-effect">
                        <i class="bx bx-bell"></i>
                        <span key="t-chat">Notifications</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.dashboard')  }}" class="waves-effect">
                        <i class="bx bx-chip"></i>
                        <span key="t-chat">AI Assistant</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-cog"></i>
                        <span key="t-maps">Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('admin.doctor.index') }}" class="waves-effect">
                                <i class="bx bx-user-circle"></i>
                                <span key="t-chat">Doctors</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.nurse.index') }}" class="waves-effect">
                                <i class="bx bx-user-check"></i>
                                <span key="t-chat">Nurses</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.patient.index') }}" class="waves-effect">
                                <i class="bx bx-user"></i>
                                <span key="t-chat">Patients</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
