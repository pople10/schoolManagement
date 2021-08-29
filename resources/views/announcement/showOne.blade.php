@include('includes.head')
@include('includes.menu')

<div class = "bootstrap" id="annonces">
    <div class="w-75 mx-auto p-3 mt-45 mb-10">
        <?php if(isset($val->id)) { ?><h2>L'annonce numéro <a class="ui teal tag label">{{ $val->id }}</a></h2><?php } ?>
        <?php if(!isset($val->id)) { ?><h2>Erreur</h2><?php } ?>
    </div>
    <div class="w-90 w-d-75 mx-auto p-3 mt-1 mb-10">
        <div class="ui card w-100"> 
            <div class="content"> 
                <?php if(isset($val)&&!empty($val)&&$val) { ?>
                <div class="header">
                    <a class="ui <?php if($val->type=="resultatConcour") echo "green"; else if($val->type=="concour") echo "red"; else echo "blue"; ?> ribbon label uppercase">
                        <?php if($val->type=="resultatConcour") echo "RÉSULTAT DU CONCOUR"; else echo $val->type; ?>
                    </a> {{$val->title}}</div> 
                    <div class="meta mt-1"> {{$val->time_label}}
                    <a class="ui teal image label"><div class="detail">
                        <i class="fa fa-clock white"></i>
                        </div> {{$val->updated_at}}</a>
                        <div class="publisherAnn"> 
                        Par : <span class="publisher">{{$val->publisher->fname." ".$val->publisher->lname}}</span> 
                            <a class="ui label" href="mailto:{{$val->publisher->email}}">
                            <i class="fa fa-envelope"></i> {{$val->publisher->email}} 
                            </a> 
                        </div>
                    </div> 
                <div class="description separateAnn"> 
                    <div>
                        {{$val->content}}
                    </div> 
                </div>
                <?php } ?>
                <?php if(!isset($val)&&empty($val)&&!$val) { ?>
                <h1>Annonce n'existe pas.</h1>
                <?php } ?>
            </div>
            <?php if(isset($val->fichier)&&!empty($val->fichier)){ ?>
            <div class="extra content">
                <?php if($val->fichier->type=="pdf") { ?>
                <button class="ui button" onclick="DownloadAttachement(20)"> 
                    <i class="fa fa-paperclip" aria-hidden="true"></i> Télécharger
                </button>
                <?php } ?>
                <?php if($val->fichier->type=="image") { ?>
                <center>
                    <div style="max-height:800px;">
                        <img style="max-width:100%;max-height:100%;" src="{{$val->fichier->src}}" />
                    </div>
                </center>
                <?php } ?>
            </div> 
            <?php } ?>
        </div>
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
@include('includes.footer')