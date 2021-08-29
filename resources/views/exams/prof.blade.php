@include("includes.head")
<div class="bootstrap">
    <div class="card examsWidth mx-auto mb-4" style="margin-top:50px;margin-bottom:20px;">
        <div class="card-header">Examens</div>
        <h3 class="mr-2 ml-2">Ajouter un examen</h3>
        <form class="p-3">
            <div class="row mb-4">
                <div class="col-lg-6">
                    <label class="pt-1" for="module">Niveau et module</label>
                </div>
                <div class="col-lg-6">
                    <select class="form-control" id="module">
                        
                    </select>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-3">
                    <label class="pt-1" for="start">Temps de commancement</label>
                </div>
                <div class="col-lg-3">
                    <input id="start" class="form-control" type="datetime-local">
                </div>
                <div class="col-lg-3">
                    <label class="pt-1" for="end">Temps d'arrêt</label>
                </div>
                <div class="col-lg-3">
                    <input id="end" class="form-control" type="datetime-local">
                </div>
            </div>
            <div class="row mt-4">
                <div class="ui buttons mx-auto"> 
                    <button class="ui button positive" id="submit" type="submit" op="add">Ajouter</button> 
                    <div class="or" data-text="ou"></div> 
                    <button id="cancel" class="ui button red">Annuler</button> 
                </div>
            </div>
        </form>
        <hr>
        <div class="p-3">
            <table class="table table-striped table-bordered  dataTable no-footer w-100" id="examsProf">
                <thead class="bg-primary" style="color:white;">
                  <tr>
                    <th scope="col" >Examen ID</th>
                    <th scope="col" >Niveau</th>
                    <th scope="col" >Module</th>
                    <th scope="col" >Temps de commancement</th>
                    <th scope="col" >Temps d'arrêt</th>
                    <th scope="col">Questions</th>
                  </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
var modules = "ss";
$.ajax({
    url:"/api/prof/moduleLevel",
    async:false,
    type:"GET",
    dataType:"json",
    success:function(data)
    {
        data.forEach(function(d){
            modules+="<option value='"+d.id+"'>"+d.level+" "+d.code+"</option>";
        }); 
    },
    error:function(xhr)
    {
        console.log(xhr.responseText);
    }
});
function errorTreat(response)
{
    if( response.status === 422 ) { var errors = $.parseJSON(response.responseText); $.each(errors, function (key, value) { swal("Error!", value, "error"); } ); } else{ swal("Error!", "Something went wrong!", "error"); }
}
function cancel()
{
    $("#module").val("");
    $("#start").val("");
    $("#end").val("");
}
function add(t)
{
    var module = $("#module").val();
    var start = $("#start").val();
    var end = $("#end").val();
    if(start===""||start===null||start===undefined||module===""||module===null||module===undefined||end===""||end===null||end===undefined)
        toastr["error"]("Veuillez remplir tous les champs");
    else
    {
        $.ajax({
            url:"/api/prof/exam/add",
            type:"POST",
            data:{module:module,start:start,end:end},
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            beforeSend:function(){$("#submit").addClass("loading").attr("disabled");},
            success:function(d)
            {
                swal("Succès!", "Ajoutée avec succès!", "success");
                setTimeout(function(){
                    window.location.href="/prof/exam/"+d;
                },1000);
            },
            error:function(xhr)
            {
                errorTreat(xhr);
            },
            complete:function(){$("#submit").removeAttr("disabled").removeClass("loading");t.ajax.reload();}
        });        
    }
}
$(document).ready(()=>{
    $("#module").html(modules);
    $("#cancel").click(function(event){
        event.preventDefault();
        cancel();
    });
    table = $('#examsProf').DataTable(
            { 
            "scrollX": true,
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json" },
            "ajax": { 
              url: "/api/prof/exam/all",
              cashe: true,
              dataSrc: ""
            },
            "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50, 100 , "Tous"]],
            "columns": [
                  {"data": "id"},
                  {"data": "level"},
                  {"data": "module_name"},
                  {"data": "start",},
                  {"data": "end"},
                  {"data": "id","render":function(d){return "<center><a class='ui button positive' href='/prof/exam/"+d+"'>Les questions</a></center>"}}
                ],
            responsive: true
    });
    $("#submit").click(function(event){
        event.preventDefault();
        add(table);
    });
});
</script>
<script src="{{URL::asset('resources/js/global.js')}}"></script>
</body>
</html>