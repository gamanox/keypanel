$(function(){
    $(function(){
        $(".button-collapse").sideNav();

        if( $('.datatable').length ){
            $('.datatable').DataTable();

            setTimeout( function(){
                $('.dataTables_length select').material_select();
            }, 500);
        }
    });
});

//# sourceMappingURL=init.js.map