@include('includes.head')
@include('includes.menu')
<div class="bootstrap">

<div class="w-75 mx-auto p-3 mt-45 mb-10">
    <h2>Gestion de bibliothèque</h2>
</div>
    <div class="card w-75 mx-auto p-3 mt-45 mb-10" style="width:100px">

        <button class="ui positive button mx-auto" id="add-book"><i class='fa fa-angle-double-down' style='color:white'></i> Ajouter un livre</button>
        <div class="card-body" id="libraryForm">
 
        </div>
    </div>



    <div class="card w-95 mx-auto p-3 mt-2 mb-10 ">
        <table class="table table-striped table-bordered dataTable no-footer" style="width:100%" id="libraryTable">
            <thead class="bg-primary" style="color:white;">
              <tr>
                <th scope="col"></th>
                <th scope="col">#</th>
                <th scope="col">Titre</th>
                <th scope="col">Auteur</th>
                <th scope="col" >type</th>
                <th scope="col" >Disponibilité</th>
                <th scope="col" >pris par</th>
                <th scope="col" >date de création</th>
                <th scope="col" >date de mise à jour</th>
              </tr>
            </thead>
        </table>
    </div>
</div>

<script>


function ajouterEtudiant(cne, id){
    var dialog = bootbox.dialog({ 
        size: "small",
        title:"Modifier le porteur de livre",
        message: '<div class="text-center"><i class="fa fa-spin fa-spinner"></i> Loading...</div>', 
        closeButton: false 
    });
    dialog.init(function(){
        stopLoading();    
        $(".bootbox").wrap("<div class='bootstrap'></div>");
        $(".modal-dialog").addClass("modal-dialog-centered mx-auto");
        cne = cne === null ? '' : cne;
        dialog.find('.bootbox-body').html('<div class="row mt-4"><input class="w-75 mx-auto form-control" name="taken_by" type="text" id="taken_by" value='+cne+' /></div><div class="row mt-4"><div class="ui buttons mx-auto"> <button class="ui positive button" type="submit" id="submit">Sauvgarder</button> <div class="or" data-attr="ou"></div> <button class="ui button red" type="cancel" id="cancel">Annuler</button> </div></div>');
        $('.bootbox-body').ready(()=>{
            $("#cancel").click(function(){
                dialog.modal("hide");
            });
            
            $('#submit').click((e)=>{
                e.preventDefault();
                
                let student = $('#taken_by').val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "/library",
                    data: {
                        student: student,
                        id: id
                    },
                    async: false,
                    beforeSend: ()=>{
                        startLoading();
                        $('#submit').attr('disabled', 'true').addClass("loading");
                    },
                    success: function(response){
                        console.log(response);
                        swal("succès!", "Le livre a été modifier avec succés!", "success");
                        table.ajax.reload();
                        dialog.modal("hide");
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
                
            });
            
        });
    });
    
}

function deleteLibraryArray(array){
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
          let url = '/library/'+array[i].id;
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
                toastr["error"]("stage " + i +" n'est pas supprimé");
              },
              complete:function(){
                  stopLoading();
                  table.ajax.reload();
              }
          });
        }
        if(j==i) 
          swal("livre supprimées!", {icon: "success",});
        else
          toastr["error"]("Something went wrong!");
    } else {
      swal("Suppression annulée!");
      stopLoading();
    }
  });  
}



var table = null;
table = $('#libraryTable').DataTable({
    "ajax": {
      url: "library/data",
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
      {"data": "available", "render":function(data){
          return data == 1? "disponible": "non disponible";
      }},
      {"data": "taken_by"},
      {"data": "created_at", "render":(data)=>{
        let datee = data.split('T');
        return datee[0];
      }},
      {"data": "updated_at", "render":(data)=>{
        let datee = data.split('T');
        return datee[0];
      }},
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
                    deleteLibraryArray(data);
                  }
                }
                else{
                  toastr["error"]("Vous doit supprimer au moins un ligne!");
                }
              }
          },
          
          {
              text: "modifier",
              action: (e, dt, node, config)=>{
                const count = table.rows({selected: true}).count();
                if(count != 0){
                  let data = table.rows({selected: true}).data();
                  const len = data.length;
                  startLoading();
                  if(len == 1){
                    ajouterEtudiant(data[0].taken_by, data[0].id);
                  }else{
                      swal("Erreur!", "Il faut selectionner un seul ligne", "error");
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
    $('#add-book').click(()=>{
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: "/library/create",
            async: false,
            beforeSend: ()=>{
                startLoading();
                $('#add-book').attr('disabled', 'true').addClass("loading").hide();
            },
            success: function(response){
                $("#libraryForm").html(response).hide().slideDown("3000", function(){
                     $("#type").selectize({
                        create: true,
                        sortField: 'text'
                    });
                    
                    $("#cancel").click((e)=>{
                        e.preventDefault();
                        $('#isbn').val("");
                        $('#title').val("");
                        $('#author').val("");
                        $('#type').val("");
                        
                        $('#library-form').slideUp("3000");
                         $('#add-book').show();
                    });
                    
                    $('#submit').click((e)=>{
                        
                        e.preventDefault();
                        const isbn = $('#isbn').val();
                        const title = $('#title').val();
                        const author = $('#author').val();
                        const type = $('#type').val();
                        let err = false;
                        
                        if(!isbn){
                            toastr["error"]("isbn est vide!");
                            err = true;                
                        }
                        if(!title){
                            toastr["error"]("titre est vide!");
                            err = true;
                        }
                        if(!author){
                            toastr["error"]("auteur est vide!");
                            err = true;            
                        }            
                        if(!type){
                            toastr["error"]("type est vide!");
                            err = true;                
                        }
                        
                        if(!err){
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                type: "POST",
                                url: "/library/store",
                                data: {
                                    id: isbn,
                                    title: title,
                                    author: author,
                                    type: type,
                                    available: 1
                                },
                                async: false,
                                beforeSend: ()=>{
                                    startLoading();
                                    $('#submit').attr('disabled', 'true').addClass("loading");
                                    $('#add-book').hide();
                                },
                                success: function(response){
                                    swal("succès!", "Le livre a été ajouter", "success");
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
                $('#add-book').removeAttr('disabled').removeClass('loading');
                stopLoading();
            }
            
        });  
    });        
        


    });                    
                    
                    
                    
                    
                    
                    
                    
                    

    
</script>
  
@include('includes.footer')  