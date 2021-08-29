@include('includes.head')
@include('includes.menu')


<div class="bootstrap">

<div class="w-75 mx-auto p-3 mt-45 mb-10">
    <h2>Gestion des types de demande</h2>
</div>
    <div class="card w-75 mx-auto p-3 mt-45 mb-10" style="width:100px">

        <button class="ui positive button mx-auto" id="add-demande-type"><i class='fa fa-angle-double-down' style='color:white'></i> Ajouter un type de demande</button>
        <div class="card-body" id="RequestTypeForm">
 
        </div>
    </div>



    <div class="card w-95 mx-auto p-3 mt-2 mb-10 ">
        <table class="table table-striped table-bordered dataTable no-footer" style="width:100%" id="RequestTypeTable">
            <thead class="bg-primary" style="color:white;">
              <tr>
                <th scope="col"></th>
                <th scope="col">#</th>
                <th scope="col">Label</th>
                <th scope="col">min_duration</th>
              </tr>
            </thead>
        </table>
    </div>
</div>



<script>

function deleteRequestType(array){
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
          let url = '/request-type/'+array[i].id;
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
                toastr["error"]("type de demande " + i +" n'est pas supprimé");
              },
              complete:function(){
                  stopLoading();
                  table.ajax.reload();
              }
          });
        }
        if(j==i) 
          swal("type de demande supprimées!", {icon: "success",});
        else
          toastr["error"]("Something went wrong!");
    } else {
      swal("Suppression annulée!");
      stopLoading();
    }
  });      
}

var table = null;
table = $('#RequestTypeTable').DataTable({
    "ajax": {
      url: "/request-type/data",
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
      {"data": "label"},  
      {"data": "min_duration", "render": (data)=>{
          return data == 1 ? data+" jour"  : data+" jours";
      }}
    ],
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
                    deleteRequestType(data);
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

    
    

        
    
$(function(){
    $('#add-demande-type').click(()=>{
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: "request-type/create",
            async: false,
            beforeSend: ()=>{
                startLoading();
                $('#add-demande-type').attr('disabled', 'true').addClass("loading").hide();
            },
            success: function(response){
                $("#RequestTypeForm").html(response).hide().slideDown("3000", function(){
                    
                    $("#cancel").click((e)=>{
                        e.preventDefault();
                        $('#label').val("");
                        $('#min_duration').val("");
                        
                        $('#request-type-form').slideUp("3000");
                        $('#add-demande-type').show();
                    });
                    
                    $('#submit').click((e)=>{
                        
                        e.preventDefault();
                        const label = $('#label').val();
                        const min_duration = $('#min-duration').val();
                        
                        let err = false;
                        
                        if(!label){
                            toastr["error"]("label est vide!");
                            err = true;                
                        }
                        if(!min_duration){
                            toastr["error"]("duration minimale est vide!");
                            err = true;
                        }
                        if(!err){
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                type: "POST",
                                url: "/request-type",
                                data: {
                                    label: label,
                                    min_duration: min_duration
                                },
                                async: false,
                                beforeSend: ()=>{
                                    startLoading();
                                    $('#submit').attr('disabled', 'true').addClass("loading");
                                    $('#add-demande-type').hide();
                                },
                                success: function(response){
                                    swal("succès!", "Un nouveau type de demande a été ajouter", "success");
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
                                    $('#submit').removeAttr('disabled').removeClass('loading');
                                    stopLoading();
                                }                    
                            });                 
                        }
                       
                    });                    
                });
            },
            error: function(xhr){
                console.log(xhr);
            },
            complete: (response)=>{
                $('#add-demande-type').removeAttr('disabled').removeClass('loading');
                stopLoading();
            }
            
        });  
    });        
        


    });                 
</script>


@include('includes.footer')