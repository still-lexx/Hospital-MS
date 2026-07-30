<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="content-header bg-white-5">
        <!-- Logo -->
        <a class="font-w600 text-dual" href="{{ url('/') }}">
            <span class="smini-visible">
                <i class="fa fa-circle-notch text-primary"></i>
            </span>
            <span class="smini-hide font-size-h5 tracking-wider">
                H<span class="font-w400">MS</span>
            </span>
        </a>
        <!-- END Logo -->

        <!-- Extra -->
        <div>
            <!-- Options -->
            <div class="dropdown d-inline-block ml-2">
                <a class="btn btn-sm btn-dual" id="sidebar-themes-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="si si-drop"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right font-size-sm smini-hide border-0" aria-labelledby="sidebar-themes-dropdown">
                    <!-- Color Themes -->
                    <a class="dropdown-item d-flex align-items-center justify-content-between font-w500" data-toggle="theme" data-theme="default" href="#">
                        <span>Default</span>
                        <i class="fa fa-circle text-default"></i>
                    </a>
                    <a class="dropdown-item d-flex align-items-center justify-content-between font-w500" data-toggle="theme" data-theme="assets/css/themes/amethyst.min.css" href="#">
                        <span>Amethyst</span>
                        <i class="fa fa-circle text-amethyst"></i>
                    </a>
                    <a class="dropdown-item d-flex align-items-center justify-content-between font-w500" data-toggle="theme" data-theme="assets/css/themes/city.min.css" href="#">
                        <span>City</span>
                        <i class="fa fa-circle text-city"></i>
                    </a>
                    <a class="dropdown-item d-flex align-items-center justify-content-between font-w500" data-toggle="theme" data-theme="assets/css/themes/flat.min.css" href="#">
                        <span>Flat</span>
                        <i class="fa fa-circle text-flat"></i>
                    </a>
                    <a class="dropdown-item d-flex align-items-center justify-content-between font-w500" data-toggle="theme" data-theme="assets/css/themes/modern.min.css" href="#">
                        <span>Modern</span>
                        <i class="fa fa-circle text-modern"></i>
                    </a>
                    <a class="dropdown-item d-flex align-items-center justify-content-between font-w500" data-toggle="theme" data-theme="assets/css/themes/smooth.min.css" href="#">
                        <span>Smooth</span>
                        <i class="fa fa-circle text-smooth"></i>
                    </a>
                    <!-- END Color Themes -->

                    <div class="dropdown-divider"></div>

                    <!-- Sidebar Styles -->
                    <a class="dropdown-item font-w500" data-toggle="layout" data-action="sidebar_style_light" href="#">
                        <span>Sidebar Light</span>
                    </a>
                    <a class="dropdown-item font-w500" data-toggle="layout" data-action="sidebar_style_dark" href="#">
                        <span>Sidebar Dark</span>
                    </a>
                    <!-- END Sidebar Styles -->

                    <div class="dropdown-divider"></div>

                    <!-- Header Styles -->
                    <a class="dropdown-item font-w500" data-toggle="layout" data-action="header_style_light" href="#">
                        <span>Header Light</span>
                    </a>
                    <a class="dropdown-item font-w500" data-toggle="layout" data-action="header_style_dark" href="#">
                        <span>Header Dark</span>
                    </a>
                    <!-- END Header Styles -->
                </div>
            </div>
            <!-- END Options -->

            <!-- Close Sidebar, Visible only on mobile screens -->
            <a class="d-lg-none btn btn-sm btn-dual ml-1" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                <i class="fa fa-fw fa-times"></i>
            </a>
            <!-- END Close Sidebar -->
        </div>
        <!-- END Extra -->
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
        <!-- Side Navigation -->
        <div class="content-side">
            <ul class="nav-main">
                <!-- Dashboard -->
                <li class="nav-main-item">
                    <a class="nav-main-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="nav-main-link-icon si si-speedometer"></i>
                        <span class="nav-main-link-name">Dashboard</span>
                    </a>
                </li>

                <!-- Front Desk Section -->
                <li class="nav-main-heading">Front Desk</li>
                
                <!-- Patients -->
                <li class="nav-main-item {{ Request::is('patients*') ? 'open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon si si-user"></i>
                        <span class="nav-main-link-name">Patients</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('patients') ? 'active' : '' }}" href="{{ route('patients.index') }}">
                                <span class="nav-main-link-name">All Patients</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('patients/create') ? 'active' : '' }}" href="{{ route('patients.create') }}">
                                <span class="nav-main-link-name">Register New</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Appointments -->
                <li class="nav-main-item {{ Request::is('appointments*') ? 'open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon si si-calendar"></i>
                        <span class="nav-main-link-name">Appointments</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('appointments') && !request('view') ? 'active' : '' }}" href="{{ route('appointments.index') }}">
                                <span class="nav-main-link-name">All Appointments</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('appointments/create') ? 'active' : '' }}" href="{{ route('appointments.create') }}">
                                <span class="nav-main-link-name">Schedule New</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ request('view') == 'history' ? 'active' : '' }}" href="{{ route('appointments.index', ['view' => 'history']) }}">
                                <span class="nav-main-link-name">History</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Doctors -->
                <li class="nav-main-item {{ Request::is('doctors*') ? 'open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon si si-user-follow"></i>
                        <span class="nav-main-link-name">Doctors</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('doctors') && !request('create') ? 'active' : '' }}" href="{{ route('doctors.index') }}">
                                <span class="nav-main-link-name">All Doctors</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('doctors/create') ? 'active' : '' }}" href="{{ route('doctors.create') }}">
                                <span class="nav-main-link-name">Add Doctor</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('doctors/schedules*') ? 'active' : '' }}" href="{{ route('doctors.schedules.index') }}">
                                <span class="nav-main-link-name">Schedules</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- OPD Management -->
                <li class="nav-main-item {{ Request::is('opd*') ? 'open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon si si-badge"></i>
                        <span class="nav-main-link-name">OPD</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('operations/opd/visits*') ? 'active' : '' }}" href="{{ route('opd-visits.index') }}">
                                <span class="nav-main-link-name">OPD Queue</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('operations/opd/consultations*') ? 'active' : '' }}" href="{{ route('opd-consultations.index') }}">
                                <span class="nav-main-link-name">Consultations</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('operations/opd/medical-records*') ? 'active' : '' }}" href="{{ route('opd-records.index') }}">
                                <span class="nav-main-link-name">Medical Records</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- IPD/Admissions -->
                <li class="nav-main-item {{ Request::is('ipd*') || Request::is('admissions*') ? 'open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon si si-home"></i>
                        <span class="nav-main-link-name">IPD/Admissions</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('ipd/admissions*') ? 'active' : '' }}" href="{{ route('ipd-admissions.index') }}">
                                <span class="nav-main-link-name">Admitted Patients</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('ipd/wards*') ? 'active' : '' }}" href="{{ route('wards.index') }}">
                                <span class="nav-main-link-name">Ward Management</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="#">
                                <span class="nav-main-link-name">Bed Allocation (Via Wards)</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Services Section -->
                <li class="nav-main-heading">Services</li>

                <!-- Lab Management -->
                <li class="nav-main-item {{ Request::is('laboratory*') ? 'open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon si si-chemistry"></i>
                        <span class="nav-main-link-name">Laboratory</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('laboratory/tests*') ? 'active' : '' }}" href="{{ route('lab-tests.index') }}">
                                <span class="nav-main-link-name">Lab Tests</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('laboratory/requests*') ? 'active' : '' }}" href="{{ route('lab-test-requests.index') }}">
                                <span class="nav-main-link-name">Test Requests</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('laboratory/results*') ? 'active' : '' }}" href="{{ route('lab-results.index') }}">
                                <span class="nav-main-link-name">Test Results</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Pharmacy -->
                <li class="nav-main-item {{ Request::is('pharmacy*') ? 'open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon si si-plus"></i>
                        <span class="nav-main-link-name">Pharmacy</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('pharmacy/prescriptions*') ? 'active' : '' }}" href="{{ route('prescriptions.index') }}">
                                <span class="nav-main-link-name">Prescriptions</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('pharmacy/stock*') ? 'active' : '' }}" href="{{ route('items.index') }}">
                                <span class="nav-main-link-name">Medicine Stock</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('pharmacy/sales*') ? 'active' : '' }}" href="{{ route('pharmacy-sales.index') }}">
                                <span class="nav-main-link-name">Sales</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Operation Theatre -->
                <li class="nav-main-item {{ Request::is('operations*') ? 'open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon si si-heart"></i>
                        <span class="nav-main-link-name">Operation Theatre</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('operations/surgeries*') ? 'active' : '' }}" href="{{ route('surgeries.index') }}">
                                <span class="nav-main-link-name">Surgery Schedule</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('operations/ot-rooms*') ? 'active' : '' }}" href="{{ route('ot-rooms.index') }}">
                                <span class="nav-main-link-name">OT Rooms</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('operations/reports*') ? 'active' : '' }}" href="{{ route('surgery-reports.index') }}">
                                <span class="nav-main-link-name">Surgery Reports</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Finance Section -->
                <li class="nav-main-heading">Finance</li>

                <!-- Billing/Finance -->
                <li class="nav-main-item {{ Request::is('billing*') ? 'open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon si si-wallet"></i>
                        <span class="nav-main-link-name">Billing</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('billing/invoices/create') ? 'active' : '' }}" href="{{ route('invoices.create') }}">
                                <span class="nav-main-link-name">Create Invoice</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('billing/invoices') && !Request::is('billing/invoices/create') ? 'active' : '' }}" href="{{ route('invoices.index') }}">
                                <span class="nav-main-link-name">Invoices</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('billing/payments') ? 'active' : '' }}" href="{{ route('payments.index') }}">
                                <span class="nav-main-link-name">Payments</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('billing/insurance-claims*') ? 'active' : '' }}" href="{{ route('insurance-claims.index') }}">
                                <span class="nav-main-link-name">Insurance Claims</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Inventory -->
                <li class="nav-main-item {{ Request::is('inventory*') ? 'open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon si si-bag"></i>
                        <span class="nav-main-link-name">Inventory</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('inventory/stock*') ? 'active' : '' }}" href="{{ route('stock.index') }}">
                                <span class="nav-main-link-name">Stock Management</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('inventory/items*') ? 'active' : '' }}" href="{{ route('items.index') }}">
                                <span class="nav-main-link-name">Inventory Items</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('inventory/purchase-orders*') ? 'active' : '' }}" href="{{ route('purchase-orders.index') }}">
                                <span class="nav-main-link-name">Purchase Orders</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('inventory/suppliers*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                                <span class="nav-main-link-name">Suppliers</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('inventory/categories*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                                <span class="nav-main-link-name">Categories</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Administration Section -->
                <li class="nav-main-heading">Administration</li>

                <!-- System Setup -->
                <li class="nav-main-item {{ Request::is('hospital*') || Request::is('departments*') || Request::is('users*') || Request::is('roles*') ? 'open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon si si-settings"></i>
                        <span class="nav-main-link-name">System Setup</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('hospital*') ? 'active' : '' }}" href="{{ route('hospital.edit') }}">
                                <span class="nav-main-link-name">Hospital Profile</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('departments*') ? 'active' : '' }}" href="{{ route('departments.index') }}">
                                <span class="nav-main-link-name">Departments</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                <span class="nav-main-link-name">Manage Users</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                                <span class="nav-main-link-name">Roles & Permissions</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Reports -->
                <li class="nav-main-item {{ Request::is('reports*') ? 'open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon si si-graph"></i>
                        <span class="nav-main-link-name">Reports</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('reports/patients') ? 'active' : '' }}" href="{{ route('reports.patients') }}">
                                <span class="nav-main-link-name">Patient Reports</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('reports/financial') ? 'active' : '' }}" href="{{ route('reports.financial') }}">
                                <span class="nav-main-link-name">Financial Reports</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('reports/inventory') ? 'active' : '' }}" href="{{ route('reports.inventory') }}">
                                <span class="nav-main-link-name">Inventory Reports</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ Request::is('reports/analytics') ? 'active' : '' }}" href="{{ route('reports.analytics') }}">
                                <span class="nav-main-link-name">Analytics</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- END Sidebar Scrolling -->
</nav>