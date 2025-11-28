<!-- ============================================================== -->
<!-- Left Sidebar -->
<!-- ============================================================== -->
<aside class="left-sidebar" id="js-trigger-nav-team"> {{-- keep id for GrowCRM sidebar toggle --}}
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" id="main-scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" data-modular-id="main_menu_client">

                {{-- DASHBOARD --}}
                <li data-modular-id="main_menu_client_home"
                    class="sidenav-menu-item {{ $page['mainmenu_home'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.home')) }}">
                    <a class="waves-effect waves-dark" href="{{ route('dashboard') }}" aria-expanded="false">
                        <i class="ti-home"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.dashboard')) }}</span>
                    </a>
                </li>

                {{-- PROJECTS --}}
                @if(config('visibility.modules.projects'))
                    <li data-modular-id="main_menu_client_projects"
                        class="sidenav-menu-item {{ $page['mainmenu_projects'] ?? '' }} menu-tooltip menu-with-tooltip"
                        title="{{ cleanLang(__('lang.projects')) }}">
                        <a class="waves-effect waves-dark" href="{{ route('projects.index') }}" aria-expanded="false">
                            <i class="ti-folder"></i>
                            <span class="hide-menu">{{ cleanLang(__('lang.projects')) }}</span>
                        </a>
                    </li>
                @endif

                {{-- BILLING --}}
                @if(auth()->user()->is_client_owner)
                    <li data-modular-id="main_menu_client_billing"
                        class="sidenav-menu-item {{ $page['mainmenu_client_billing'] ?? '' }}">
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
                            <i class="ti-wallet"></i>
                            <span class="hide-menu">{{ cleanLang(__('lang.billing')) }}</span>
                        </a>

                        <ul aria-expanded="false" class="collapse">
                            @if(config('visibility.modules.invoices'))
                                <li id="submenu_invoices" class="sidenav-submenu {{ $page['submenu_invoices'] ?? '' }}">
                                    <a href="{{ route('invoices.index') }}">{{ cleanLang(__('lang.invoices')) }}</a>
                                </li>
                            @endif

                            @if(config('visibility.modules.payments'))
                                <li id="submenu_payments" class="sidenav-submenu {{ $page['submenu_payments'] ?? '' }}">
                                    <a href="{{ route('payments.index') }}">{{ cleanLang(__('lang.payments')) }}</a>
                                </li>
                            @endif

                            @if(config('visibility.modules.estimates'))
                                <li id="submenu_estimates" class="sidenav-submenu {{ $page['submenu_estimates'] ?? '' }}">
                                    <a href="{{ route('estimates.index') }}">{{ cleanLang(__('lang.estimates')) }}</a>
                                </li>
                            @endif

                            @if(config('visibility.modules.subscriptions'))
                                <li id="submenu_subscriptions" class="sidenav-submenu {{ $page['submenu_subscriptions'] ?? '' }}">
                                    <a href="{{ route('subscriptions.index') }}">{{ cleanLang(__('lang.subscriptions')) }}</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- PROPOSALS --}}
                @if(config('visibility.modules.proposals') && auth()->user()->is_client_owner)
                    <li data-modular-id="main_menu_client_proposals"
                        class="sidenav-menu-item {{ $page['mainmenu_client_proposals'] ?? '' }} menu-tooltip menu-with-tooltip"
                        title="{{ cleanLang(__('lang.proposals')) }}">
                        <a class="waves-effect waves-dark p-r-20" href="{{ route('proposals.index') }}" aria-expanded="false">
                            <i class="ti-bookmark-alt"></i>
                            <span class="hide-menu">{{ cleanLang(__('lang.proposals')) }}</span>
                        </a>
                    </li>
                @endif

                {{-- CONTRACTS --}}
                @if(config('visibility.modules.contracts') && auth()->user()->is_client_owner)
                    <li data-modular-id="main_menu_client_contracts"
                        class="sidenav-menu-item {{ $page['mainmenu_contracts'] ?? '' }} menu-tooltip menu-with-tooltip"
                        title="{{ cleanLang(__('lang.contracts')) }}">
                        <a class="waves-effect waves-dark p-r-20" href="{{ route('contracts.index') }}" aria-expanded="false">
                            <i class="ti-write"></i>
                            <span class="hide-menu">{{ cleanLang(__('lang.contracts')) }}</span>
                        </a>
                    </li>
                @endif

                {{-- DYNAMIC MODULE MENUS --}}
                {!! config('module_menus.main_menu_client') !!}

                {{-- USERS --}}
                @if(auth()->user()->is_client_owner)
                    <li data-modular-id="main_menu_client_users"
                        class="sidenav-menu-item {{ $page['mainmenu_contacts'] ?? '' }} menu-tooltip menu-with-tooltip"
                        title="{{ cleanLang(__('lang.users')) }}">
                        <a class="waves-effect waves-dark" href="{{ route('users.index') }}" aria-expanded="false">
                            <i class="sl-icon-people"></i>
                            <span class="hide-menu">{{ cleanLang(__('lang.users')) }}</span>
                        </a>
                    </li>
                @endif

                {{-- TICKETS --}}
                @if(config('visibility.modules.tickets'))
                    <li data-modular-id="main_menu_client_tickets"
                        class="sidenav-menu-item {{ $page['mainmenu_tickets'] ?? '' }} menu-tooltip menu-with-tooltip"
                        title="{{ cleanLang(__('lang.support_tickets')) }}">
                        <a class="waves-effect waves-dark" href="{{ route('tickets.index') }}" aria-expanded="false">
                            <i class="ti-comments"></i>
                            <span class="hide-menu">{{ cleanLang(__('lang.support')) }}</span>
                        </a>
                    </li>
                @endif

                {{-- KNOWLEDGEBASE --}}
                @if(config('visibility.modules.knowledgebase'))
                    <li data-modular-id="main_menu_client_knowledgebase"
                        class="sidenav-menu-item {{ $page['mainmenu_kb'] ?? '' }} menu-tooltip menu-with-tooltip"
                        title="{{ cleanLang(__('lang.knowledgebase')) }}">
                        <a class="waves-effect waves-dark p-r-20" href="{{ route('knowledgebase.index') }}" aria-expanded="false">
                            <i class="sl-icon-docs"></i>
                            <span class="hide-menu">{{ cleanLang(__('lang.knowledgebase')) }}</span>
                        </a>
                    </li>
                @endif

                {{-- MODULE MENU EXTENSIONS --}}
                {!! config('menus.main_menu_client') !!}

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
