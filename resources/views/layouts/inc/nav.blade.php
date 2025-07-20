  <nav class="header-nav ">
    <ul class="d-flex align-items-center">

    <!-- Departments -->
    <li class="nav-item">
        <a class="nav-link px-3" href="{{ url('/departments') }}">
        <i class="bi bi-diagram-3"></i> Department
        </a>
    </li>

    <!-- Employees -->
    <li class="nav-item">
        <a class="nav-link px-3" href="{{ url('/employees') }}">
        <i class="bi bi-people"></i> Employees
        </a>
    </li>

    <!-- Absensi -->
    <li class="nav-item">
        <a class="nav-link px-3" href="{{ url('/') }}">
        <i class="bi bi-calendar-check"></i> Absensi
        </a>
    </li>

    <!-- Absensi Log -->
    <li class="nav-item">
        <a class="nav-link px-3" href="{{ url('/absensi-log') }}">
        <i class="bi bi-journal-text"></i> Absensi Log
        </a>
    </li>

    </ul>
  </nav>
