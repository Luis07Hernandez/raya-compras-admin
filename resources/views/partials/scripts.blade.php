<!-- begin::Quick Nav -->
<script type="text/javascript" src="https://unpkg.com/default-passive-events"></script>


{!! Html::script('assets/vendors/base/vendors.bundle.js') !!}
{!! Html::script('assets/demo/default/base/scripts.bundle.js') !!}

{!! Html::script('assets/vendors/custom/fullcalendar/fullcalendar.bundle.js') !!}

{!! Html::script('assets/app/js/dashboard.js') !!}



{!! Html::script('assets/vendors/custom/datatables/datatables.bundle.js') !!}
{!! Html::script('assets/demo/default/custom/crud/datatables/basic/paginations.js') !!}
{!! Html::script('assets/demo/default/custom/crud/forms/widgets/bootstrap-datepicker.js') !!}

{!! Html::script('https://www.gstatic.com/charts/loader.js') !!}
{!! Html::script('https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js') !!}

{!! Html::script('/js/notifications.js') !!}
<script>
     $(document).ready(function(){
        var urlsaved = localStorage.getItem("urlPaginate");
        var path = window.location.pathname;
        if(path === "/"){
            if(urlsaved != null){
                localStorage.clear();
            }
        }
        
    });
 
 </script>
<!--end::Page Scripts -->
