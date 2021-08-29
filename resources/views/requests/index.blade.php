@include('includes.head')
@include('includes.menu')


<div class="bootstrap">

<div class="w-75 mx-auto p-3 mt-45 mb-10">
    <h2>Gestion des types de demande</h2>
</div>



    <div class="card w-95 mx-auto p-3 mt-2 mb-10 ">
        <table class="table table-striped table-bordered dataTable no-footer" style="width:100%" id="RequestTable">
            <thead class="bg-primary" style="color:white;">
              <tr>
                <th scope="col"></th>
                <th scope="col">#</th>
                <th scope="col">etudiant</th>
                <th scope="col">type</th>
                <th scope="col">disponibilté</th>
                <th scope="col">estimation</th>
                <th scope="col">soumis le</th>                
              </tr>
            </thead>
        </table>
    </div>
</div>


<script>



    function traiterRequest(array){
        console.log(array[0].id);
        var j = 0;
        for(var i=0;i<array.length;i++){
          let url = '/request/'+array[i].id;
          $.ajax({
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url: url,
              type: "PATCH",
              async:false,
              success: function(response){
                  console.log(response);
                  j++;
              },
              error: function(response){
                console.log(response);
                toastr["error"]("demande " + i +" n'est pas traiter correctement");
              },
              complete:function(){
                  stopLoading();
                  table.ajax.reload();
              }
          });
        }
        if(j==i) 
          swal("demande traité!", {icon: "success",});
        else
          toastr["error"]("Something went wrong!");
         
    }
    
    function deleteRequest(array){
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
              let url = '/request/'+array[i].id;
              $.ajax({
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  url: url,
                  type: "DELETE",
                  async:false,
                  success: function(response){
                      j++;
                  },
                  error: function(response){
                    console.log(response);
                    toastr["error"]("demande " + i +" n'est pas supprimé");
                  },
                  complete:function(){
                      stopLoading();
                      table.ajax.reload();
                  }
              });
            }
            if(j==i) 
              swal("demande supprimées!", {icon: "success",});
            else
              toastr["error"]("Something went wrong!");
        } else {
          swal("Suppression annulée!");
          stopLoading();
        }
      });        
    }
        
    
    
    
    
    var table = null;
    table = $('#RequestTable').DataTable({
    "ajax": {
      url: "/request/data",
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
      {"data": "student"},  
      {"data": "label"},
      {"data":null, "render": function(data){
          return data.is_done == 0 ? "<b>Pas encore traiter</b>" : "<b>traitée</b>";
      }},    
      {"data": "min_duration", 
        "render": function(data){
            return data == 1?  data + ' jour' : data +' jours';
        }      
      },
    {"data": "updated_at", "render":function(data){
        let datee = data.split('T');
        return datee[0];
    }}, 
],
    
    "createdRow": function ( row, data, index ) {
            if (data.is_done == 1) {
                $('td', row).eq(4).css({'background-color':'green', 'color':'white'});
            }else{
                $('td', row).eq(4).css({'background-color':'red', 'color':'white'});
            }
        },
    "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json" },
    responsive: true,
    order: [[ 1, 'asc' ]],
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
          {
            text: 'actualiser',
            action : (e, dt, node, config)=>{
              table.ajax.reload();
            }
          },
          'csvHtml5',
          'excelHtml5',
          'pdfHtml5',
          {
            text: 'supprimer',
            key:{
              key:'d',
              crtlKey: true,
            },  
              action : (e, dt, node, config)=>{
                const count = table.rows({selected: true}).count();
                if(count != 0){
                  let data = table.rows({selected: true}).data();
                  const len = data.length;
                  startLoading();
                  if(len > 0){
                    deleteRequest(data);
                  }
                }
                else{
                  toastr["error"]("Vous doit supprimer au moins un ligne!");
                }
              }
          },
          {
              text: 'traiter',
              action : (e, dt, node, config)=>{
                const count = table.rows({selected: true}).count();
                if(count != 0){
                  let data = table.rows({selected: true}).data();
                  const len = data.length;
                  startLoading();
                  if(len > 0){
                    traiterRequest(data);
                  }
                }
                else{
                  toastr["error"]("Vous doit supprimer au moins un ligne!");
                }
              }
          }
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




@include('includes.footer')