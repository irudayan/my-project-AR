<div class="pagetitle">
    <h1>
      {{ request()->is('*/Admin-Dashboard') ? 'Dashboard' : '' }}
      {{ request()->is('*/Active-Dates') ? 'Active Dates' : '' }}
      {{ request()->is('*/Sections') ? 'Sections' : '' }}
      {{ request()->is('*/Questions') ? 'Questions' : '' }}
      {{ request()->is('*/Questionsorder') ? 'Questions Order' : '' }}
      {{ request()->is('*/Churchlist') ? 'Churchlist' : '' }}
      {{ request()->is('*/Manage-users') ? 'Manage Users' : '' }}
      {{ request()->is('*/Manage-Staff-Roles') ? 'Staff Roles' : '' }}
      {{ request()->is('*/Add-Question') ? 'Add Question' : '' }}
    </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        @if(request()->is('*/Add-Question') || request()->is('*/Edit-Question/*'))
        <li class="breadcrumb-item">
          <a href="{{url('AnnualReport/Admin-Dashboard/Questions')}}">
            {{ request()->is('*/Add-Question') ? 'Questions' : '' }}
            {{ request()->is('*/Edit-Question/*') ? 'Questions' : '' }}
          </a>
        </li>
        @endif
        <li class="breadcrumb-item active">
          {{ request()->is('*/Admin-Dashboard') ? 'Dashboard' : '' }}
          {{ request()->is('*/Dashboard') ? 'Dashboard' : '' }}
          {{ request()->is('*/Sections') ? 'Sections' : '' }}
          {{ request()->is('*/Questions') ? 'Questions' : '' }}
          {{ request()->is('*/Questionsorder') ? 'Questions Order' : '' }}
          {{ request()->is('*/Churchlist') ? 'Churchlist' : '' }}
          {{ request()->is('*/Manage-users') ? 'Manage Users' : '' }}
          {{ request()->is('*/Add-Question') ? 'Add Question' : '' }}
          {{ request()->is('*/Edit-Question/*') ? 'Edit Question' : '' }}
          {{ request()->is('*/Active-Dates') ? 'Active Dates' : '' }}
          {{ request()->is('*/Manage-Staff-Roles') ? 'Staff Roles' : '' }}
          {{ request()->is('Impersonate/*') ? 'Dashboard' : '' }}
          {{ request()->is('login/*') ? 'Dashboard' : '' }}

        </li>
      </ol>
    </nav>
  </div>
