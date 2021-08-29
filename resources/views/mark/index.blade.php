@include("includes.head")
@include("includes.menu")

<div class="bootstrap">

<h1></h1>
    <div class="card w-75 mx-auto mb-10" style="margin-buttom:20%;min-height:100px;margin-top:100px;">
        <div class="w-75 mx-auto p-3 mt-45 mb-10">
            <h3>Gestion des notes</h3>
        </div>
        <div class="ui form  w-75 mx-auto bordered " style="min-height:200px">
                <div class="field">
                    <label for="module">Votre modules</label>
                    <select name="module" id="module">
                        <option value="">Selectinonner un module</option>
                        <option value="AI">Select un module</option>
                        @foreach($module as $key => $value)
                            <option value="{{$value[0]->id.'-'.$value[0]->level}}">{{$value[0]->code . '  ' . $value[0]->level}}</option>
                        @endforeach
    
                    </select>
                </div>
        </div>        
    </div>


    <div class="Inputform" >
        
    </div>


</div>
    

<script>
     $("#module").selectize({maxItems:1,options:[""],labelField:"Module",searchField:"Module",valueField: 'id', create: function(input) { return { value: input, text: input } }});
    var x = true;
     $(function () {
        $('#module').on("change", function(){
            var $select = $("#module").selectize();
            var selectize = $select[0].selectize;
            //see if the user set the value
            var choix = selectize.items[0];
            
            console.log(selectize.items[0]);

            if(choix){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "GET",
                    url: "/mark/create/"+choix,
                    async: false,
                    beforeSend: ()=>{
                        startLoading();
                        $('#module').attr('disabled', 'true').addClass("loading");
                    },
                    success: function(response){
                        $(".Inputform").html(response).hide().slideDown("3000");
                    },
                    error: function(xhr){
                        console.log(xhr);
                    },
                    complete: (response)=>{
                        $('#module').removeAttr('disabled').removeClass('loading');
                        stopLoading();
                    }
                    
                });
            }
        });
        
        //show the form to add students
    });
</script>
@include("includes.footer")