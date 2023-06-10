<section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>{{ request()->is('pastor/create') ? 'My Application' : '' }}</h2>
          <ol>
            <li><a href="">Annual Report</a></li>
            <li>
              {{ request()->is('login/*') ? 'Dashboard' : '' }}
              {{ request()->is('Impersonate/*') ? 'Dashboard' : '' }}
              {{ request()->is('*/Dashboard') ? 'Dashboard' : '' }}
              {{ request()->is('*/Churchlist') ? 'Church List' : '' }}
              {{ request()->is('*/ChurchReport/*') ? 'Church Report' : '' }}
              {{ request()->is('*/Manage-Users') ? 'Manage Users' : '' }}
              {{ request()->is('*/Church-Export') ? 'Church Export' : '' }}
              {{ request()->is('*/Manage-Documents') ? 'Manage Documents' : '' }}
            </li>
          </ol>
        </div>

      </div>
</section>
<style type="text/css">
  ol > li a:hover{
    color: #444444;
  }
</style>