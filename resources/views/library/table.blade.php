@include("includes.head")
@include("includes.menu")



<div class='bootstrap'>
    <div class="card w-95 mx-auto p-3 mt-2 mb-10 ">
        <table class="table table-striped table-bordered dataTable no-footer" style="width:100%" id="lib-table">
            <thead class="bg-primary" style="color:white;">
              <tr>
                <th scope="col"></th>
                <th scope="col">#</th>
                <th scope="col">Titre</th>
                <th scope="col">Auteur</th>
                <th scope="col" >type</th>
                <th scope="col" class="mx-auto" >Disponibilité</th>
              </tr>
            </thead>
        </table>
    </div>    
</div>


<script>



    function sendReservation(id){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/library/reserve",
            data: {
                id: id
            },
            async: false,
            beforeSend: ()=>{
                startLoading();
                $('.reserve').attr('disabled', 'true').addClass("loading");
            },
            success: function(response){
                swal("succès!", "Le livre a été réserver avec succés!", "success");
                table.ajax.reload();
            },
            error: function(xhr){
                console.log(xhr);
                if( xhr.status === 422 ) {
                    var errors = $.parseJSON(xhr.responseText);
                    $.each(errors, function (key, value) {
                        swal("Erreur!", value, "error");
                    });
                }
                else{
                    swal("Error!", "Something went wrong!", "error");
                }                          
            },
            complete: (response)=>{
                $('.reserve').removeAttr('disabled').removeClass('loading');
                stopLoading();
            }             
        });
    }

    
    var table = $('#lib-table').DataTable({
    "ajax": {
      url: "{{route('library.data')}}",
      cashe:false,
      dataSrc: ''
    },
    "order": [[0, "desc"]],
    "aaSorting": [],
    "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50, 100 , "Tous"]],
    //"deferRender": true,//optimises
    "scrollX": true,
    "columns":[
      {"data": null,"render":function(data){
        return "";
      }},        
      {"data": "id"},
      {"data": "title"},  
      {"data": "author"},
      {"data": "type"},
      {"data": null, "render":function(data){
          return data.available == 1? "<center><button onclick='sendReservation("+data.id+")' class='ui button positive reserve'>reserver</button></center>": "non disponible";
      }},        
    ],
    "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json" },
    responsive: true,    
    dom: 'Bflrtip',
    buttons: [
          {
            extend: 'copyHtml5',
            text: 'Copier',
            key: {
              key: 'c',
              ctrlKey: true
            }
          },
          'csvHtml5',
          'excelHtml5',
          'pdfHtml5',
          {
            text: 'actualiser',
            action : (e, dt, node, config)=>{
              table.ajax.reload();
            }
          },
    ],
    columnDefs: [ {
      orderable: false,
      className: 'select-checkbox',
      targets:   0
    } ],
    select:  {
        style: true,
        selector: 'td:first-child'
      },     
    
    });
</script>

    
    
@include("includes.footer")