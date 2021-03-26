<!DOCTYPE html>
<html lang="en">

@include('partials.style')
<!-- begin::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">

    <!-- BEGIN: Header -->
    @include('partials.header')

    <!-- END: Header -->

    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

        <!-- BEGIN: Left Aside -->
        @include('partials.sidebar')

        <!-- END: Left Aside -->
        <div class="m-grid__item m-grid__item--fluid m-wrapper">

            <!-- BEGIN: Subheader -->
            @yield('breadcrom')


            <!-- END: Subheader -->
            <div class="m-content">
                <div class="row">
                    <div class="col-lg-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end:: Body -->

    <!-- begin::Footer -->
    <footer class="m-grid__item		m-footer ">
        <div class="m-container m-container--fluid m-container--full-height m-page__container">
            <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
                <div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
							<span class="m-footer__copyright">

							</span>
                </div>
                <div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
                    <ul class="m-footer__nav m-nav m-nav--inline m--pull-right">


                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- end::Footer -->
</div>

<!-- end:: Page -->

<!-- begin::Quick Sidebar -->
<style>
    .select2-container--classic .select2-results__option--highlighted[aria-selected] {
        background-color: #a8d860;
        color: #fff;

    }

    .select2-container--classic .select2-selection--multiple:focus{
        border-color: #a8d860;
    }
    .active{  color: #a8d860;}

    .dataTables_wrapper .pagination .page-item:hover>.page-link {
        background: #a8d860;
        color: #fff;
    }
</style>

<!-- end::Quick Sidebar -->

<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
    <i class="la la-arrow-up"></i>
</div>

<!-- end::Scroll Top -->

<!-- begin::Quick Nav -->

@include('partials.scripts')

@yield('scripts')

<!-- Alerts -->
@include('partials.request')
@include('partials.success')
@include('partials.error')

 <div class="modal fade" id="notification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="width:50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Aviso importante</h4>
            </div>
            <div class="modal-body" id="bodyDebts">
                <table class="table table-striped- table-bordered table-hover" id="notifications-table">
                    <thead>
                    <tr>
                        <th>Fecha de creación</th>
                        <th>Mensaje</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button id="close_notifications" type="button" class="btn btn-danger" data-dismiss="modal" onClick="markReadNotificaction()"></i>Cerrar</button>
            </div>
        </div>
    </div>
</div>


</body>

<!-- end::Body -->
</html>
