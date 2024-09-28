<!-- partial:partials/_sidebar.html -->
<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ url('/') }}" class="sidebar-brand">
            Support<span>Ticket</span>
        </a>
        <div class="sidebar-toggler ">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Admin</li>
            <!--  Dashboard  -->
            <li class="nav-item {{ $data['active_menu'] == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link ">
                    <i class="fa-solid fa-chart-line"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

                     {{-- customer --}}
                     <li
                     class="nav-item {{ $data['active_menu'] == 'customer_add' || $data['active_menu'] == 'customer_edit' || $data['active_menu'] == 'customer_list' || $data['active_menu'] == 'customer_list' ? 'active' : '' }}">
                     <a class="nav-link" data-bs-toggle="collapse" href="#customer" role="button" aria-expanded="false"
                         aria-controls="customer">
                         <i class="fa-regular fa-user"></i>
                         <span class="link-title">Customers Manage</span>
                         <i class="fa-solid fa-chevron-down link-arrow"></i>
                     </a>
                     <div class="collapse" id="customer">
                         <ul class="nav sub-menu">
                             <li class="nav-item ">
                                 <a href="{{ route('admin.customer.add') }}"
                                     class="nav-link {{ $data['active_menu'] == 'customer_add' ? 'active' : '' }}">Customer
                                     Add</a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('admin.customer.list') }}"
                                     class="nav-link {{ $data['active_menu'] == 'customer_list' ? 'active' : '' }}">Customer
                                     List</a>
                             </li>
     
                         </ul>
                     </div>
                 </li>
        </ul>
    </div>
</nav>

<!-- partial -->
