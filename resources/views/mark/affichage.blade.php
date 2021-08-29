@include("includes.head")
@include("includes.menu")

<div class="bootstrap">

    <div class="container">
        <h1 class = "ui dividing header mx-auto" style="margin-top:5%">L'affichage de votre class: {{$module_levels[0]->level}}</h1>
    
        <div class="affichage" >
            
        </div>

        <div class="ui cards  w-75 mx-auto p-3 mt-45 mb-10">
            @php
                $i = 0;
            @endphp
            @foreach($module_levels as $modules)
            <div class="card">
              <div class="content">
                <div class="header">{{$modules->code}}</div>
                <div class="description">
                  <b>crée dans le: {{$modules->created_at}}</b> 
                </div>
              </div>
              <div class="ui bottom attached button" id="{{$i}}" onclick="note('{{$modules->id}}')">
                <i class=" icon"></i>
                    affichage des notes
              </div>
            </div>
            @endforeach
          </div>
    </div>


</div>

<script>

    function note(id){
        console.log(id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: "/mark/"+id,
            async: false,
            beforeSend: ()=>{
                startLoading();
                $('.ui.bottom.attached.button').attr('disabled', 'true').addClass("loading");
            },
            success: function(response){
                $(".affichage").html(response).hide().slideDown("3000");
            },
            error: function(xhr){
                    if( xhr.status === 422 ) {
                      var errors = $.parseJSON(xhr.responseText);
                      $.each(errors, function (key, value) {
                          swal("Error!", value, "error");
                      });
                    }
                console.log(xhr);
            },
            complete: (response)=>{
                $('.ui.bottom.attached.button').removeAttr('disabled').removeClass('loading');
                stopLoading();
            }
            
        });        
    }
</script>


@include("includes.footer")