@include('includes.head')
@include('includes.menu')


<div class="bootstrap">
    
  <div class="container">
    <h1 class = "ui dividing header mx-auto" style="margin-top:5%">Les stages disponible</h1>
    <div class="ui text container mx-auto mt-45">
      <p style="border: 1px solid grey;border-radius:0.5rem;padding:0.5%;padding:50px">ce sont les stages que notre école propose à nos étudiants,
      où nous attribuons pour chaque stage un superviseur, vous pouvez mettre une demande pour le stage que vous souhaitez. Pour les étudiants qui
      ont été acceptés en stage, vous pouvez faire une autre demande lorsque votre période de stage est terminée. les demandes sont approuvées par
      l'administration, si vous êtes approuvé vous pouvez vérifier votre nom dans la liste des stages, vous ne pouvez demander que des stages liés
      à votre domaine. vous pouvez poser plusieurs demandes, mais une fois que vous êtes accepté, vos autres options seront automatiquement supprimées,
      </p>
    </div>

      <div class="ui cards  w-75 mx-auto p-3 mt-45 mb-10" style="margin:auto" >
        @foreach ($interns as $item)
            <div class="card mx-auto" id="intern-{{ $item->id }}" style="padding:30px">
              <div class="dividing header">
                {{ $item->level }}
              </div>
              <div class="content">
                <img class="right floated mini ui image" src="{{URL::asset('/resources/images/'.$item->level) }}.png">
                <div class="header">
                  {{ $item->object }}
                </div>
                <div class="meta">
                  <b>Professeur responsable: </b>{{ $item->added_by }}
                </div>
                <div class="description">
                  <b><em>From: </em>{{ $item->date_start }}</b>
                  <br>
                  <b><em>To: </em>{{ $item->end_offer }}</b>
                </div>
              </div>
              <div class="extra content">

                @if(time() > strtotime($item->date_start))
                  <div class="ui two buttons">
                    <div class="ui basic red button" aria-disabled="true">offre expiré</div>
                  </div>
                @else
                  <div class="ui two buttons">
                    <div class="btn ui basic green button" onclick="sendDemand({{ $item->id }})" id="bootbox">Envoyer une demande</div>
                  </div>
                @endif

              </div>
            </div>
        @endforeach

      </div>



</div>
              



    {{-- check if user already clicked more than one time on the same internship --}}

  



<script>

  
  function sendDemand(id){
    console.log(id);
    var modal = bootbox.prompt({
      title: "ajoutez des informations supplémentaires dans votre demande si vous le souhaitez",
      inputType: 'textarea',
      buttons:{
        cancel: {
          label: 'Annuler',
          className: 'btn-danger',
          callback: function () {
            modal.modal.hide();
          }
        },
        confirm: {
          label: 'Confirmer',
          className: 'btn-success',
        },
      },
      callback: function(text) {
                //later don't forget to use cookies to not let these offers appear again 
                //dialog appear asks for more specification about the
                if(text){
                    let url  = "{{ route('demande.store') }}";
                    $.ajax({
                      headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }, 
                      type: "POST",
                      url: url,
                      dataType: "json",
                      before: ()=>{
                          startLoading();
                      },
                      data : {
                              internship_id: id,
                              user_id: "{{ auth()->id() }}",
                              type: "demande stage",//we realyy should add demand type table
                              additional_input: text,
                              cne: "{{ auth()->user()->cne }}"             
                            },
                      success: function (response) {
                        swal("succès!", "Votre demande a été envoyée pour être traitée ", "success");
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
                      complete: (response)=>{
                        stopLoading();  
                        $("#intern-"+id).fadeOut("2000");
                      } 
                    });
                }

           },    
      show: false,
      onEscape: function() {
        modal.modal("hide");
      }
    });
    $('.bootbox').wrap('<div class="bootstrap"></div>').addClass("medium");
    modal.find(".modal-content").css("width","100%");  
    modal.modal("show");
  }
</script>

@include('includes.footer')