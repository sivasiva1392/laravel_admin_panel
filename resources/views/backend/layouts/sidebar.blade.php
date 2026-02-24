<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="position: sticky; top: 0; height: 100vh; overflow-y: auto; overflow-x: hidden; scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.3) transparent;">
   <!-- Sidebar - Brand -->
   <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin')}}">
      <div class="sidebar-brand-icon rotate-n-15">
         <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Admin</div>
   </a>
   <!-- Divider -->
   <hr class="sidebar-divider my-0">
   <!-- Nav Item - Dashboard -->
   <li class="nav-item {{ Str::startsWith(request()->path(), 'admin') || Str::startsWith(request()->path(), 'admin/dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{route('admin')}}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
   </li>
   <!-- Divider -->
   <hr class="sidebar-divider">
   @if(auth()->user()->canAccessModule('banners') || auth()->user()->role_id == 1)
   <div class="sidebar-heading">
      Banner
   </div>
   @endif
   <!-- Nav Item - Pages Collapse Menu -->
   <!-- Nav Item - Charts -->
   @if(auth()->user()->canAccessModule('banners') || auth()->user()->role_id == 1)
   <li class="nav-item {{ Str::startsWith(request()->path(), 'admin/banner') ? 'active' : '' }}">
      <a class="nav-link" href="{{route('banner.index')}}">
      <i class="fas fa-image"></i>
      <span>Banners</span></a>
   </li>
   @endif

   <!-- Divider -->
   @if(auth()->user()->canAccessModule('amazon_categories') || auth()->user()->canAccessModule('amazon_products') || auth()->user()->role_id == 1)
   <hr class="sidebar-divider d-none d-md-block">
   <!-- Heading -->
   <div class="sidebar-heading">
      Amazon
   </div>
   @endif
   <!-- Amazon Categories -->
   @if(auth()->user()->canAccessModule('amazon_categories') || auth()->user()->role_id == 1)
   <li class="nav-item {{ Str::startsWith(request()->path(), 'admin/amazon-categories') ? 'active' : '' }}">
      <a class="nav-link" href="{{route('amazon-categories.index')}}">
      <i class="fas fa-folder-open"></i>
      <span>Amazon Categories</span></a>
   </li>
   @endif
   <!-- Amazon Sub-Categories -->
   @if(auth()->user()->canAccessModule('amazon_categories') || auth()->user()->role_id == 1)
   <li class="nav-item {{ Str::startsWith(request()->path(), 'admin/amazon-sub-categories') ? 'active' : '' }}">
      <a class="nav-link" href="{{route('amazon-sub-categories.index')}}">
      <i class="fas fa-folder"></i>
      <span>Amazon Sub-Categories</span></a>
   </li>
   @endif
   <!-- Amazon Products -->
   @if(auth()->user()->canAccessModule('amazon_products') || auth()->user()->role_id == 1)
   <li class="nav-item {{ Str::startsWith(request()->path(), 'admin/amazon-products') && !Str::startsWith(request()->path(), 'admin/amazon-categories') ? 'active' : '' }}">
      <a class="nav-link" href="{{route('amazon-products.index')}}">
      <i class="fas fa-box"></i>
      <span>Amazon Products</span></a>
   </li>
   @endif

    <!-- Divider -->
   @if(auth()->user()->canAccessModule('lms_categories') || auth()->user()->canAccessModule('lms') || auth()->user()->role_id == 1)
   <hr class="sidebar-divider d-none d-md-block">
   <!-- Heading -->
   <div class="sidebar-heading">
      LMS
   </div>
   @endif
   <!-- LMS Categories -->
   @if(auth()->user()->canAccessModule('lms_categories') || auth()->user()->role_id == 1)
   <li class="nav-item {{ Str::startsWith(request()->path(), 'admin/lms-categories') ? 'active' : '' }}">
      <a class="nav-link" href="{{route('lms-categories.index')}}">
      <i class="fas fa-folder-open"></i>
      <span>LMS Categories</span></a>
   </li>
   @endif
   <!-- LMS Documents -->
   @if(auth()->user()->canAccessModule('lms') || auth()->user()->role_id == 1)
   <li class="nav-item {{ Str::startsWith(request()->path(), 'admin/lms') && !Str::startsWith(request()->path(), 'admin/lms-categories') ? 'active' : '' }}">
      <a class="nav-link" href="{{route('lms.index')}}">
      <i class="fas fa-file-alt"></i>
      <span>LMS Documents</span></a>
   </li>
   @endif

   <!-- Divider -->
   @if(auth()->user()->canAccessModule('users') || auth()->user()->canAccessModule('settings') || auth()->user()->role_id == 1)
   <hr class="sidebar-divider d-none d-md-block">
   <!-- Heading -->
   <div class="sidebar-heading">
      General Settings
   </div>
   @endif
   @if(auth()->user()->canAccessModule('users') || auth()->user()->role_id == 1)
   <li class="nav-item {{ Str::startsWith(request()->path(), 'admin/users') ? 'active' : '' }}">
      <a class="nav-link" href="{{route('users.index')}}">
      <i class="fas fa-users"></i>
      <span>Users</span></a>
   </li>
   @endif
   @if(auth()->user()->canAccessModule('settings') || auth()->user()->role_id == 1)
   <li class="nav-item {{ Str::startsWith(request()->path(), 'admin/settings') ? 'active' : '' }}">
      <a class="nav-link" href="{{route('settings')}}">
      <i class="fas fa-cog"></i>
      <span>Settings</span></a>
   </li>
   @endif
   @if(auth()->user()->role_id == 1)
   <li class="nav-item {{ Str::startsWith(request()->path(), 'admin/role-permissions') ? 'active' : '' }}">
      <a class="nav-link" href="{{route('role-permissions.index')}}">
      <i class="fas fa-user-shield"></i>
      <span>Role Permissions</span></a>
   </li>
   @endif
   <!-- Sidebar Toggler (Sidebar) -->
   <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
   </div>
</ul>

<style>
/* Enhanced Sidebar Styles */
#accordionSidebar {
   scrollbar-width: thin;
   scrollbar-color: rgba(255,255,255,0.2) transparent;
}

#accordionSidebar::-webkit-scrollbar {
   width: 6px;
}

#accordionSidebar::-webkit-scrollbar-track {
   background: transparent;
}

#accordionSidebar::-webkit-scrollbar-thumb {
   background: rgba(255,255,255,0.2);
   border-radius: 3px;
   transition: background 0.3s ease;
}

#accordionSidebar::-webkit-scrollbar-thumb:hover {
   background: rgba(255,255,255,0.4);
}

/* Enhanced menu items */
.nav-item {
   transition: all 0.3s ease;
   margin: 2px 8px;
   border-radius: 8px;
}

.nav-item:hover {
   transform: translateX(3px);
}

.nav-link {
   border-radius: 8px;
   transition: all 0.3s ease;
   padding: 12px 16px !important;
   margin: 0;
}

.nav-link:hover {
   background: rgba(255,255,255,0.1) !important;
   transform: translateX(2px);
}

.nav-item.active .nav-link {
   background: rgba(255,255,255,0.15) !important;
   border-left: 4px solid #fff;
   font-weight: 500;
}

/* Enhanced headings */
.sidebar-heading {
   color: rgba(255,255,255,0.7) !important;
   font-size: 0.85rem;
   font-weight: 600;
   text-transform: uppercase;
   letter-spacing: 0.5px;
   padding: 15px 16px 8px 16px;
   margin: 10px 8px 5px 8px;
}

/* Enhanced brand */
.sidebar-brand {
   padding: 20px 16px;
   transition: all 0.3s ease;
}

.sidebar-brand:hover {
   background: rgba(255,255,255,0.05);
}

.sidebar-brand-text {
   font-weight: 600;
   font-size: 1.2rem;
}

/* Smooth scroll behavior */
#accordionSidebar {
   scroll-behavior: smooth;
}

/* Enhanced divider */
.sidebar-divider {
   border-color: rgba(255,255,255,0.1) !important;
   margin: 15px 16px;
}

/* Icon styling */
.nav-link i {
   width: 20px;
   text-align: center;
   transition: transform 0.3s ease;
}

.nav-item:hover .nav-link i {
   transform: scale(1.1);
}

.nav-item.active .nav-link i {
   color: #fff !important;
}
</style>