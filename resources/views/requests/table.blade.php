@include("includes.head")
@include("includes.menu")

<div class="bootstrap">

<h1></h1>
    <div class="card w-75 mx-auto mb-10" style="margin-buttom:20%;min-height:100px;margin-top:100px">
        <div class="w-75 mx-auto p-3 mt-10 mb-10">
            <h3>Les demandes</h3>
        </div>
        <div class="ui form  w-75 mx-auto bordered " style="min-height:200px">
                <div class="field">
                    <label for="module">choisit une demande</label>
                    <select name="demande" id="demande">
                        @foreach($demande as $key => $value)
                            <option value="{{$value->id}}">{{$value->label}}</option>
                        @endforeach
    
                    </select>
                    <div class="field mx-auto">
                        <center><button class="ui button positive w-75" style="margin-top:10%" id="butt-demande"> Demande </button></center>    
                    </div>
                    
                </div>
        </div>        
    </div>




<div class="w-75 mx-auto p-3 mt-45 mb-10">
    <h2>Votre demandes:</h2>
</div>



    <div class="card w-95 mx-auto p-3 mt-2 mb-10 ">
        <table class="table table-striped table-bordered dataTable no-footer" style="width:100%" id="RequestTable">
            <thead class="bg-primary" style="color:white;">
              <tr>
                <th scope="col"></th>
                <th scope="col">#</th>
                <th scope="col">type</th>
                <th scope="col">disponibilté</th>
                <th scope="col">estimation</th>
                <th scope="col">soumis le</th>                
              </tr>
            </thead>
        </table>
    </div>
</div>

</div>
    

<script>
     
    $("#demande").selectize({maxItems:1,options:[""],labelField:"Module",searchField:"Module",valueField: 'id', create: function(input) { return { value: input, text: input } }});
    var x = true;
     $(function () {
        $('#butt-demande').on("click", function(){
            var $select = $("#demande").selectize();
            var selectize = $select[0].selectize;
            //see if the user set the value
            var choix = selectize.items[0];
        
            if(choix){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "/request",
                    async: false,
                    data:{
                        student : "{{auth()->user()->cne}}",
                        type : choix,
                        is_done: 0,
                        
                    },
                    beforeSend: ()=>{
                        startLoading();
                        $('#demande').attr('disabled', 'true').addClass("loading");
                    },
                    success: function(response){
                        table.ajax.reload();
                        swal("réussir", "demande est en cours de traitement!", "success");
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
                        $('#demande').removeAttr('disabled').removeClass('loading');
                        stopLoading();
                    }
                    
                });
            }
        });
        
        //show the form to add students
    });
    
    
    
    
    var table = null;
    table = $('#RequestTable').DataTable({
    "ajax": {
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "/request/data",
      type:"POST",
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
                $('td', row).eq(3).css({'background-color':'green', 'color':'white'});
            }else{
                $('td', row).eq(3).css({'background-color':'red', 'color':'white'});
            }
        },
    "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json" },
    responsive: true,
    order: [[ 1, 'asc' ]],
    dom: 'Bflrtip',
    buttons: [
          {
            text: 'actualiser',
            action : (e, dt, node, config)=>{
              table.ajax.reload();
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