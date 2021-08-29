<!--tayeb hamdaoui-->
<div class="bootstrap">
    
    <div class="w-75 mx-auto p-3 mt-45 mb-10">
        <h2>Les notes de modules: {{$students[0]->CODE}}</h2>
    </div>
    <div class="card w-95 mx-auto p-3 mt-2 mb-10 ">
    <table class="table table-striped table-bordered dataTable no-footer" style="width:100%" id="mark-table" >
        <thead  class="bg-primary" style="color:white;">
            <tr>
                <th>#</th>
                <th>CNE</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th style="width:10%">Note</th>
                <th>Décision</th>
            </tr>
        </thead>
        <tbody>
            @php
            $i = 0
            @endphp
            @foreach($students as $key => $value)
            <tr>
                <td>#</td>
                <td>{{$value->student}}</td>
                <td>{{$value->lname}}</td>
                <td>{{$value->fname}}</td>
                <td>{{$value->mark}}</td>
                <td>
                @php
                        if($value->level == 'CP1' || $value->level == 'CP2'){
                            echo $value->mark >= 10? "V" : "R";
                        }else{
                            echo $value->mark >= 12? "V" : "R";
                        }
                @endphp
                </td>
            </tr>
            
            @php
            $i++
            @endphp
            @endforeach
        </tbody>
    </table>
    </div> 
</div>

<script>
      var table = null;
    $(function(){
         table = $('#mark-table').DataTable({
            "order": [[0, "desc"]],
            "aaSorting": [],
            "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50, 100 , "Tous"]],
            //"deferRender": true,//optimises
            "scrollX": true,
            async: false,
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json" },
            responsive: true,
            order: [[ 1, 'asc' ]],
            "dom": "Bflrtip",
            buttons:[
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
               
            ],
            
        });
        

    });
</script>