<div class="topbar">
    <div class="topbar-left">
      <h2 class="topbar-title">@yield('page-title', 'Tableau de Bord')</h2>
    </div>
    <div class="topbar-right">
      <form class="topbar-search" action="{{ route('employes.index') }}" method="GET">
        <i class="fas fa-search"></i>
        <input type="text" name="search" placeholder="Rechercher un employé…" value="{{ request('search') }}">
      </form>
      <div class="topbar-badge"><i class="fas fa-bell"></i><span class="badge">3</span></div>
      <div style="width:1px;height:30px;background:#e3e6f0;"></div>
      <div style="display:flex;align-items:center;gap:8px;cursor:pointer;">
        <div style="width:34px;height:34px;background:var(--primary);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:14px;"> {{ Auth::user()? Str::limit(Auth::user()->name,1,""):'A'}} </div>
        <span style="font-size:13px;font-weight:600;color:var(--dark);">{{ Auth::user()? Auth::user()->name:'Admin'}}</span>
      </div>
    </div>
  </div>