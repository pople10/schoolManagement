@include('includes.head')
@include('includes.menu')

<div class = "bootstrap" id="annonces">
    <div class="w-75 mx-auto p-3 mt-45 mb-10">
        <h2>Les annonces</h2>
    </div>
</div>
<script>
    function DownloadAttachement(id){
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
                }
            });
        });
      }
</script>
<script src="{{ URL::asset('resources/js/annonces.js')}}?t={{time()}}"></script>
@include('includes.footer')