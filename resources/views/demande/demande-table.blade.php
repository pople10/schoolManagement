@include('includes.head')
@include('includes.menu')

{{-- in here the admin will either approve the demands  --}}
<div class="bootstrap">
    
    <div class="w-75 mx-auto p-3 mt-45 mb-10">
        <h2>Gestion des demandes</h2>
    </div>
    
    
  <div class="card w-95 mx-auto p-3 mt-10 mb-10 " style="margin:25%">
    <table class="table table-striped table-bordered dataTable no-footer" style="width:100%" id="demand-table">
        <thead class="bg-primary" style="color:white;">
            <tr>
                <th></th>
                <th>#</th>
                <th>CNE</th>                
                <th>type de demande</th>
                <th>Sujet</th>
                <th>L'entrée de létudiant</th>
                <th>soumis dans le</th>
            </tr>
        </thead>
    </table>
    </div>  
</div>



<script>

function acceptDemand(id, cne, type){
  let url = '{{ route("demande.accept")}}';
  swal({
    title: "est ce-que vous avez sûr?",
    text: "Si vous acceptez une occurence, c'est irreversible!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willAccept) => {
    if (willAccept) {
          $.ajax({
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url: url,
              type: "POST",
              data:{
                  cne: cne,
                  id: id,
                  type: type
              },
              success: function(response){
                  console.log(response);
                  table.ajax.reload();
                  swal("Demande acceptée!", {
                    icon: "success",
                  });
              },
              error: function(response){
                  console.log(response);
                  table.ajax.reload();
                  toastr["error"]("Something went wrong!");
              },
              complete:function(){
                  console.log(response);
                  stopLoading();
              }
          });
      
    } else {
      swal("Action annulée!");
      stopLoading();
    }
  }); 
}

function acceptDemandArray(array){
  swal({
    title: "est ce-que vous avez sûr?",
    text: "Si vous acceptez une occurence, c'est irreversible!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willAccept) => {
    if (willAccept) {
        var j = 0;
        for(var i=0;i<array.length;i++){
          let url = '{{ route("demande.accept") }}';
          $.ajax({
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url: url,
              type: "POST",
              async:false,
              data: {
                  cne: array[i].user_id,
                  id: array[i].id,
                  type: array[i].type
              },
              success: function(response){
                console.log(response);
                j++;

              },
              error: function(response){
                                    console.log(response);
                toastr["error"]("demande " + i +" n'est pas acceptée");
              },
              complete:function(response){
                  console.log(response);
                  table.ajax.reload();
              }
          });
        }
        if(j==i) 
          swal("Demande acceptée!", {icon: "success",});
        else
          toastr["error"]("Something went wrong!");
    } else {
      swal("Action annulée!");
    }
  }); 
}

function deleteDemande(id){
  let url = '{{ route("demande.destroy", ["demande"=>"*ss*"]) }}';
  url = url.replace("*ss*", id);
  swal({
    title: "est ce-que vous avez sûr?",
    text: "Si vous supprimez une occurence, c'est irreversible!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
          $.ajax({
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url: url,
              type: "DELETE",
              success: function(response){
                  table.ajax.reload();
                  swal("Demande supprimée!", {
                    icon: "success",
                  });
              },
              error: function(response){
                  table.ajax.reload();
                  toastr["error"]("Something went wrong!");
              },
              complete:function(){
                  stopLoading();
              }
          });
      
    } else {
      swal("Suppression annulée!");
      stopLoading();
    }
  }); 
}




function deleteDemandeArray(array){
  swal({
    title: "est ce-que vous avez sûr?",
    text: "Si vous supprimez une occurence, c'est irreversible!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
        var j = 0;
        for(var i=0;i<array.length;i++){
          let url = '{{ route("demande.destroy", ["demande"=>"*ss*"]) }}';
          url = url.replace("*ss*", array[i].id);
          $.ajax({
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url: url,
              type: "DELETE",
              async:false,
              success: function(response){
                console.log(response);
                j++;

              },
              error: function(response){
                                    console.log(response);
                toastr["error"]("demande " + i +" n'est pas rejeté");
              },
              complete:function(response){
                  console.log(response);
                  table.ajax.reload();
              }
          });
        }
        if(j==i) 
          swal("Demande supprimées!", {icon: "success",});
        else
          toastr["error"]("Something went wrong!");
    } else {
      swal("Suppression annulée!");
    }
  });  
}





    var table = [];
    $(function () {
        table = $('#demand-table').DataTable({
        "ajax": {
        url: "{{route('demande.data')}}",
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
            {"data": "user_id"},
            {"data": "type"},
            {"data": "internship_id"},
            {"data": "additional_input"},
            {"data": "created_at"},
        ],
        dom: 'Bflrtip',
        buttons:[
        {
            extend: 'copyHtml5',
            text: 'Copier',
            key: {
                key: 'c',
                crtKey: true
            }
        },
        {
            text: 'actualiser',
            action : (e, dt, node, config)=>{
                table.ajax.reload;
            }
        },
        'csvHtml5',
        'excelHtml5',
        'pdfHtml5',
        {
            text: 'accepter',
            className: 'positive',
            action: function(e, dt, node, config){
                const count = table.rows({selected: true}).count();
                if(count != 0){
                    let data = table.rows({selected: true}).data();
                    const len = data.length;
                    if(len  > 1){
                        acceptDemandArray(data);
                    }else{
                        acceptDemand(data[0].id, data[0].user_id, data[0].type);
                    }
                }else{
                    toastr["error"]("Vous doit séléctionner au moins un ligne!");
                }
            }
        },
        {
            text: 'rejeter',
            action: function(e, dt, node, config){
                const count = table.rows({selected: true}).count();
                if(count != 0){
                    let data = table.rows({selected: true}).data();
                    const len = data.length;
                    if(len  > 1){
                        deleteDemandeArray(data);
                    }else{
                        deleteDemande(data[0].id);
                    }
                }else{
                    toastr["error"]("Vous doit séléctionner au moins un ligne!");
                }
            }
        }
    ],

        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json" },
        responsive: true,
        order: [[ 1, 'asc' ]],
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
});

</script>

@include('includes.footer')