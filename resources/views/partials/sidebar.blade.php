<ul class="nav flex-column py-3">
    @if(auth()->user()->isAdmin())
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> {{ __('messages.dashboard') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.patients.index') }}"><i class="bi bi-people"></i> {{ __('messages.patients') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.doctors.index') }}"><i class="bi bi-person-badge"></i> {{ __('messages.doctors') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.appointments.index') }}"><i class="bi bi-calendar-check"></i> {{ __('messages.appointments') }}</a></li>
    @elseif(auth()->user()->isDoctor())
        <li class="nav-item"><a class="nav-link" href="{{ route('doctor.dashboard') }}"><i class="bi bi-speedometer2"></i> {{ __('messages.dashboard') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('doctor.appointments.index') }}"><i class="bi bi-calendar-check"></i> {{ __('messages.appointments') }}</a></li>
    @elseif(auth()->user()->isPatient())
        <li class="nav-item"><a class="nav-link" href="{{ route('patient.dashboard') }}"><i class="bi bi-speedometer2"></i> {{ __('messages.dashboard') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('patient.appointments.index') }}"><i class="bi bi-calendar-check"></i> {{ __('messages.appointments') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('patient.appointments.create') }}"><i class="bi bi-plus-circle"></i> {{ __('messages.book_appointment') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('patient.reports.index') }}"><i class="bi bi-file-medical"></i> {{ __('messages.reports') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('patient.contact.create') }}"><i class="bi bi-envelope"></i> {{ __('messages.contact_admin') }}</a></li>
    @endif
</ul>
