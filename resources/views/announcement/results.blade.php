@include('includes.head')
@include('includes.menu')

<div class = "bootstrap" id="resultsConcours">
    <div class="w-90 mx-auto p-3 mt-45 mb-10">
        <h2 class="mobile-smaller-font">Les résultats des concours</h2>
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
<script src="{{ URL::asset('resources/js/resultsConcours.js')}}?t={{time()}}"></script>
@include('includes.footer')