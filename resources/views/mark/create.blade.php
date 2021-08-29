
<div class="bootstrap">
    
    <div class="w-75 mx-auto p-3 mt-45 mb-10">
        <h2>Saisir des notes</h2>
    </div>
    <div class="card w-95 mx-auto p-3 mt-2 mb-10 ">
    <table class="table table-striped table-bordered dataTable no-footer" style="width:100%" id="mark-table" >
        <thead  class="bg-primary" style="color:white;">
            <tr>
                <th>#</th>
                <th>CNE</th>
                <th>nom</th>
                <th>prenom</th>
                <th style="width:10%">note</th>
            </tr>
        </thead>
        <tbody>
            @php
            $i = 0
            @endphp
            @foreach($student as $key => $value)
            <tr>
                <td>#</td>
                <td>{{$value->cne}}</td>
                <td>{{$value->lname}}</td>
                <td>{{$value->fname}}</td>
                <td><div class="col-xs-2"><input class="ui form-control" type="number" max="20" min="0" step="0.01" id="row-{{$i}}" ></div></td>
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


    function sendMarks(note, cne, module_level){
        let url = "/mark";
        $.ajax({
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url: url,
              async: false,
              data:{
                  student: cne,
                  mark: note, 
                  module_level,
              },
              type: "POST",
              success: function(response){
                console.log(response);
              },
              error: function(response){
                  console.log(response);
                  table.ajax.reload();
                  toastr["error"]("Something went wrong!");
              },
              complete:function(){
                  //stopLoading();
              }            
        });
    }
    
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
                        table.ajax.reload;
                    }
                },
               'csvHtml5',
               'excelHtml5',
               'pdfHtml5',
               {
                   text: "soumettre",
                   action: (e, dt, node, config)=>{
                       const count = table.rows().count();
                       if(count > 0){
                            let data = table.rows().data();
                            //if one mark is empty or not correct do not store values
                            let err = false;
                            $('.ui.form-control').each(function(index, element){
                                let note = $('#row-'+index).val();
                                if(!note){
                                    swal("Error!", "Une valeur n'est pas entre 0 et 20.", "error");
                                    err = true;
                                }
                                
                                if(note >20 || note<0){
                                    swal("Error!", "Une valeur n'est pas entre 0 et 20.", "error");
                                    err = true;
                                }
                            });
                            
                            if(!err){
                                $('.ui.form-control').each(function(index, element){
                                    //call the function that will insert all of these values
                                    
                                    console.log($('#row-'+index).val());
                                    let note = $('#row-'+index).val();

                                    let cne = data[index][1];
                                    let module_level = {{$module}};
                                    sendMarks(note,cne, module_level);
                                    console.log("module_level: "+module_level);
                                    
                                    
                                });                                
                            }
                            
                            
                           
                       }else{
                           swal("Error!", "Tableau vide!", "error");
                       }
                   }
               }
               
               
            ],
            
        });
        

    });
</script>

 