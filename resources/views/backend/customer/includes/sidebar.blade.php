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
            <li class="nav-item nav-category">Ticket</li>
            <!--  Dashboard  -->
            <li class="nav-item {{ $data['active_menu'] == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('customer.dashboard') }}" class="nav-link ">
                    <i class="fa-solid fa-chart-line"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

                       {{-- Ticket --}}
                       <li
                       class="nav-item {{ $data['active_menu'] == 'ticket_add' || $data['active_menu'] == 'ticket_close' || $data['active_menu'] == 'ticket_list' ? 'active' : '' }}">
                       <a class="nav-link" data-bs-toggle="collapse" href="#ticket" role="button" aria-expanded="false"
                           aria-controls="ticket">
                           <i class="fa-regular fa-user"></i>
                           <span class="link-title">Tickets Manage</span>
                           <i class="fa-solid fa-chevron-down link-arrow"></i>
                       </a>
                       <div class="collapse" id="ticket">
                           <ul class="nav sub-menu">
                               <li class="nav-item ">
                                   <a href="{{ route('customer.ticket.add') }}"
                                       class="nav-link {{ $data['active_menu'] == 'ticket_add' ? 'active' : '' }}">Ticket
                                       Add</a>
                               </li>
                               <li class="nav-item">
                                   <a href="{{ route('customer.ticket.list') }}"
                                       class="nav-link {{ $data['active_menu'] == 'ticket_list' ? 'active' : '' }}">Ticket
                                       List</a>
                               </li>
       
                           </ul>
                       </div>
                   </li>
        </ul>
    </div>
</nav>

<!-- partial -->
