
<!-- ============================================================== -->
<!-- Left Sidebar - Modernized -->
<!-- ============================================================== -->
<aside class="left-sidebar bg-dark text-white" id="js-trigger-nav-team">
    <div class="scroll-sidebar" id="main-scroll-sidebar">
        <nav class="sidebar-nav" id="main-sidenav">
            <ul id="sidebarnav" data-modular-id="main_menu_team">

                <!-- Dashboard -->
                @if(auth()->user()->role->role_homepage == 'dashboard')
                <li class="sidenav-menu-item {{ $page['mainmenu_home'] ?? '' }}">
                    <a href="/home" class="d-flex align-items-center">
                        <i class="bi bi-speedometer2 me-2"></i>
                        <span>{{ cleanLang(__('lang.dashboard')) }}</span>
                    </a>
                </li>
                @endif

                <!-- Customers -->
                @if(runtimeGroupMenuVibility([config('visibility.modules.clients'), config('visibility.modules.users')]))
                <li class="sidenav-menu-item has-arrow {{ $page['mainmenu_customers'] ?? '' }}">
                    <a href="javascript:void(0);" class="d-flex align-items-center">
                        <i class="bi bi-people-fill me-2"></i>
                        <span>{{ cleanLang(__('lang.customers')) }}</span>
                    </a>
                    <ul class="collapse">
                        @if(config('visibility.modules.clients'))
                        <li><a href="/clients">{{ cleanLang(__('lang.clients')) }}</a></li>
                        @endif
                        @if(config('visibility.modules.users'))
                        <li><a href="/users">{{ cleanLang(__('lang.client_users')) }}</a></li>
                        @endif
                    </ul>
                </li>
                @endif

                <!-- Projects -->
                @if(config('visibility.modules.projects'))
                <li class="sidenav-menu-item has-arrow {{ $page['mainmenu_projects'] ?? '' }}">
                    <a href="javascript:void(0);" class="d-flex align-items-center">
                        <i class="bi bi-folder2-open me-2"></i>
                        <span>{{ cleanLang(__('lang.projects')) }}</span>
                    </a>
                    <ul class="collapse">
                        <li><a href="{{ _url('/projects') }}">{{ cleanLang(__('lang.projects')) }}</a></li>
                        <li><a href="{{ _url('/templates/projects') }}">{{ cleanLang(__('lang.templates')) }}</a></li>
                    </ul>
                </li>
                @endif

                <!-- Tasks -->
                @if(config('visibility.modules.tasks'))
                <li class="sidenav-menu-item {{ $page['mainmenu_tasks'] ?? '' }}">
                    <a href="/tasks" class="d-flex align-items-center">
                        <i class="bi bi-check2-square me-2"></i>
                        <span>{{ cleanLang(__('lang.tasks')) }}</span>
                    </a>
                </li>
                @endif

                <!-- Leads -->
                @if(config('visibility.modules.leads'))
                <li class="sidenav-menu-item {{ $page['mainmenu_leads'] ?? '' }}">
                    <a href="/leads" class="d-flex align-items-center">
                        <i class="bi bi-telephone-plus-fill me-2"></i>
                        <span>{{ cleanLang(__('lang.leads')) }}</span>
                    </a>
                </li>
                @endif

                <!-- Sales -->
                @if(runtimeGroupMenuVibility([
                    config('visibility.modules.invoices'),
                    config('visibility.modules.payments'),
                    config('visibility.modules.estimates'),
                    config('visibility.modules.products'),
                    config('visibility.modules.expenses')
                ]))
                <li class="sidenav-menu-item has-arrow {{ $page['mainmenu_sales'] ?? '' }}">
                    <a href="javascript:void(0);" class="d-flex align-items-center">
                        <i class="bi bi-wallet2 me-2"></i>
                        <span>{{ cleanLang(__('lang.sales')) }}</span>
                    </a>
                    <ul class="collapse">
                        @if(config('visibility.modules.invoices'))
                        <li><a href="/invoices">{{ cleanLang(__('lang.invoices')) }}</a></li>
                        @endif
                        @if(config('visibility.modules.payments'))
                        <li><a href="/payments">{{ cleanLang(__('lang.payments')) }}</a></li>
                        @endif
                        @if(config('visibility.modules.estimates'))
                        <li><a href="/estimates">{{ cleanLang(__('lang.estimates')) }}</a></li>
                        @endif
                        @if(config('visibility.modules.products'))
                        <li><a href="/products">{{ cleanLang(__('lang.products')) }}</a></li>
                        @endif
                        @if(config('visibility.modules.expenses'))
                        <li><a href="/expenses">{{ cleanLang(__('lang.expenses')) }}</a></li>
                        @endif
                    </ul>
                </li>
                @endif

                <!-- Reports -->
                @if(config('visibility.modules.reports'))
                <li class="sidenav-menu-item {{ $page['mainmenu_reports'] ?? '' }}">
                    <a href="/reports" class="d-flex align-items-center">
                        <i class="bi bi-graph-up-arrow me-2"></i>
                        <span>{{ cleanLang(__('lang.reports')) }}</span>
                    </a>
                </li>
                @endif

                <!-- Knowledgebase -->
                @if(config('visibility.modules.knowledgebase'))
                <li class="sidenav-menu-item {{ $page['mainmenu_kb'] ?? '' }}">
                    <a href="/knowledgebase" class="d-flex align-items-center">
                        <i class="bi bi-journal-text me-2"></i>
                        <span>{{ cleanLang(__('lang.knowledgebase')) }}</span>
                    </a>
                </li>
                @endif

                <!-- Support -->
                @if(config('visibility.modules.tickets'))
                <li class="sidenav-menu-item has-arrow {{ $page['mainmenu_tickets'] ?? '' }}">
                    <a href="javascript:void(0);" class="d-flex align-items-center">
                        <i class="bi bi-chat-dots-fill me-2"></i>
                        <span>{{ cleanLang(__('lang.support')) }}</span>
                    </a>
                    <ul class="collapse">
                        <li><a href="/tickets">{{ cleanLang(__('lang.tickets')) }}</a></li>
                        <li><a href="/canned">{{ cleanLang(__('lang.canned')) }}</a></li>
                    </ul>
                </li>
                @endif

                <!-- Settings -->
                @if(auth()->user()->is_admin)
                <li class="sidenav-menu-item {{ $page['mainmenu_settings'] ?? '' }}">
                    <a href="/settings" class="d-flex align-items-center">
                        <i class="bi bi-gear-fill me-2"></i>
                        <span>{{ cleanLang(__('lang.settings')) }}</span>
                    </a>
                </li>
                @endif

            </ul>
        </nav>
    </div>
</aside>
