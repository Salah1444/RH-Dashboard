<aside class="sidebar">
  <a class="sidebar-brand" href="{{ route('dashboard') }}">
    <div class="brand-icon"><i class="fas fa-graduation-cap"></i></div>
    <div class="brand-text">RH Éducation<span>Tableau de Bord</span></div>
  </a>
  <ul style="list-style:none;padding-top:8px;">
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <i class="fas fa-tachometer-alt"></i><span>Tableau de Bord</span>
      </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Gestion RH</div>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('employes*') ? 'active' : '' }}" href="{{ route('employes.index') }}">
        <i class="fas fa-users"></i><span>Employés</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('affectations*') ? 'active' : '' }}" href="{{ route('affectations.index') }}">
        <i class="fas fa-map-pin"></i><span>Affectations</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('grades*','cadres*','echelons*') ? 'active' : '' }}" href="{{ route('grades.index') }}">
        <i class="fas fa-award"></i><span>Grades & Cadres</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('situations*') ? 'active' : '' }}" href="{{ route('situations.index') }}">
        <i class="fas fa-balance-scale"></i><span>Situations statutaires</span>
      </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Absences & Congés</div>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('absences*') ? 'active' : '' }}" href="{{ route('absences.index') }}">
        <i class="fas fa-calendar-times"></i><span>Absences</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('congees*') ? 'active' : '' }}" href="{{ route('congees.index') }}">
        <i class="fas fa-umbrella-beach"></i><span>Congés</span>
      </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Établissements</div>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('etablissements*') ? 'active' : '' }}" href="{{ route('etablissements.index') }}">
        <i class="fas fa-school"></i><span>Établissements</span>
      </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Données</div>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('diplomes*') ? 'active' : '' }}" href="{{ route('diplomes.index') }}">
        <i class="fas fa-graduation-cap"></i><span>Diplômes</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('famille.conjoints*') ? 'active' : '' }}" href="{{ route('famille.conjoints') }}">
        <i class="fas fa-ring"></i><span>Conjoints</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('famille.enfants*') ? 'active' : '' }}" href="{{ route('famille.enfants') }}">
        <i class="fas fa-baby"></i><span>Enfants</span>
      </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Géographie</div>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('regions*') ? 'active' : '' }}" href="{{ route('regions.index') }}">
        <i class="fas fa-globe-africa"></i><span>Régions</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('provinces*') ? 'active' : '' }}" href="{{ route('provinces.index') }}">
        <i class="fas fa-map"></i><span>Provinces</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('communes*') ? 'active' : '' }}" href="{{ route('communes.index') }}">
        <i class="fas fa-city"></i><span>Communes</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('modiriyas*') ? 'active' : '' }}" href="{{ route('modiriyas.index') }}">
        <i class="fas fa-building"></i><span>Modiriyas</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('net_etabs*') ? 'active' : '' }}" href="{{ route('net_etabs.index') }}">
        <i class="fas fa-network-wired"></i><span>Réseaux Étab.</span>
      </a>
    </li>
  </ul>
  <div class="sidebar-footer">
    <div class="avatar"><i class="fas fa-user"></i></div>
    <div class="user-info">
      <div class="name">{{ auth()->user()->name ?? 'Administrateur' }}</div>
      <div class="role">Directeur RH</div>
    </div>
  </div>
</aside>