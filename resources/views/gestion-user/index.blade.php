@include("includes.head")
@include("includes.menu")


<div class="bootstrap">

    <div class="w-75 mx-auto p-3 mt-45 mb-10">
        <h2>Gestion de bibliothèque</h2>
             <div style="width:10px;height:10px;color:#accc60">Professeur</div>
      <div style="width:10px;height:10px;color:#60a8cc">Etudiant</div>
    </div>
    

    
    <div class="card w-95 mx-auto p-3 mt-2 mb-10 ">
        
        <table class="table table-striped table-bordered dataTable no-footer" style="width:100%" id="UserTable">
            <thead class="bg-primary" style="color:white;">
              <tr>
                <th scope="col"></th>
                <th scope="col">#</th>
                <th scope="col">cne</th>
                <th scope="col">email</th>
                <th scope="col">Nom complet</th>
                <th scope="col" >verifié</th>
              </tr>
            </thead>
        </table>
    </div>
    

</div>


<script>


function deleteUser(array){
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
          let url = '/user/'+array[i].id;
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
                toastr["error"]("utilisateur " + i +" n'est pas supprimé");
              },
              complete:function(){
                  stopLoading();
                  table.ajax.reload();
              }
          });
        }
        if(j==i) 
          swal("utilisateur supprimées!", {icon: "success",});
        else
          toastr["error"]("Something went wrong!");
    } else {
      swal("Suppression annulée!");
      stopLoading();
    }
  });  
}

function verifyUser(array){

    var j = 0;
    for(var i=0;i<array.length;i++){
      let url = '/user/'+array[i].id;
      $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: url,
          type: "PUT",
          async:false,
          success: function(response){
              j++;
          },
          error: function(response){
            console.log(response);
            toastr["error"]("utilisateur " + i +" n'est pas vérifié");
          },
          complete:function(){
              stopLoading();
              table.ajax.reload();
          }
      });
    }
    if(j==i) 
      swal("utilisateur vérifié!", {icon: "success",});
    else
      toastr["error"]("Something went wrong!");
}

function reeinstatePassword(array){
    var dialog = bootbox.dialog({ 
        size: "small",
        title:"Modifier l'utilisateur'",
        message: '<div class="text-center"><i class="fa fa-spin fa-spinner"></i> Loading...</div>', 
        closeButton: false 
    });
    dialog.init(function(){
        stopLoading();    
        $(".bootbox").wrap("<div class='bootstrap'></div>");
        $(".modal-dialog").addClass("modal-dialog-centered mx-auto");

        dialog.find('.bootbox-body').html('<div class="form mx-auto"><div class="form-group mt-4 mx-auto"><label for="email">Email</label><input class="form-control" name="email" type="email" id="email" value='+array[0].email+' /></div><div class="from-group mt-4"><label for="password">Mot de passe</label><input class="form-control" name="password" type="password" id="password"/></div><div class="row mt-4"><div class="ui buttons mx-auto"> <button class="ui positive button" type="submit" id="submit">Sauvgarder</button> <div class="or" data-attr="ou"></div> <button class="ui button red" type="cancel" id="cancel">Annuler</button> </div></div></div>');
        $('.bootbox-body').ready(()=>{
            $("#cancel").click(function(){
                dialog.modal("hide");
            });
            
            $('#submit').click((e)=>{
                e.preventDefault();
                
                let email = $('#email').val();
                let pwd = $('#password').val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "PUT",
                    url: "/user/retablirPassword/"+array[0].id,
                    data: {
                        email: email,
                        pwd: pwd
                    },
                    async: false,
                    beforeSend: ()=>{
                        startLoading();
                        $('#submit').attr('disabled', 'true').addClass("loading");
                    },
                    success: function(response){
                        console.log(response);
                        swal("succès!", "L'utilisateur a été modifier avec succés!", "success");
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

    
    var table = null;
    table = $('#UserTable').DataTable({
    "ajax": {
      url: "/users/data",
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
      {"data": "cne"},
      {"data": "email"},  
      {"data": null, "render": function(data){
          return data.lname + " " + data.fname; 
      }},
      {"data":null, "render": function(data){
          return data.verified == 1 ? "<b>vérifié</b>" : "<b>non vérifié</b>";
      }}
],
    
    "createdRow": function ( row, data, index ) {
            if(data.role_id == 1){
                $('td', row).css({'background-color':'#60a8cc', 'color':'white'});
            }else if(data.role_id == 2){
                $('td', row).css({'background-color':'#accc60', 'color':'white'});
            }
            if (data.verified == 1) {
                $('td', row).eq(5).css({'background-color':'green', 'color':'white'});
            }else{
                $('td', row).eq(5).css({'background-color':'#e62525', 'color':'white'});
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
                    deleteUser(data);
                  }
                }
                else{
                  toastr["error"]("Vous doit sélectionner au moins un ligne!");
                }
              }
          },
          {
              text: 'verifier',
              action : (e, dt, node, config)=>{
                const count = table.rows({selected: true}).count();
                if(count != 0){
                  let data = table.rows({selected: true}).data();
                  const len = data.length;
                  startLoading();
                  if(len > 0){
                    verifyUser(data);
                  }
                }
                else{
                  toastr["error"]("Vous doit sélectionner au moins un ligne!");
                }
              }
          },
          {
              text: 'rétablir profil',
              action : (e, dt, node, config)=>{
                const count = table.rows({selected: true}).count();
                if(count != 0){
                  let data = table.rows({selected: true}).data();
                  const len = data.length;
                  if(len == 1){
                    startLoading();
                    reeinstatePassword(data);
                  }else{
                      swal("Erreur!", "sélectionner un seul utilisateur!!", "error");
                  }
                }
                else{
                  toastr["error"]("Vous doit sélectionner au moins un ligne!");
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


@include("includes.footer")