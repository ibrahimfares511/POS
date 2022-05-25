        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav nav-pills nav-stacked" id="menu">
              <li class="active">
                  <a href="{{route('home')}}"><span class="fa-stack text-center fa-lg pull-left"><i class="fas fa-tachometer-alt"></i></span> صفحة القياده </a>
              </li>
              @can('صفحة المبيعات')
              <li>
                  <a href="#"> <span class="fa-stack text-center fa-lg pull-left"><i class="fa fa-cart-plus"></i></span>المبيعات</a>
                <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                  <li> <a href="{{Route('view.sales')}}"><span class="fa-stack text-center fa-lg pull-left"><i class="fas fa-store-alt"></i></span>  المبيعات </a> </li>
                  <li> <a href="{{Route('view.halk')}}"><span class="fa-stack text-center fa-lg pull-left"><i class="fas fa-store-alt"></i></span>  الهالك </a> </li>
                </ul>
              </li>
              @endcan
              @can('صفحة المشتريات')
              <li>
                <a href="{{route('view.purchases')}}"><span class="fa-stack text-center fa-lg pull-left"><i class="fas fa-store-alt"></i></span> المشتريات </a>
              </li>
              @endcan
              @can('صفحة المنتجات والاصناف والوحدات')
              <li>
                  <a href="#"><span class="fa-stack text-center fa-lg pull-left"><i class="fas fa-cloud-download-alt"></i></span>المنتجات</a>
                <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                  @can('المنتجات')
                    <li> <a href="{{Route('view.products')}}"><span class="fa-stack text-center fa-lg pull-left"><i class="far fa-plus-square"></i></span>  عرض المنتجات </a> </li>
                  @endcan
                  @can('صفحة الاصناف')
                    <li> <a href="{{Route('view.category')}}"><span class="fa-stack text-center fa-lg pull-left"><i class="far fa-plus-square"></i></span>  الاصناف </a> </li>
                  @endcan
                  @can('صفحة الوحدات')
                    <li> <a href="{{Route('view.unit')}}"><span class="fa-stack text-center fa-lg pull-left"><i class="far fa-plus-square"></i></span>  الوحدات </a> </li>
                  @endcan
                </ul>
              </li>
              @endcan
                @can('صفحة الصرف والتوريد')
                <li>
                    <a href="#"> <span class="fa-stack text-center fa-lg pull-left"><i class="fa fa-cart-plus"></i></span>صرف و توريد</a>
                  <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                    @can('صفحة الصرف')
                    <li> <a href="{{Route('view.exchange')}}"><span class="fa-stack text-center fa-lg pull-left"><i class="far fa-plus-square"></i></span>  صرف </a> </li>
                    @endcan
                    @can('صفحة التوريد')
                    <li> <a href="{{Route('view.supply')}}"><span class="fa-stack text-center fa-lg pull-left"><i class="far fa-plus-square"></i></span>  توريد </a> </li>
                    @endcan
                  </ul>
                </li>
                @endcan
                @can('صفحة الموظفين')
                <li>
                  <a href="{{Route('view.staff')}}"><span class="fa-stack text-center fa-lg pull-left"><i class="fa fa-address-card"></i></span>الموظفين</a>
                </li>
                @endcan
              @can('صفحة العملاء')
              <li>
                <a href="{{Route('view.customers')}}"><span class="fa-stack text-center fa-lg pull-left"><i class="fa fa-address-card"></i></span>العملاء</a>
              </li>
              @endcan
              @can('صفحة المصروفات')
              <li>
                  <a href="{{Route('view.expense')}}"><span class="fa-stack text-center fa-lg pull-left"><i class="fa fa-wrench"></i></span>المصروفات</a>
              </li>
              @endcan

              <li>
                <a href="{{Route('view.expense')}}"><span class="fa-stack text-center fa-lg pull-left"><i class="fa fa-wrench"></i></span>الاعدادات</a>
                <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                  <li> <a href="{{Route('view.setting')}}"><span class="fa-stack text-center fa-lg pull-left"><i class="fas fa-cogs"></i></span>  النظام </a> </li>
                  <li> <a href="{{Route('view.users')}}"><span class="fa-stack text-center fa-lg pull-left"><i class="fas fa-barcode"></i></span>  الباركود </a> </li>
                  <li> <a href="{{Route('view.add.job')}}"><span class="fa-stack text-center fa-lg pull-left"><i class="far fa-plus-square"></i></span>  اضافة عمل </a> </li>
                  <li> <a href="{{Route('view.add.branch')}}"><span class="fa-stack text-center fa-lg pull-left"><i class="far fa-plus-square"></i></span>  اضافة فرع </a> </li>
                </ul>
              </li>
              @can('صفحة التقارير')
              <li>
                <a href="#"><span class="fa-stack text-center fa-lg pull-left"><i class="fas fa-chart-bar"></i></span>التقارير</a>
                <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                    @can('تقارير المبيعات ')
                    <li> <a href="{{ route('viewreport') }}"><span class="fa-stack text-center fa-lg pull-left"><i class="fas fa-chart-bar"></i></span>  المبيعات </a> </li>
                    <li> <a href="{{ route('viewreporthalk') }}"><span class="fa-stack text-center fa-lg pull-left"><i class="fas fa-chart-bar"></i></span>  الهالك </a> </li>
                    @endcan
                    @can('تقارير المشتريات')
                    <li> <a href="{{ route('viewreportbuy') }}"><span class="fa-stack text-center fa-lg pull-left"><i class="fas fa-chart-bar"></i></span>  المشتريات </a> </li>
                    @endcan
                    @can('تقارير الصرف')
                    <li> <a href="{{ route('Exchange_Report') }}"><span class="fa-stack text-center fa-lg pull-left"><i class="fas fa-chart-bar"></i></span>  الصرف </a> </li>
                    @endcan
                    @can('تقارير التوريد')
                    <li> <a href="{{ route('Supply_Report') }}"><span class="fa-stack text-center fa-lg pull-left"><i class="fas fa-chart-bar"></i></span>  التوريد </a> </li>
                    @endcan
                    @can('تقارير المصروفات')
                    <li> <a href="{{ route('Expense_Report_view') }}"><span class="fa-stack text-center fa-lg pull-left"><i class="fas fa-chart-bar"></i></span>  المصروفات </a> </li>
                    @endcan
                  </ul>
              </li>
              @endcan

              @can('صفحة المستخدمين والصلاحيات')
              <li>
                <a href=""><span class="fa-stack text-center fa-lg pull-left"><i class="fa fa-server"></i></span>المستخدمين</a>
                <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                  @can('صفحة المستخدمين ')
                  <li> <a href="{{ url('/' . ($page = 'users')) }}"><span class="fa-stack text-center fa-lg pull-left"><i class="fas fa-chart-bar"></i></span>  قائمة المستخدمين </a> </li>
                  @endcan
                  @can('صفحة الصلاحيات ')
                  <li> <a href="{{ url('/' . ($page = 'roles')) }}"><span class="fa-stack text-center fa-lg pull-left"><i class="fas fa-chart-bar"></i></span>  صلاحيات المستخدمين </a> </li>
                  @endcan
                </ul>
              </li>
              @endcan

                <li>
                    <a href="{{Route('view.add.contact')}}"><span class="fa-stack text-center fa-lg pull-left"><i class="fa fa-server"></i></span>Contact</a>
                </li>

            </ul>
        </div>
        <!-- /#sidebar-wrapper -->
