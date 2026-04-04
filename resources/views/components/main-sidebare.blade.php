<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
               href="{{ route('dashboard') }}">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Système RH</div>
            </a>

            <hr class="sidebar-divider my-0">

            <!-- Dashboard -->
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Tableau de bord</span>
                </a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">Gestion</div>

            <!-- Employés -->
            <li class="nav-item {{ request()->routeIs('employers.*') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                   data-target="#collapseEmployers" aria-expanded="false">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Employés</span>
                </a>
                <div id="collapseEmployers"
                     class="collapse {{ request()->routeIs('employers.*') ? 'show' : '' }}"
                     data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Gestion des employés</h6>
                        <a class="collapse-item {{ request()->routeIs('employers.index') ? 'active' : '' }}"
                           href="{{ route('employers.index') }}">
                            <i class="fas fa-list fa-xs mr-1"></i> Liste
                        </a>
                        <a class="collapse-item {{ request()->routeIs('employers.create') ? 'active' : '' }}"
                           href="{{ route('employers.create') }}">
                            <i class="fas fa-plus fa-xs mr-1"></i> Nouvel employé
                        </a>
                    </div>
                </div>
            </li>

            <!-- Affectations -->
            <li class="nav-item {{ request()->routeIs('affectations.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('affectations.index') }}">
                    <i class="fas fa-fw fa-map-marker-alt"></i>
                    <span>Affectations</span>
                </a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">Carrière</div>

            <!-- Grades & Cadres -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                   data-target="#collapseCarriere" aria-expanded="false">
                    <i class="fas fa-fw fa-star"></i>
                    <span>Grades & Cadres</span>
                </a>
                <div id="collapseCarriere" class="collapse" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="#">Grades</a>
                        <a class="collapse-item" href="#">Cadres</a>
                        <a class="collapse-item" href="#">Échelons</a>
                    </div>
                </div>
            </li>

            <!-- Absences -->
            <li class="nav-item {{ request()->routeIs('absences.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('absences.index') }}">
                    <i class="fas fa-fw fa-calendar-times"></i>
                    <span>Absences & Congés</span>
                </a>
            </li>

            <!-- Diplômes -->
            <li class="nav-item {{ request()->routeIs('diplomes.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('diplomes.index') }}">
                    <i class="fas fa-fw fa-graduation-cap"></i>
                    <span>Diplômes</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <!-- Toggle Sidebar -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>