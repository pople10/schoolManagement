@include('includes.head')
@include('includes.menu')

<div class = "bootstrap" id="filiere">
    <div class="R___P">
    <div id="add__r_cc" style="background: rgba(0, 0, 0, 0.34);">
        <div class="el_add__r_cc" >
            <div class="pr_v_t">
               ajouter une nouvelle filiere
            </div>
            <div class="pr_v_e">
                <div class="img___pt" id="l___im_lg_c">
                    <input type="file" name="img" id="file__img___pt" onchange="{Onchangeppimh(this);sendv()}" accept="image/*" />
                    <div class="up___img__lb" >
                        <img loading="lazy" src="{{URL::asset('/resources/images/Upload.svg')}}" id="img____photo__profil"/>
                    </div>
                </div>
                <div class="pr_v_r" style=" flex-direction: column; justify-content: left; align-items: baseline; ">
                    <span class="lb__v_r">Filiere</span>
                    <input type="text" id="filiere_r" class="inp__addr" onkeyup="sendv()" onkeydown="sendv()"/>
                </div>
                <div class="pr_v_r" style=" flex-direction: column; justify-content: left; align-items: baseline; " >
                    <span class="lb__v_r">Description</span>
                    <textarea id="des___f"  rows="3" class="inp__addr"  onkeyup="sendv()" onkeydown="sendv()"></textarea>
                </div>
                
            </div>
            <div class="pr_v_tp">
         
                <div class="bootstrap">
                    <div class="form-row"> 
                    <div class="ui buttons mx-auto">
                         <button  onclick="send_data()" class="ui button positive" id="submit_r" disabled style="background: #2e30b1a3;" type="submit" op="add">Ajouter</button> 
                         <div class="or" data-text="ou">
                             
                         </div> <button id="cancel_rr" onclick="rmvrole()" class="ui button red">Annuler</button> </div></div>
                </div>
             </div>
        </div>
   </div>
    <div class="addr">
        <div class="bootstrap">
        <button type="submit" id="Add__r" class="ui positive button mx-auto" onclick="shwrole()">
            <span>ajouter une nouvelle filiere</span>
        </button>
        </div>
            <div class="bootstrap " style=" width: 100%;" >
                <table class="table table-striped table-bordered dataTable no-footer" style="width:100%" id="roles-table">
                    <thead class="bg-primary" style="color:white;">
                      <tr>
                        <th scope="col"></th>
                        <th scope="col">#</th>
                        <th scope="col" >Filiere</th>
                      </tr>
                    </thead>
                </table>
             </div>
    </div>
</div>

</div>
<script>
    table=null;
  $(document).ready(function () {
            table = $('#roles-table').DataTable(
            { "scrollX": true,
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json" },
            "ajax": { 
              url: "filieres/data",
              cashe: false,
              dataSrc: ""
            },
            "order": [[0, "desc"]],
            "aaSorting": [],
            "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50, 100 , "Tous"]],
            "columns": [

                  {"data": null,"render":function(data){return "";}},
                  {"data": "code"},
                  {"data": "label"},
                ],
          order: [[ 1, 'asc' ]],
            responsive: true,
            dom: 'Blfrtip',
				buttons: [
				    
				    {
						text: 'Supprimer',
						action: function ( e, dt, node, config) {
							var count = table.rows( { selected: true } ).count();
							if(count!=0){
							var data = table.rows( { selected: true } ).data();
							var l = data.length;
							    startLoading();
								if(l>1){
									deletefiltArray(data);
								}
								else
								{	
								    deletefil(data[0].code);
								}
							}
							else
								toastr["error"]("Vous pouvez supprimer au moins une filière!");
						}
					},
				    {
						text: 'Modifier',
						action: function ( e, dt, node, config) {
						    var count = table.rows( { selected: true } ).count();
							if(count>1 ||count ==0){
									toastr["error"]("Vous pouvez modifier une seule filière!");

							}
							else{
							    var data = table.rows( { selected: true } ).data();
							    shwrole(data[0]);
							}
						}
				    },
				    {
						text: 'Refresher',
						action: function ( e, dt, node, config) {
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
				"initComplete":function(settings, json){
				    
				}
            }
        )});
</script>
<script >


         const shwrole=(data)=>{
        var ccad=document.getElementById('add__r_cc');
        ccad.style.opacity=1;
        ccad.style.top=0;
        setTimeout(() => {
            ccad.style.background="#00000057";
        }, 700);
            if(data!=null){
                document.getElementById('submit_r').setAttribute("onclick","send_data('"+data.code+"')");
                document.getElementById('submit_r').innerHTML="Modifier";
                document.getElementById('filiere_r').value=data.label;
                document.getElementById('des___f').value=data.description;
                if(data.logo_url!=null){
                    document.getElementById('img____photo__profil').src=data.logo_url;
                    document.getElementById('img____photo__profil').style.width="100%";
                    document.getElementById('img____photo__profil').style.marginTop="0";
                }
                
            }
        
    }
    const rmvrole=()=>{
        var ccad=document.getElementById('add__r_cc');
        ccad.style.opacity=0;
        ccad.style.top='-100vh';
        ccad.style.background="#0000000";
        document.getElementById('filiere_r').value="";
        document.getElementById('des___f').value="";
        var sbtn=document.getElementById('submit_r');
        sbtn.disabled=true;
        sbtn.style.background="#2e30b1a3";
        sbtn.classList.remove("loading");
         document.getElementById('img____photo__profil').setAttribute('src','/resources/images/Upload.svg');
        document.getElementById('img____photo__profil').style.width="85%";
        document.getElementById('img____photo__profil').style.marginTop="7.5%";
        document.getElementById('submit_r').setAttribute("onclick","send_data()");


    }
        const send_data=(id)=>{
        var sbtn=document.getElementById('submit_r');
        sbtn.disabled=false;sbtn.classList.add("loading");sbtn.style.background="#2e30b1a3";
        const dataform=new FormData();
        dataform.append("fil",document.getElementById('filiere_r').value);
        dataform.append("desc",document.getElementById('des___f').value);
        dataform.append('img',document.getElementById('file__img___pt').files[0]);

        
        const token=document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        if(id==null){
        fetch('/api/filieres/add', {
            method: 'POST',
            headers: {"X-Requested-With": "XMLHttpRequest","X-CSRF-TOKEN":token},
            body: dataform
        }).then(function(res){ return res.json();}).then(function(json) {
            if(json===true){
            swal("Ajouté avec succès", { icon: "success",});console.log(json);
            rmvrole();table.ajax.reload()
        }else{sbtn.disabled=false;
        table.ajax.reload();
        sbtn.style.background="#2e30b1a3";console.log(json);swal("Something wrong !", { icon: "warning",});} 
        sbtn.classList.remove("loading");
           });
        }
        else{
            let url='api/filieres/modifier/'+id;
            console.log(url)
            fetch(url, {
            method: 'POST',
            headers: {"X-Requested-With": "XMLHttpRequest","X-CSRF-TOKEN":token},
            body: dataform
            }).then(function(res){ return res.json();}).then(function(json) {if(json===true){
                console.log(json); 
            swal("Modifé avec succès", { icon: "success",});
            rmvrole();table.ajax.reload();
            document.getElementById('submit_r').innerHTML="Ajouter";
            }else{sbtn.disabled=false;table.ajax.reload();sbtn.style.background="#2e30b1a3";swal("Something wrong !", { icon: "warning",});console.log(json); } 
            sbtn.classList.remove("loading");table.ajax.reload();
                });
            
        }
    }
    const sendv=()=>{
        var inr=document.getElementById('filiere_r');
        var inrtx=document.getElementById('des___f');
        var sbtn=document.getElementById('submit_r');
        if(inr.value.length>2 && inrtx.value.length>2) {
            sbtn.disabled=false;
            sbtn.style.background="#2e30b1";
        }
        else  {sbtn.disabled=true;sbtn.style.background="#2e30b1a3"}
    }
    
  const Onchangeppimh=(e)=>{
    var t=e.target || window.event.srcElement;
    var fi=t.files;
    if (FileReader && fi && fi.length){
    var f=new FileReader();
    f.onload=(a)=>{
        document.getElementById('img____photo__profil').setAttribute('src',a.target.result);
        document.getElementById('img____photo__profil').style.width="100%";
        document.getElementById('img____photo__profil').style.marginTop="0";
      
    }
    f.readAsDataURL(fi[0]);
    }

  }
  function deletefil(id){
        let url = '/filieres/'+id;
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
                        swal("Filière supprimé!", {
                          icon: "success",
                        });
                    },
                    error: function(response){
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
                    },
                    complete:function(){
                        table.ajax.reload();
                        stopLoading();
                    }
                });
            
          } else {
            swal("Suppression annulée!");stopLoading();
          }
        });   
    }
        function deletefiltArray(id){
        
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
              for(var i=0;i<id.length;i++){
                let url = '/filieres/'+id[i].code;
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
                    },
                    complete:function(){
                        stopLoading();
                        table.ajax.reload();
                    }
                });
              }
              if(j==i) 
                swal("Filière supprimés!", {icon: "success",});
              else
                toastr["error"]("Something went wrong!");
          } else {
            swal("Suppression annulée!");stopLoading();
          }
        });   
    }
</script>

@include('includes.footer')