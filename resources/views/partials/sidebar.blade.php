<!-- Sidebar Menu -->
<div class="sidebar">
    <div class="sidebar-header">
        <h4>{{ config('app.name', 'Admin Panel') }}</h4>
        <p class="user-role">Role: {{ auth()->user()->role ? auth()->user()->role->display_name : 'User' }}</p>
    </div>
    
    <ul class="sidebar-menu">
            <!-- Menu Items -->
            <li class="menu-item {{ request()->is('admin*') ? 'active' : '' }}">
                <a href="{{ route('admin') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="menu-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}">
                    <i class="fas fa-users"></i>
                    <span>User Management</span>
                </a>
            </li>
            
            <li class="menu-item {{ request()->is('admin/banner*') ? 'active' : '' }}">
                <a href="{{ route('banner.index') }}">
                    <i class="fas fa-image"></i>
                    <span>Banners</span>
                </a>
            </li>
            
            <li class="menu-item {{ request()->is('admin/brand*') ? 'active' : '' }}">
                <a href="{{ route('brand.index') }}">
                    <i class="fas fa-tag"></i>
                    <span>Brands</span>
                </a>
            </li>
            
            <li class="menu-item {{ request()->is('admin/category*') ? 'active' : '' }}">
                <a href="{{ route('category.index') }}">
                    <i class="fas fa-folder"></i>
                    <span>Categories</span>
                </a>
            </li>
            
            <li class="menu-item {{ request()->is('admin/product*') ? 'active' : '' }}">
                <a href="{{ route('product.index') }}">
                    <i class="fas fa-box"></i>
                    <span>Products</span>
                </a>
            </li>
            
            <li class="menu-item {{ request()->is('admin/post-category*') ? 'active' : '' }}">
                <a href="{{ route('post-category.index') }}">
                    <i class="fas fa-folder-open"></i>
                    <span>Post Categories</span>
                </a>
            </li>
            
            <li class="menu-item {{ request()->is('admin/post-tag*') ? 'active' : '' }}">
                <a href="{{ route('post-tag.index') }}">
                    <i class="fas fa-tags"></i>
                    <span>Post Tags</span>
                </a>
            </li>
            
            <li class="menu-item {{ request()->is('admin/post*') ? 'active' : '' }}">
                <a href="{{ route('post.index') }}">
                    <i class="fas fa-newspaper"></i>
                    <span>Posts</span>
                </a>
            </li>
            
            <li class="menu-item {{ request()->is('admin/coupon*') ? 'active' : '' }}">
                <a href="{{ route('coupon.index') }}">
                    <i class="fas fa-ticket-alt"></i>
                    <span>Coupons</span>
                </a>
            </li>
            
            <li class="menu-item {{ request()->is('admin/message*') ? 'active' : '' }}">
                <a href="{{ route('message.index') }}">
                    <i class="fas fa-envelope"></i>
                    <span>Messages</span>
                </a>
            </li>
            
            <li class="menu-item {{ request()->is('admin/notification*') ? 'active' : '' }}">
                <a href="{{ route('all.notification') }}">
                    <i class="fas fa-bell"></i>
                    <span>Notifications</span>
                </a>
            </li>
            
            <li class="menu-item {{ request()->is('admin/settings*') ? 'active' : '' }}">
                <a href="{{ route('settings') }}">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
        
        <!-- Common Menu Items -->
        <li class="menu-item {{ request()->is(['*/profile', '*/change-password']) ? 'active' : '' }}">
            <a href="{{ route('admin-profile') }}">
                <i class="fas fa-user"></i>
                <span>My Profile</span>
            </a>
        </li>
        
        <li class="menu-item {{ request()->is(['*/change-password']) ? 'active' : '' }}">
            <a href="{{ route('change.password.form') }}">
                <i class="fas fa-key"></i>
                <span>Change Password</span>
            </a>
        </li>
        
        <li class="menu-item">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</div>

<style>
.sidebar {
    width: 250px;
    background: #2c3e50;
    color: white;
    min-height: 100vh;
    padding: 0;
}

.sidebar-header {
    padding: 20px;
    border-bottom: 1px solid #34495e;
    text-align: center;
}

.sidebar-header h4 {
    margin: 0 0 10px 0;
    color: #fff;
}

.user-role {
    margin: 0;
    padding: 5px 10px;
    background: #34495e;
    border-radius: 15px;
    font-size: 12px;
    font-weight: bold;
}

.sidebar-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.menu-item {
    border-bottom: 1px solid #34495e;
}

.menu-item a {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    color: #adb5bd;
    text-decoration: none;
    transition: all 0.3s;
}

.menu-item a:hover {
    background: #34495e;
    color: white;
}

.menu-item.active a {
    background: #007bff;
    color: white;
}

.menu-item i {
    width: 20px;
    margin-right: 10px;
}

.menu-item span {
    font-size: 14px;
}
</style>
