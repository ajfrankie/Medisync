<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">@lang('translation.Menu')</li>

                {{-- ================= PATIENT ACCESS ================= --}}
                @if (Auth::user()->isPatient())
                    <li class="{{ request()->routeIs('admin.dashboard') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                            <i class="bx bx-home-circle"></i>
                            <span>Patient Dashboard</span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('admin.appointment.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.appointment.index') }}" class="waves-effect">
                            <i class="bx bx-calendar"></i>
                            <span>Appointments</span>
                        </a>
                    </li>
                    {{-- 
                    <li class="{{ request()->routeIs('admin.patient.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.patient.index') }}" class="waves-effect">
                            <i class="bx bx-user-circle"></i>
                            <span>Appointment Calender</span>
                        </a>
                    </li> --}}
                    
                    <li class="{{ request()->routeIs('admin.patient.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.prescription.index') }}" class="waves-effect">
                            <i class="bx bx-user-circle"></i>
                            <span>Prescription Details</span>
                        </a>
                    </li> 

                    <li class="{{ request()->routeIs('admin.ehr.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.ehr.index') }}" class="waves-effect">
                            <i class="bx bx-folder-open"></i>
                            <span>EHR Records</span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('admin.dashboard') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.notification.index') }}" class="waves-effect">
                            <i class="bx bx-bell"></i>
                            <span>Notifications</span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('admin.dashboard') ? 'mm-active' : '' }}">
                        <a href="#" class="waves-effect">
                            <i class="bx bx-chip"></i>
                            <span>AI Assistant</span>
                        </a>
                    </li>
                @endif


                {{-- ================= DOCTOR ACCESS ================= --}}
                @if (Auth::user()->isDoctor())
                    <li class="{{ request()->routeIs('admin.doctor-dashboard.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.doctor-dashboard.index') }}" class="waves-effect">
                            <i class="bx bx-home-circle"></i>
                            <span>Doctor Dashboard</span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('admin.appointment.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.appointment.index') }}" class="waves-effect">
                            <i class="bx bx-calendar"></i>
                            <span>Appointments</span>
                        </a>
                    </li>

                    <li
                        class="{{ request()->routeIs('admin.appointment.viewAppointmentDetails') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.appointment.viewAppointmentDetails', Auth::user()->doctor->id ?? '') }}"
                            class="waves-effect">
                            <i class="bx bx-user-circle"></i>
                            <span>Appointment Calender</span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('admin.ehr.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.ehr.index') }}" class="waves-effect">
                            <i class="bx bx-folder-open"></i>
                            <span>EHR Records</span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('admin.notification.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.notification.index') }}" class="waves-effect">
                            <i class="bx bx-bell"></i>
                            <span>Notifications</span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('admin.dashboard') ? 'mm-active' : '' }}">
                        <a href="#" class="waves-effect">
                            <i class="bx bx-chip"></i>
                            <span>AI Assistant</span>
                        </a>
                    </li>

                    {{-- <li>
                        <a href="javascript:void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-cog"></i><span>Settings</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('admin.doctor.index') }}">Doctors</a></li>
                            <li><a href="{{ route('admin.nurse.index') }}">Nurses</a></li>
                            <li><a href="{{ route('admin.patient.index') }}">Patients</a></li>
                        </ul>
                    </li> --}}
                @endif


                {{-- ================= ADMIN / NURSE ACCESS ================= --}}
                @if (Auth::user()->isAdmin() || Auth::user()->isNurse())
                    <li class="{{ request()->routeIs('admin.dashboard') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                            <i class="bx bx-home-circle"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('admin.appointment.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.appointment.index') }}" class="waves-effect">
                            <i class="bx bx-calendar"></i>
                            <span>Appointments</span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('admin.doctor.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.doctor.index') }}" class="waves-effect">
                            <i class="bx bx-user-circle"></i>
                            <span>Doctors</span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('admin.patient.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.patient.index') }}" class="waves-effect">
                            <i class="bx bx-user"></i>
                            <span>Patients</span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('admin.ehr.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.ehr.index') }}" class="waves-effect">
                            <i class="bx bx-folder-open"></i>
                            <span>EHR Records</span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('admin.dashboard') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                            <i class="bx bx-chat"></i>
                            <span>AI Chatbot Logs</span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('admin.dashboard') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.notification.index') }}" class="waves-effect">
                            <i class="bx bx-bell"></i>
                            <span>Notifications</span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('admin.dashboard') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                            <i class="bx bx-chip"></i>
                            <span>AI Assistant</span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('admin.vital.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.vital.index') }}" class="waves-effect">
                            <i class="bx bx-chip"></i>
                            <span>Vitals</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-cog"></i><span>Settings</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('admin.doctor.index') }}">Doctors</a></li>
                            <li><a href="{{ route('admin.nurse.index') }}">Nurses</a></li>
                            <li><a href="{{ route('admin.patient.index') }}">Patients</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<!-- Left Sidebar End -->
