@include('includes.head')
@include('includes.menu')
<div class="bootstrap">

<div class="w-75 mx-auto p-3 mt-45 mb-10">
    <h2>Gestion des stages</h2>
</div>
    <div class="card w-95 mx-auto p-3 mt-45 mb-10" style="width:100px">

        <button class="ui positive button mx-auto" id="add-internship"><i class='fa fa-angle-double-down' style='color:white'></i> Ajouter un offre du stage</button>
            <div class="card-body" id="internshipForm">

            </div>
        </div>



<div class="card w-95 mx-auto p-3 mt-2 mb-10 ">
  <table class="table table-striped table-bordered dataTable no-footer" style="width:100%" id="internship-table">
    <thead class="bg-primary" style="color:white;">
      <tr>
        <th scope="col"></th>
        <th scope="col">#</th>
        <th scope="col" >Etudiant</th>
        <th scope="col">Filiére</th>
        <th scope="col">Professeur responsable</th>
        <th scope="col" >Sujet</th>
        <th scope="col" >Type</th>
        <th scope="col" >Entreprise</th>
        <th scope="col" >Date de commencement</th>
        <th scope="col" >Date de termination</th>
        <th scope="col" >date de création</th>
        <th scope="col" >date de mise à jour</th>
      </tr>
    </thead>
</table>
</div>
  </div>
<script>
function deleteInternship(id){
  let url = '{{ route("internship.destroy", ["internship"=>":id"]) }}';
  url = url.replace(":id", id);
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
                  swal("Stage supprimée!", {
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


function deleteInternshipArray(array){
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
          let url = '{{ route("internship.destroy", ["internship"=>"*ss*"]) }}';
          url = url.replace("*ss*", array[i].id);
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
                toastr["error"]("stage " + i +" n'est pas supprimé");
              },
              complete:function(){
                  stopLoading();
                  table.ajax.reload();
              }
          });
        }
        if(j==i) 
          swal("Stages supprimées!", {icon: "success",});
        else
          toastr["error"]("Something went wrong!");
    } else {
      swal("Suppression annulée!");
      stopLoading();
    }
  });  
}

//datatable
var table = null;
$(function () {
  table = $('#internship-table').DataTable({
    "scrollX": true,
    "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json" },
    "ajax": {
      url: "{{route('internship.data')}}",
      cashe:false,
      dataSrc: ''
    },
    "order": [[0, "desc"]],
    "aaSorting": [],
    "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50, 100 , "Tous"]],
    "columns":[
      {"data": null,"render":function(data){
        return "";
      }},
      {"data": "id"},
      {"data": "assigned_to"},  
      {"data": "level"},
      {"data": "added_by"},
      {"data": "object"},
      {"data": "type"},
      {"data": "entreprise"},
      {"data": "date_start", "render":(data)=>{
        let datee = data.split(' ');
        return datee[0];
      }},
      {"data": "end_offer", "render":(data)=>{
        let datee = data.split(' ');
        return datee[0];
      }},
      {"data": "created_at"},
      {"data": "updated_at"},
    ],
    order: [[ 1, 'asc' ]],
    //responsive: true,
    dom:'Bflrtip',
    buttons: [
       {
        text: 'actualiser',
        action : (e, dt, node, config)=>{
            table.ajax.reload();
        }
      },
      {
        extend: 'copyHtml5',
        text: 'Copier',
        key: {
          key: 'c',
          ctrlKey: true
        }
      },
      'excelHtml5',
        'csvHtml5',
        'pdfHtml5',
      {
        text: 'supprimer',
        key:{
          key:'d',
          crtlKey: true,
        },  
          /**
           * e : event object
           * dt: datatable API instance
           * node: kquery instance of the button
           * config: the button configuration option
           * */
          action : (e, dt, node, config)=>{
            const count = table.rows({selected: true}).count();
            if(count != 0){
              let data = table.rows({selected: true}).data();
              const len = data.length;
              startLoading();
              if(len > 1){
                deleteInternshipArray(data);
              }else{
                deleteInternship(data[0].id);
              }
            }
            else{
              toastr["error"]("Vous doit supprimer au moins un ligne!");
            }
          }
      },

      {
        text: 'modifier',
        key: {
          key: 'm',
          crtlKey: true,
        },
        action: (e, dt, node, config)=>{
          const count = table.rows({selected:true}).count();
          if(count != 0){
            let data = table.rows({selected: true}).data();
            let len = data.length;
            if(len == 1){
              startLoading();
              table.ajax.reload();
              console.log(data[0].id + ' ' + data[0].assigned_to + '\n' + data[0]);
              let valid = false;     
              $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: "/internship/"+data[0].id+"/edit",
                async:false,
                beforeSend: ()=>{
                  $(".dt-buttons button").attr("disabled","true").addClass('loading');
                  $("#add-internship").hide();
                  if($("div").find('#re-add-internship').length > 0){
                    $('#re-add-internship').remove();
                  }
                  if($("div").find('#remove-internship').length > 0){
                    $('#remove-internship').remove();
                  }
                },
                success: function (response) {
                  //console.log(response);
                  $('#internshipForm').html(response).hide().slideDown("3000", ()=>{
                    doubleCallback();
                    const type = $("#type").attr("data-atr");
                    $("#type").val(type);
                    
                    var $select = $("#prof").selectize();
                    var selectize = $select[0].selectize;
                    const added_by = $("#prof").attr("data-atr");
                    selectize.setValue(added_by);
                    
                    var $select_promo = $("#promo").selectize();
                    var selectize_promo = $select_promo[0].selectize;
                    const promo = $("#promo").attr("data-atr");
                    selectize_promo.setValue(promo); 
                  });
                  valid = true;
                  //console.log(data);
                }, 
                error:function(xhr){
                  console.log(xhr);
                },
                complete:function(){
                  //$('#internshipForm').before("<button class='ui negative button mx-auto' id='remove-edit-internship'>Supprimer la formulaire de modification<i class='fa fa-angle-double-up' style='color:white'></i></button>");
                    stopLoading();
                }
              });

              //bring here the data to the edit form
              if(valid){
                  
                $('#cancel-edit').click((e)=>{
                  e.preventDefault();
                  $("#internship-form-edit").slideUp("3000",(e)=>{
                    $("#internship-form-edit").remove();
                  });
                  $("#remove-edit-internship").remove();
                  $("#add-internship").show();
                  $(".dt-buttons button").removeAttr("disabled").removeClass('loading');
                });
                $('#submit-edit').click((e)=>{
                  e.preventDefault();
                  const cne = $('#etudiant').val();
                  const type = $('#type').val();
                  const prof = $('#prof').val();
                  const _token = $("input[name='_token']");
                  const promo = $('#promo').val();
                  const object = $('#object').val();
                  const entreprise = $("#entreprise").val();
                  const start = $("#start").val();
                  const end = $("#end").val();
                  let err = false;
                  
                  if(!type){
                    toastr["error"]("type est vide!");
                    err = true;
                  }
                  if(!prof){
                    toastr["error"]("professeur responsable est vide!");
                    err = true;
                  }if(!promo){
                    toastr["error"]("promotion responsable est vide!");
                    err = true;
                  }
                  if(!object){
                    toastr["error"]("sujet responsable est vide!");
                    err = true;        
                  }
                  if(!entreprise){
                    toastr["error"]("entreprise responsable est vide!");
                    err = true;
                  }
                  if(!start){
                    toastr["error"]("premiére champ de date est vide!");       
                    err = true;
                  }
                  if(!end){
                    toastr["error"]("deuxième champ de date est vide!");       
                    err = true;
                  }



                  if(!err){
                    $(function () {
                      $.ajax({
                        headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'PUT',
                        url: "/internship/"+data[0].id,
                        dataType: 'json',
                        data : {
                          added_by: prof,
                          date_start: start,
                          end_offer: end,
                          level: promo,
                          object: object,
                          type: type,      
                          entreprise:entreprise,        
                          assigned_to: cne
                        },
                        beforeSend: ()=>{
                          $("#submit-edit").attr("disabled","true").css("width",$("#submit").css("width")).addClass('loading');
                          if($("div").find('#re-add-internship').length > 0){
                            $('#re-add-internship').remove();
                          }
                          if($("div").find('#remove-internship').length > 0){
                            $('#remove-internship').remove();
                          }
                        },
                        success: (response)=>{
                          //console.log(response);
                          table.ajax.reload();
                          $("#cancel").click();
                          swal("succès!", "Le stage a été ajouté!", "success");
                          $("#internship-form-edit").slideUp("3000",(e)=>{
                            $("#internship-form-edit").remove();
                          });
                          $("#remove-edit-internship").remove();
                          $("#add-internship").show();
                        },
                        error: (xhr)=>{
                          console.log(xhr);
                          if( xhr.status === 422 ) {
                            var errors = $.parseJSON(xhr.responseText);
                            $.each(errors, function (key, value) {
                                swal("Error!", value, "error");
                            });
                          }
                          else{
                            swal("Error!", "Something went wrong!", "error");
                          }              
                        },
                        complete:function(){
                          $("#submit-edit").removeAttr("disabled").removeClass('loading');
                          $(".dt-buttons button").removeAttr("disabled").removeClass('loading');
                        }
                      });
                    });

                  }
                });
              }else{
                swal("Error!", "Something went wrong, try again later!", "error");
              }
            }else{
              toastr["error"]("Il faut sélectionner un seul ligne");
            }
          }else{
              toastr["error"]("Il faut sélectionner un seul ligne");
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
});







    var dataProf = [];
    let urlProf = "{{route('users.prof')}}";
    $.ajax({
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
        type: "POST",
        url: urlProf,
        dataType: "json",
        async:false,
        success: function (response) {
          response.forEach((dat)=>{
            dataProf.push({id:dat.id, fullName:dat.fname+" "+dat.lname});
          });
          //let data = JSON.parse(response);
          //console.log(data);
        }, 
        error:function(xhr){
          console.log(xhr);
        }
      });
    


    let urlLevel = "{{ route('level.promo') }}";
    var dataLevel = [];
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: urlLevel,
        dataType: "json",
        async: false,
        success: function (response) {
          response.forEach((dat)=>{
            dataLevel.push({id:dat.id, promoLabel:dat.label});
          });
        }, 
        error:function(xhr){
          console.log(xhr);
        }
      });

 //these fucntions must be called after the slideDown effect           
 function getProfSelectinfo(){

    /*//fill the teacher form
    const profSelectNode = $('#prof');
    //sort data alphabatically
    dataProf.sort((a, b)=>(a.fullName > b.fullname) ? 1: -1);
    dataProf.forEach(element => {
      profSelectNode.append("<option value="+element.id+">"+element.fullName+"</option>");
    });*/
    $("#prof").selectize({maxItems:1,options:dataProf,labelField:"fullName",searchField:"fullName",valueField: 'id', create: function(input) { return { value: input, text: input } }});
  }

  function getPromoSelectInfo(){
    /*const levelSelectNode = $('#promo');
    dataLevel.sort((a, b)=>(a.fullName > b.fullname) ? 1: -1);
    dataLevel.forEach(element => {
      levelSelectNode.append("<option value="+element.id+">"+element.promoLabel+"</option>");
    });*/
     $("#promo").selectize({maxItems:1,options:dataLevel,labelField:"promoLabel",searchField:"promoLabel",valueField: 'id', create: function(input) { return { value: input, text: input } }});
  }
  //call the two functions ^ up there
  function doubleCallback(){
    getProfSelectinfo();
    getPromoSelectInfo();
  }





$(function () {
  $("#add-internship").click(function (e) { 
    e.preventDefault();
    $.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: "GET",
    url: "{{ route('internship.create') }}",
    async:false,
    beforeSend: ()=>{
      $('add-internship').attr('disbaled', 'true').addClass('loading');
    },
    success: function (response) {
      $('#internshipForm').html(response).hide().slideDown("3000", doubleCallback);
      //let data = JSON.parse(response);
      //console.log(data);
    }, 
    error:function(xhr){
      console.log(xhr);
    },
    complete:function(){
      $("#add-internship").removeAttr("disabled").removeClass('loading').hide();
      $('#add-internship').after("<button class='ui negative button mx-auto' id='remove-internship'><i class='fa fa-angle-double-up' style='color:white'> </i> Annuler l'opération     </button>");
      $('#add-internship').after("<button class='ui positive button mx-auto' id='re-add-internship'><i class='fa fa-angle-double-down' style='color:white'></i> Ajouter un offre du stage</button>");
      $('#re-add-internship').hide();
     
    }
  });

  $('#remove-internship').click((e)=>{
    $('#remove-internship').hide();
    $('#internshipForm').slideUp("3000");
    $('#re-add-internship').show();
  });
  $('#re-add-internship').click((e)=>{
    $('#re-add-internship').hide();
    $('#internshipForm').slideDown("3000");
    $("#remove-internship").show();
  });


  $('#cancel').click((event)=>{
    event.preventDefault();
    $('#etudiant').val("");
    $('#type').val("");
    $('#prof').val("");
    $("input[name='_token']");
    $('#promo').val("");
    $('#promo').val("");
    $("#entreprise").val("");
    $("#start").val("");
    $("#end").val("");
    
    $('#remove-internship').click();
  });


  //for prof
  //$("#card").hide();






  $('#submit').click(function (e){
      e.preventDefault();
      let cne = $('#etudiant').val();
      let type = $('#type').val();
      let prof = $('#prof').val();
      let _token = $("input[name='_token']");
      let promo = $('#promo').val();
      let object = $('#object').val();
      let entreprise = $("#entreprise").val();
      let start = $("#start").val();
      let end = $("#end").val();
      let err = false;
      let numberOfErrors = 0;
      

      if(!type){
        toastr["error"]("type est vide!");
        err = true;
      }
      if(!prof){
        toastr["error"]("professeur responsable est vide!");
        err = true;
      }if(!promo){
        toastr["error"]("promotion responsable est vide!");
        err = true;
      }
      if(!object){
        toastr["error"]("sujet responsable est vide!");
        err = true;        
      }
      if(!entreprise){
        toastr["error"]("entreprise responsable est vide!");
        err = true;
      }
      if(!start){
        toastr["error"]("premiére champ de date est vide!");       
        err = true;
      }
      if(!end){
        toastr["error"]("deuxième champ de date est vide!");       
        err = true;
      }



      if(!err){
        $(function () {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            url: "{{ route('internship.store') }}",
            dataType: 'json',
            data : {
              added_by: prof,
              date_start: start,
              end_offer: end,
              level: promo,
              object: object,
              type: type,      
              entreprise:entreprise,        
              assigned_to: cne
            },
            beforeSend: ()=>{
              $("#submit").attr("disabled","true").css("width",$("#submit").css("width")).addClass('loading');;
            },
            success: (response)=>{
              console.log(response);
              table.ajax.reload();
              $("#cancel").click();
              swal("succès!", "Le stage a été ajouté!", "success");
            },
            error: (xhr)=>{
              console.log(xhr);
              if( xhr.status === 422 ) {
                var errors = $.parseJSON(xhr.responseText);
                $.each(errors, function (key, value) {
                    swal("Error!", value, "error");
                });
              }
              else{
                swal("Error!", "Something went wrong!", "error");
              }              
            },
            complete:function(){
              $("#submit").removeAttr("disabled").removeClass('loading');
            }
          });
        });

      }

    });

});

/*  $("#add-internship").click(function (e) { 
    e.preventDefault();
    $("#internship-form").slideToggle("slow");
  });*/
});













  function closeErrorMessage(id){
    $(id).parent().remove();
  }
  function errorMessage(id, message, numberOfErrors){
    const errorClass="error-"+numberOfErrors;
    //find if the error message already exists
    if($('#internship-form').find('#'+errorClass).length != 0){
      console.log($('#internship-form').find('#'+errorClass).length);
    }else{
      const errMessage = "<div class='ui negative message'><button style='position:absolute;right:5px;color:white;background-color:#9F3A38;border:1px solid #9F3A38;border-radius:.5rem' onclick=\x22closeErrorMessage('#"+errorClass+"')\x22  id='"+errorClass+"'>&times</button><div class='header'>"+message+"</div></div>";
      $(id).after(errMessage);
      err = true;
    }
  }

  function reload(){
    table.ajax.reload;
  }





</script>

@include('includes.footer')


