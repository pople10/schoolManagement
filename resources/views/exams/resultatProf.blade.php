@include("includes.head")
<div class="bootstrap">
    <div class="card examsWidth mx-auto mb-4" style="margin-top:50px;margin-bottom:20px;">
        <div class="card-header">Résultat d'examens</div>
        <form class="p-3">
            <div class="row mb-4">
                <div class="col-lg-6">
                    <label class="pt-1" for="module">Selectionner un examen</label>
                </div>
                <div class="col-lg-6">
                    <select class="form-control" id="exams">
                        @foreach($data as $val)
                            <option value="{{$val->id}}">Examen {{$val->id}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
        <hr>
        <div class="p-3">
            <table class="table table-striped table-bordered  dataTable no-footer w-100" id="examsProfRes">
                <thead class="bg-primary" style="color:white;">
                  <tr>
                    <th scope="col" >CNE</th>
                    <th scope="col" >Nom</th>
                    <th scope="col" >Prenom</th>
                    <th scope="col" >Note</th>
                    <th scope="col" >Note sur 20</th>
                  </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
$(document).ready(()=>{
    var table = $('#examsProfRes').DataTable(
            { 
            "scrollX": true,
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json" },
            "ajax": { 
              url: "/api/exam/prof/result/{{$data[0]->id}}",
              cashe: true,
              dataSrc: ""
            },
            "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50, 100 , "Tous"]],
            "columns": [
                  {"data": "cne"},
                  {"data": "nom"},
                  {"data": "prenom"},
                  {"data": "note",},
                  {"data": "note_rel"}
                ],
            responsive: true
    });
    $("#exams").change(function(){
        $('#examsProfRes').DataTable().ajax.url("/api/exam/prof/result/"+$(this).val()).load();
    });
});
</script>
<script src="{{URL::asset('resources/js/global.js')}}"></script>
</body>
</html>