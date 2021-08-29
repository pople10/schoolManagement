@include('includes.head')
@include('includes.menu')
<input hidden id="idCours" type="text" value="{{$course->id}}">
<div class = "bootstrap">
    <div class="w-75 mx-auto p-3 mt-45 mb-10">
        <h2>Cours</h2>
    </div>
    <div class="card w-95 mx-auto p-3 mt-2 mb-10">
        <div class="card-body">
            <h2 class="card-title">
                <span class="badge {{$course->school_year_color}}">{{$course->school_year_badge}}</span>
                <div class="courseTitle">{{$course->description}}</div>
            </h2>
            <h4 class="card-subtitle mb-2 text-muted">{{$course->timelabel}}{{$course->updated_at}}. Par : {{$course->prof_name}}</h4>
                <p class="courseLevel"><i class="fas fa-graduation-cap"></i> Niveau : {{$course->level_name}}</p>
                <p class="courseModule"><i class="fas fa-school"></i> Module : {{$course->module_name}}</p>
                <p class="courseVisit"><i class="fas fa-glasses"></i> Visits : </p>
            <hr>
            <div class="w-75 mx-auto p-1">
                <h4>Support du cours</h4>
            </div>
            <div class="card-text p-4 pdf_viewer">
                <button class="button ui m-2" onclick="downloadPDF({{$course->id}})">Télécharger</button>
                <center><iframe class="h-m-300" id="pdfreader" height="500px" src="http://docs.google.com/viewer?url={{$course->pdf}}&embedded=true" style="border:none;"></iframe></center>
            </div>
            @if($course->video_exist==true) 
            <hr>
            <div class="w-75 mx-auto p-1">
                <h4>Video explicatif</h4>
            </div>
            <div class="card-text p-4 video_viewer">
                <div>
                    <video id="my-video" height="500px" 
                    class="h-m-300 video-js mx-auto vjs-big-play-centered AdvancedExample__Video-sc-1x7qqz9-7 dVCxLk vjs-paused preview-player-dimensions vjs-controls-enabled vjs-workinghover vjs-v7 vjs-user-active vjs-mux" 
                    crossorigin="anonymous" controls preload="auto" data-setup="{}" > <source  src="{{$course->video_url}}" type="video/<?php echo explode(".",$course->video_url)[count(explode(".",$course->video_url))-1]; ?>" /> <p class="vjs-no-js"> Vous devez activer JAVASCRIPt pour regarder la video! </p> 
                    </video>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<script src="{{URL::asset('resources/js/cours_view.js')}}"></script>
@include('includes.footer')