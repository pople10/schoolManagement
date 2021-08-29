@include('includes.head')
@include('includes.menu')
<div class = "bootstrap">
    <div class="w-75 mx-auto p-3 mt-45 mb-10">
        <h2>Gestion des annonces</h2>
    </div>
<div class="card w-95 mx-auto p-3 mt-2 mb-10">
    <button class="ui positive button mx-auto" id="addNews">Ajouter une annonce</button>
<table class="table table-striped table-bordered  dataTable no-footer" style="width:100%" id="annoncesDatatable">
    <thead class="bg-primary" style="color:white;">
      <tr>
        <th scope="col"></th>
        <th scope="col">#</th>
        <th scope="col" >User ID</th>
        <th scope="col" >Date du création</th>
        <th scope="col" >Dernière modification</th>
        <th scope="col">Titre</th>
        <th scope="col">Type</th>
        <th scope="col" >Role</th>
        <th scope="col" >Contenu</th>
        <th scope="col" >Attachement</th>
      </tr>
    </thead>
</table>
</div>
</div>
<script>
    function downloadAttachement(id){
          let url =  '{{ route("announcement.download", ["attachement"=>"*ss*"]) }}';
          url = url.replace("*ss*", id);
        $(function (event) {
            $.ajax({
                
                    headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          },
                type:"GET",
                url: url,
                beforeSend:function(){
                    $("body").append('<div id="tempLoader" class="loaderCustom"></div>');
                },
                complete:function(){
                    $("#tempLoader").remove();
                    toastr["success"]("Opération terminée!");
                }
            });
        });
      }
      
    function deleteAnnouncement(id){
        let url = '{{ route("announcement.delete", ["announcement"=>"*ss*"]) }}';
        url = url.replace("*ss*", id);
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
                        swal("Annonce supprimée!", {
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
            swal("Suppression annulée!");stopLoading();
          }
        });   
    }
    function deleteAnnouncementArray(id){
        
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
                let url = '{{ route("announcement.delete", ["announcement"=>"*ss*"]) }}';
                url = url.replace("*ss*", id[i].id);
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
                        
                    },
                    complete:function(){
                        stopLoading();
                        table.ajax.reload();
                    }
                });
              }
              if(j==i) 
                swal("Annonces supprimées!", {icon: "success",});
              else
                toastr["error"]("Something went wrong!");
          } else {
            swal("Suppression annulée!");stopLoading();
          }
        });   
    }
                        function showContent(id)
                        {
                            $.ajax({
                                headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                  },
                                url:"/announcement/getContent/"+id,
                                type:"POST",
                                async:false,
                                dataType: 'text',
                                beforeSend:function(){
                                    $("body").append('<div id="tempLoader" class="loaderCustom"></div>');
                                },
                                success:function(data){
                                    swal('Contenu de l\'annonce numero '+id,data);
                                },
                                error:function(){
                                    swal("Error!", "Something went wrong!", "error");
                                },
                                complete:function(){
                                    $("#tempLoader").remove();
                                }
                            });
                        }
                        function calculateAspectRatioFit(srcWidth, srcHeight, maxWidth, maxHeight) {

                            var ratio = Math.min(maxWidth / srcWidth, maxHeight / srcHeight);
                        
                            return { width: srcWidth*ratio, height: srcHeight*ratio };
                         }
        function showPict(path)
        {
            var url =  '{{url("storage/app/***")}}';
            url = url.replace("***", path);
            var dialog = bootbox.dialog({
                title: 'L\'ajout d\'une annonce',
                message: '<div class="ui placeholder"><div class="paragraph"> <div class="line"></div> <div class="line"></div> <div class="line"></div> <div class="line"></div> <div class="line"></div> </div> </div>'
            });
                        
            dialog.init(function(){
                $('.bootbox').wrap('<div class="bootstrap"></div>').addClass("w-dialog mx-auto");
                dialog.find('.bootbox-body').html('<center><div style="height: 500px"><img src="'+url+'" class="w-75 loadingImage showedImage" style="max-width:100%;max-height:100%;"></div><center>');
                /*$(".showedImage").ready(()=>{sizes = calculateAspectRatioFit($(".showedImage").width(),$(".showedImage").height(),1000000,500);
                $(".showedImage").css("width",sizes.width).css("height",sizes.height);});*/
            });
        }
</script>
<script src="{{URL::asset('resources/js/announcement.js')}}?t={{time()}}"></script>
@include('includes.footer')