<!DOCTYPE html>
<html lang="fr">
    <head>

 <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/png" href="{{ URL::asset('resources/images/icon.png') }}"/>
        
        <!-- Icon -->
        <title> ENSAH  {{ ucwords(basename($_SERVER["REQUEST_URI"], '.php')) }}</title>

        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- CSS Bootstrap -->
        <link href="{{ URL::asset('resources/css/bootstrap.min.css') }}" rel="stylesheet">
        
        <!-- JSBootstrap -->
        <script src="{{ URL::asset('resources/js/bootstrap.min.js') }}"></script>
        
        <!-- CSS Semantic UI -->
        <link href="{{ URL::asset('resources/assets/semanticUI/semantic.css') }}" rel="stylesheet">
        
        <!-- JS Semantic UI -->
        <script href="{{ URL::asset('resources/assets/semanticUI/semantic.min.js') }}"></script>
        
        <!-- CSS Font Awesome -->
        <link href="{{ URL::asset('resources/assets/font-awesome/css/all.css') }}" rel="stylesheet">
        
        <!-- jQuery -->
        <script src="{{ URL::asset('resources/js/jQuery.js') }}"></script>
        
        <!-- DataTable -->
        <link href="{{ URL::asset('resources/assets/datatable/datatables.min.css') }}" rel="stylesheet">
        <script src="{{ URL::asset('resources/assets/datatable/datatables.min.js') }}"></script>
        
        <!--Alerts -->
        
            <!-- Sweet -->
        <script src="{{ URL::asset('resources/assets/alerts/sweet.js') }}"></script>
        
            <!-- Bootbox -->
        <script src="{{ URL::asset('resources/assets/alerts/bootbox.js') }}"></script>
        
            <!-- Toastr -->
        <link href="{{ URL::asset('resources/assets/alerts/toastr.css') }}" rel="stylesheet">
        <script src="{{ URL::asset('resources/assets/alerts/toastr.js') }}"></script>
        
         <!-- JS Globally -->
        <script src="{{URL::asset('resources/js/preglobal.js')}}"></script>
        
        <!-- Selectize CSS -->
        <link href="{{ URL::asset('resources/css/selectize.css') }}" rel="stylesheet">
        
        <!-- Selectize JS -->
        <script src="{{ URL::asset('resources/js/selectize.js') }}"></script>
        
        <!-- Video js CSS -->
        <link href="{{ URL::asset('resources/css/videojs.css') }}" rel="stylesheet">
        
        <!-- Uploader JS -->
        <script src="{{ URL::asset('resources/js/uploader.js') }}"></script>
        
        <!-- Material Icon CSS -->
        <link rel="stylesheet" href="{{ URL::asset('resources/css/materialicons.css') }}" />
        
        <!-- App Pure CSS -->
        <link rel="stylesheet" href="{{URL::asset('public/css/app.css')}}" />
        
        <!-- Main Pure CSS -->
        <link href="{{ URL::asset('css/main.css') }}" rel="stylesheet">
        <script src="http://ensah.trackiness.com/resources/js/chartjs.js"></script>

    </head>
    <style>
    div#bootbox {
    width: fit-content;}
    .addr {
    padding-bottom: 50px!important;}
   
.ui.two.buttons {
    width: 55%;
    display: block;
    margin-left: auto;
}
    .bootstrap{box-sizing: border-box!important}
        *{box-sizing: inherit!important}
       .bootbox.modal.fade.w-dialog.mx-auto.show .modal-dialog {
           box-sizing: border-box!important;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            width: 100vw!important;
            margin-left: auto!important;
            margin-right: auto!important;
        }
        .v____cc________sk{   
                display: flex!important;
                width: 100%;
                align-items: center;
                justify-content: center;
        }
.v____cc________sk i.fa.fa-upload.videoShowingCustom {
    display: block;
    width: fit-content;
}
@media (min-width: 900px)
.m-95-d-50 {
    width: 100%!important;
}
    </style>
    <body >
        
            <div  id="AdminCaontainer" style="box-sizing: inherit!important"></div>

<script >

                    
                    function getRoleName(options_Roles,id)
                    {
                        for(let i=0;i<options_Roles.length;i++)
                            if(options_Roles[i].id==id) return options_Roles[i].role;
                    }
                      
                    function addnews(){
                      options_Roles = [];
                      $(this).attr("disabled","true");
                      
                      var dialog = bootbox.dialog({
                          title: 'L\'ajout d\'une annonce',
                          message: '<div class="ui placeholder"><div class="paragraph"> <div class="line"></div> <div class="line"></div> <div class="line"></div> <div class="line"></div> <div class="line"></div> </div> </div>'
                      });
                                  
                      dialog.init(function(){
                          $.ajax({
                              headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                              type:"POST",
                              async:false,
                              url:"/roles/allJson",
                              success:function(data)
                              {
                                  data=JSON.parse(data);
                                  data.forEach(function(d){options_Roles.push({id:d.id,role:d.label})});
                              },
                              error:function(xhr)
                              {}
                          });
                          $('.bootbox').wrap('<div class="bootstrap"></div>').addClass("w-dialog mx-auto");
                          dialog.find('.bootbox-body').html('<div class="bootstrap"> <form  method="POST" enctype="multipart/form-data" id="create-announcement"> <div class="form-group"> <label for="title">Title</label> <input type="text" name="title" class="form-control" id="title" placeholder="Title"> </div> <div class="form-group"> <label for="type">Select Type</label> <select name="type" id="type" style="height: 34px"> <option>evenement</option> <option default>examen</option> <option>administratif</option> <option>important</option> <option>...</option> </select> </div> <div class="form-group"> <label for="role">Previlleges</label> <select name="role" id="role" ></select> </div> <div class="form-group"> <label for="content">Content</label> <textarea name="content" class="form-control textareaDialog" id="content" rows="6"></textarea> </div> <div class="form-group"> <label class="ui primary button" for="attachement"><img src="/resources/images/fileInput.png" height="20px" /> Uploader un fichier</label><p id="uploaded">Il y a pas encore un fichier sélectionner</p> <input type="file" id="attachement" name="attachement" accept=".pdf,.jpeg,.jpg,.png" hidden/></div> <div class="form-row"> <div class="ui buttons mx-auto"> <button class="ui button positive" id="submit" type="submit" op="add">Ajouter</button> <div class="or" data-text="ou"></div> <button  id="cancel" class="ui button red">Annuler</button> </div></div> </form> </div>');
                          $("#attachement").change(function(){
                              if($(this)[0].files.length!=0)  $("#uploaded").html("");
                              for(let i=0;i<$(this)[0].files.length;i++)
                              {
                                  $("#uploaded").append($(this)[0].files[i].name);
                                  if(i!=$(this)[0].files.length-1) $("#uploaded").append(" & ");
                              }
                          });
                          $("#role").selectize({maxItems:1,options:options_Roles,labelField:"role",searchField:"role",valueField: 'id', create: function(input) { return { value: 0, text: "kk" } }});
                          t='<option value="evenement">Evenement</option>';
                          t+='<option value="affichage">Affichage</option>';
                          t+='<option value="concour">Concour</option>';
                          t+='<option value="resultatConcour">Résultat Concours</option>';
                          t+='<option value="avertissement">Avertissement</option>';
                          t+='<option value="general">General</option>';
                          var type_select=$("#type");
                          type_select.selectize()[0].selectize.destroy();
                          type_select.empty();
                          type_select.append(t);
                          type_select.selectize({
                              sortField: 'text'
                          });
                      });
                      
                      
                      dialog.on("shown.bs.modal",function(){$("#addNews").removeAttr("disabled")});
                      $(document).ready(function () {
                              $("#cancel").click(function(event){event.preventDefault();dialog.modal("hide");});
                              
                              $("#submit").click(function(event){
                                event.preventDefault();
                                var op = $(this).attr("op");
                                var id_row;
                                var formData = new FormData(document.getElementById("create-announcement"));
                                if(op=="edit") {id_row=$(this).attr("data-id");}
                                //get the input data
                                let title = $("#title").val();
                                let _token = $("meta[name='csrf-token'").val();
                                let type = $("#type").val();
                                let role = $("#role").val();
                                let content = $("#content").val();
                                let user_id = $("input[name='user_id']").val();
                                var err=null;
                                  if(title==""||type==""||role==""||content==""||title==null||type==null||role==null||content==null)
                                      err=-1;
                                  else if(title.length<10)
                                      err=-2;
                                  else if(parseInt(role)===role)
                                      err=-3;
                                  if(err!=null)
                                  {
                                      switch(err)
                                      {
                                          case -1:toastr["error"]("Quelques champs sont vides!");break;
                                          case -2:toastr["error"]("Le titre est très petit, essayer avec 10 charactères!");break;
                                          case -3:toastr["error"]("Le role est incorrect!");break;
                                          default:toastr["error"]("Il y a un problème dans quelque part!");break;
                                      }
                                  }
                                  else{
                                        //validation
                                        var method;
                                        var url;
                                        var label="";
                                        if(op=="add")
                                               {method = "post";url = "/announcement/store";label="ajoutée"}
                                          else if(op=="edit")
                                               {method = "post";url = "/announcement/update/"+id_row;label="modifiée"}
                                          else 
                                               {method = "get";url = "/";}
                                        $.ajax({
                                          headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                          type: method,
                                          url: url,
                                          data: formData/*{
                                            title:title,
                                            type:type,
                                            role:role,
                                            content:content,
                                            attachement:attachement,
                                            user_id:user_id
                                          }*/,
                                          dataType: "text json",
                                          beforeSend:function(){$("#submit").attr("disabled","true").css("width",$("#submit").css("width")).addClass('loading');},
                                          success: function (response) {
                                            dialog.modal("hide");
                                            swal("succès!", "L'annonce a été "+label+"!", "success");
                                          },
                                          error: function (response) {
                                            if( response.status === 422 ) {
                                              var errors = $.parseJSON(response.responseText);
                                              $.each(errors, function (key, value) {
                                                  swal("Error!", value, "error");
                                                }
                                              );
                                            }
                                            else{
                                              swal("Error!", "Something went wrong!", "error");
                                            }
                                            //$("#mediumModal").modal('hide');
                                            
                                          },         
                                          cache: false,
                                          contentType: false,
                                          processData: false,
                                          complete:function(){
                                              $("#submit").removeAttr("disabled").removeClass('loading');
                                          }
                                        });
                                  }
                              });
                          });
                    }
                    
                    const selectii=(role_id,type)=>{
                        var $select = $("#role").selectize();
                                      var selectize = $select[0].selectize;
                                      selectize.setValue(role_id);
                                      var $select_type = $("#type").selectize();
                                      var selectize_type = $select_type[0].selectize;
                                      selectize_type.setValue(type);
                    }
        </script>
<script src="http://ensah.trackiness.com/resources/js/videojs.js"></script>
<script src="http://ensah.trackiness.com/resources/js/uploader.js"></script>

 <script  src="{{URL::asset('js/app.js')}}"></script>
<script type="text/html" id="files-template">
      <li class="media">
        <div class="media-body mb-1">
          <p class="mb-2">
            <strong>%%filename%%</strong> - Status: <span class="text-muted">Waiting</span>
          </p>
          <div class="progress mb-2">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
              role="progressbar"
              style="width: 0%" 
              aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            </div>
          </div>
          <hr class="mt-1 mb-1" />
        </div>
      </li>
    </script>
    </body>

</html>