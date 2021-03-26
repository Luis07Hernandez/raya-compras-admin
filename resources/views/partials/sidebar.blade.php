<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow" id="listMenu">


            @if(\Auth::user()->status === 1)
                <li class="m-menu__item  m-menu__item--active" id="banners" aria-haspopup="true">
                    <a href="{{URL::to('/banners')}}" class="m-menu__link ">
                        <i class="m-menu__link-icon flaticon-web" style="color: white"></i>
                        <span class="m-menu__link-title">
                            <span class="m-menu__link-wrap">
                                <span class="m-menu__link-text" style="color: white">
                                    Banners
                                </span>

                            </span>
                        </span>
                    </a>
                </li>
            @endif

            {{-- @if(\Auth::user()->status === 1) --}}
            <li class="m-menu__item  m-menu__item--active" id="productos" aria-haspopup="true">
                <a href="{{URL::to('/products')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-box" style="color: white"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text" style="color: white">
                                Productos
                            </span>

                        </span>
                    </span>
                </a>
            </li>
            {{-- @endif --}}
            @if(\Auth::user()->status === 1)
            <li class="m-menu__item  m-menu__item--active" id="categories" aria-haspopup="true">
                <a href="{{URL::to('/categories')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-list-2
" style="color: white"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text" style="color: white">
                                Categorias
                            </span>

                        </span>
                    </span>
                </a>
            </li>
            @endif

            @if(\Auth::user()->status === 1)
            <li class="m-menu__item  m-menu__item--active" id="customers" aria-haspopup="true">
                <a href="{{URL::to('/customers')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-users" style="color: white"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text" style="color: white">
                                Administrador de clientes
                            </span>

                        </span>
                    </span>
                </a>
            </li>
            @endif

            @if(\Auth::user()->status === 1)
            <li class="m-menu__item  m-menu__item--active" id="routes" aria-haspopup="true">
                <a href="{{URL::to('/routes')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-truck" style="color: white"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text" style="color: white">
                               Catálogo de Rutas
                            </span>

                        </span>
                    </span>
                </a>
            </li>
            @endif

            <li class="m-menu__item  m-menu__item--active" id="orders" aria-haspopup="true">
                <a href="{{URL::to('/orders')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-list-3" style="color: white"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text" style="color: white">
                                Administración de pedidos
                            </span>

                        </span>
                    </span>
                </a>
            </li>

        

            @if(\Auth::user()->status === 1)
            <li class="m-menu__item  m-menu__item--active" id="providers" aria-haspopup="true">
                <a href="{{URL::to('/providers')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-avatar" style="color: white"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text" style="color: white">
                               Proveedores
                            </span>

                        </span>
                    </span>
                </a>
            </li>
            @endif

             @if(\Auth::user()->status === 1)
            <li class="m-menu__item  m-menu__item--active" id="sellers" aria-haspopup="true">
                <a href="{{URL::to('/sellers')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-customer" style="color: white"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text" style="color: white">
                               Vendedores
                            </span>

                        </span>
                    </span>
                </a>
            </li>
            @endif

            @if(\Auth::user()->status === 1)
            <li class="m-menu__item m-menu__item--submenu m-menu__item--expanded" style="background-color: #292b3a00;" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-list-2" style ="color: white;"></i>
                    <span style ="color: white;"   class="m-menu__link-text">Reportes</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
				<div class="m-menu__submenu " style="display: none; overflow: hidden;" m-hidden-height="160">
                <span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
									 
									        
                        <li class="m-menu__item  m-menu__item--active" id="reports" aria-haspopup="true">
                            <a href="{{URL::to('/reports')}}" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-list-1" style="color: white"></i>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text" style="color: white">
                                        Reporte Concentrado
                                        </span>

                                    </span>
                                </span>
                            </a>
                        </li>
       
                        <li class="m-menu__item  m-menu__item--active" id="sellerReport" aria-haspopup="true">
                            <a href="{{URL::to('/sellerReport')}}" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-list" style="color: white"></i>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text" style="color: white">
                                        Reporte por Vendedor
        
                                        </span>

                                    </span>
                                </span>
                            </a>
                        </li>		 
					</ul>
				</div>
            </li>
            @endif				
        </ul>
    </div>

    <!-- END: Aside Menu -->
</div>
