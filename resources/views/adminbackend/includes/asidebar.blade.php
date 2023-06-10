<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
        <a class="nav-link {{ request()->is('*/Admin-Dashboard') ? '' : 'collapsed' }}{{ request()->is('*/Dashboard') ? 'collapsed' : '' }}" href="{{url('AnnualReport/Admin-Dashboard')}}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>
        </li>
        <!-- End Dashboard Nav -->
{{--
        <li class="nav-item">
            <a class="nav-link {{ request()->is('*/Churchlist') ? '' : 'collapsed' }}" href="{{url('AnnualReport/Admin-Dashboard/Churchlist')}}">
                <i class="fa fa-list"></i>
                <span>Church List</span>
            </a>
        </li> --}}
        <!-- End Churchlist Nav -->

        <li class="nav-item">
            <a class="nav-link {{ request()->is('*/Active-Dates') ? '' : 'collapsed' }}" href="{{url('AnnualReport/Admin-Dashboard/Active-Dates')}}">
                <i class="fa fa-calendar-check"></i>
                <span>Active Dates</span>
            </a>
        </li>
        <!-- End ActiveDates Nav -->

        <li class="nav-item">
            <a class="nav-link {{ request()->is('*/Sections') ? '' : 'collapsed' }}" href="{{url('AnnualReport/Admin-Dashboard/Sections')}}">
                <i class="fa fa-plus-square"></i>
                <span>Sections</span>
            </a>
        </li>
        <!-- End Sections Page Nav -->

        <li class="nav-item">
            <a class="nav-link {{ request()->is('*/Questions') ? '' : 'collapsed' }}{{ request()->is('*/Edit-Question/*') ? 'collapsed' : '' }}{{ request()->is('*/Add-Question') ? 'collapsed' : '' }}" href="{{url('AnnualReport/Admin-Dashboard/Questions')}}">
                <i class="fa fa-question-circle"></i>
                <span>Questions</span>
            </a>
        </li>
        <!-- End Questions Page Nav -->
        <li class="nav-item">
            <a class="nav-link {{ request()->is('*/Questionsorder') ? '' : 'collapsed' }}" href="{{url('AnnualReport/Admin-Dashboard/Questionsorder')}}">
                <i class="fa fa-sort"></i>
                <span>Questions Order</span>
            </a>
        </li>
        <!-- End Questions Page Nav -->
        <li class="nav-item">
            <a class="nav-link {{ request()->is('*/Manage-Users') ? '' : 'collapsed' }}" href="{{url('AnnualReport/Manage-Users')}}">
                <i class="fa fa-users"></i>
                <span>Manage Users</span>
            </a>
        </li>
        {{-- exportdata --}}
        
        <li class="nav-item">
            <a class="nav-link {{ request()->is('*/Manage-Users') ? '' : 'collapsed' }}" href="{{url('AnnualReport/Church-Export')}}">
                <i class="fa-solid fa-file-export"></i>
                <span>Church Export</span>
            </a>
        </li>
        <!-- End Manage user Page Nav -->

        <li class="nav-item">
            <a class="nav-link {{ request()->is('*/Manage-Documents') ? '' : 'collapsed' }}" href="{{url('AnnualReport/Manage-Documents')}}">
                <i class="bi bi-file-earmark-pdf-fill"></i>
                <span>Manage Documents</span>
            </a>
        </li>
        <!-- End Manage user Page Nav -->

        <!-- End Manage Staff Role Page Nav -->

        <li class="nav-item">
            <a class="nav-link {{ request()->is('*/Manage-Staff-Roles') ? '' : 'collapsed' }}" href="{{url('AnnualReport/Admin-Dashboard/Manage-Staff-Roles')}}">
                <i class="bi bi-person-check-fill"></i>
                <span>Manage Staff Roles</span>
            </a>
        </li>
        <!-- End Manage Staff Role Page Nav -->


        <li class="nav-item">
        <a class="nav-link {{ request()->is('*/Membership/*') ? '' : 'collapsed' }}" href="#">
            <i class="bi bi-question-circle"></i>
            <span>F.A.Q</span>
        </a>
        </li>
        <!-- End F.A.Q Page Nav -->

        <li class="nav-item">
        <a class="nav-link {{ request()->is('*/Membership/*') ? '' : 'collapsed' }}" href="#">
            <i class="bi bi-envelope"></i>
            <span>Contact</span>
        </a>
        </li>
        <!-- End Contact Page Nav -->

    </ul>
</aside>
