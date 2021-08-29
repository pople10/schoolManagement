@include("includes.head")
<div class="bootstrap">
    <div class="card mx-auto p-4">
        <center class="mb-4" style="height: 100px;">
            <h2 class="mt-4">{{ $examen->module }} - {{ $examen->level }}</h2>
        </center>
        <div class="mx-auto mb-4">
            <div class="noteCont <?php if(!$examen->passed) echo "redColor"; else echo "greenColor"?>">
                <span class="note">
                    {{ $examen->mark}}
                </span>
                <span class="noteSlash">
                    /
                </span>
                <span class="noteTotal">
                    {{ $examen->total}}
                </span>
            </div>
        </div>
        <div>
            <div class="badge-exam mx-auto">
                <?php if($examen->passed){?>
                <img style="max-width:100%;max-height:100%;" src="{{URL::asset('resources/images/passed.png')}}">
                <?php }else{?>
                <img style="max-width:100%;max-height:100%;" src="{{URL::asset('resources/images/failed.png')}}">
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script src="{{URL::asset('resources/js/global.js')}}"></script>
</body>
</html>