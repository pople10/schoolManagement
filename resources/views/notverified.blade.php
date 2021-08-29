@include("includes.head")

<style>
    img+h3{
        position: relative;
        top: -31vw;
        left: 13%;
        color:white;
        font-family:  Georgia, 'Times New Roman', Times, serif;
        font-size: 5vw;
    }
    .image{
        width: 60%;
        height: 50%;
        left:10%;
        max-width:50%!important;
    }

    .notverified{
        position: absolute;
        width: 30%;
        height: 60%;
        left: 10%;
        top:5%;
    }
    
    .w-100{
        width: 90vw;
        min-height: 100vh;
        background-color: white;
    }
    
    
    @media(max-width : 750px){
        .notverified{
            width: 80%;
            height: 20%;
            top: 5%;
        }

        .image{
            position: absolute;
            left:0%;
            top: 50px;
        }
        

        img+h3{
            top: -26vw;
            left: 3%;
        }
         
    }



</style>
<link href="{{ URL::asset('css/trackiness.css') }}" rel="stylesheet">
        <div class="back-to-home rounded d-sm-block">
            <a href="{{url('/')}}" class="btn btn-icon btn-soft-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home icons"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
        </div>
<div class="bootstrap">
    <div class=" w-100 mx-auto">
        <center><img class="ui image" src="/resources/images/not-verified.svg" alt="not-verified"><h3>X</h3></center>
    
        <div class="notverified">
            <h2 style="font-size:2.5vw;"><span style="color:#E18942;" >Désolé</span>, mais vous n'êtes pas <span style="color:green">vérifié</span> à ce moment, s'il vous plaît contacter l'administration.</h2>
        </div>
    </div>    
</div>




<script src="{{URL::asset('resources/js/global.js')}}?t={{time()}}"></script>
</body>
</html>
