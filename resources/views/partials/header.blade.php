<header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">

            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-dark ">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <a href="{{URL::to('/')}}" class="m-brand__logo-wrapper" style="text-decoration: none;color: #0be6ff;letter-spacing:2px; font-size: 23px;">
                            <img src="/images/flech2.png" alt=""   style="   width:90px;max-width:700px; margin-left: 40px; " />
                            {{--<img src="{{url('/images/flech2.png')}}" alt="" width="150" height="33"/>--}}
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">

                        <!-- BEGIN: Left Aside Minimize Toggle -->
                        <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
                            <span></span>
                        </a>

                        <!-- END -->

                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>

                        <!-- END -->

                        <!-- BEGIN: Responsive Header Menu Toggler -->

                        {{--<a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">--}}
                            {{--<span></span>--}}
                        {{--</a>--}}

                        <!-- END -->

                        <!-- BEGIN: Topbar Toggler -->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more"></i>
                        </a>

                        <!-- BEGIN: Topbar Toggler -->
                    </div>
                </div>
            </div>

            <!-- END: Brand -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav" >

                <!-- BEGIN: Horizontal Menu -->
                {{--<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn"><i class="la la-close"></i></button>--}}

                <!-- END: Horizontal Menu -->

                <!-- BEGIN: Topbar -->
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid" >
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            
                            <li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width" m-dropdown-toggle="click"
                                m-dropdown-persistent="1">
                                @if(\Auth::user()->status === 0)
                                    <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
                                        <span class="m-nav__link-badge" id="countNotifications">0</span>
                                        <span class="m-nav__link-icon"><i class="flaticon-alarm"></i></span>
                                    </a>
                                @endif
                            </li>
                            

                            <li class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder ">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" style="color: #000000">
                                    <span class="username username-hide-on-mobile" style="color: #000000"> {!!Auth::user()->name!!} </span>
                                    {{--<i class="fa fa-angle-down" style="color: #5867dd"></i>--}}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default" style=" margin-top: 10px; margin-left: -10px" >


                                    <li>
                                        <a href="{{ url('/logout') }}" role="button" tabindex="0" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                            <i class="icon-key " style="color: #5867dd"></i> Cerrar sesión
                                        </a>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- END: Topbar -->
            </div>
        </div>
    </div>
</header>
