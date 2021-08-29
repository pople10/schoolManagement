@include("includes.head")
@include("includes.menu")

@php 
$modules = json_decode($modules);
$i = 1;
@endphp

<div class="bootstrap">
    <h1 class="header w-75 mx-auto" style="margin:50px auto">Les études</h1>
    <div class="card mx-auto w-75 p-10" style="padding:5%;margin-bottom:20px;">
        <h2>Cycle d'ingénieur</h2>
        <ul class="list-group">
        @foreach($modules as $module)
            @if($i%3 == 0)
                <hr>
                <h3 class="header"> {{is_array($module) ? $module[0]->faculty : $module->faculty }} </h3>
            @endif        
            @if(is_array($module) && $module[0]->cycle == "Cycle d'ingénieur")
                
                <div id ="{{$module[0]->level}}" class="item" style="min-height:30px;height:5%; width:100%;margin-top: 10px; margin-bottom:10px">
                    <li class="list-group-item">{{$module[0]->label}}
                       <div style="display:inline-block;position:absolute;right:10px;">
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                                <path d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659l4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z"/>
                            </svg>                            
                       </div>
                         
                    </li>     


                </div>
                <ul style="display:none">
                    @foreach($module as $mod)
                        <li>-{{$mod->module}}</li>
                    @endforeach
                </ul>

                
                
            @elseif(!is_array($module) && $module->cycle == "Cycle d'ingénieur")
                <div class="item" style="min-height:30px;height:5%; width:100%;margin-top: 10px; margin-bottom:10px">
                    <li class="list-group-item">{{$module->level}}
                       <div style="display:inline-block;position:absolute;right:10px;">
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                                <path d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659l4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z"/>
                            </svg>                            
                       </div>
                    </li>
                </div>
            @endif
            

            
        @php $i++;  @endphp
        @endforeach
        </ul>
        
        <h2>Cycle préparatoire</h2>
        <ul class="list-group">
        @foreach($modules as $module)
            @if($i%3 == 0 && $i!=0 && $i<6)
                <hr>
                <h3 class="header"> {{is_array($module) ? $module[0]->level : $module->level }} </h3>
            @endif        
            @if(is_array($module) && $module[0]->cycle == "Cycle préparatoire")
                
                <div id ="{{$module[0]->level}}" class="item" style="min-height:30px;height:5%; width:100%;margin-top: 10px; margin-bottom:10px">
                    <li class="list-group-item">{{$module[0]->label}}    
                       <div style="display:inline-block;position:absolute;right:10px;">
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                                <path d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659l4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z"/>
                            </svg>                            
                       </div>
                    </li> 
                </div>
                <ul style="display:none">
                    @foreach($module as $mod)
                        <li>-{{$mod->module}}</li>
                    @endforeach
                </ul>

                
                
            @elseif(!is_array($module) && $module->cycle == "Cycle préparatoire")
                <div class="item" style="min-height:30px;height:5%; width:100%margin-top: 10px; margin-bottom:10px">
                    <li class="list-group-item">{{$module->level}}
                       <div style="display:inline-block;position:absolute;right:10px;">
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                                <path d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659l4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z"/>
                            </svg>                            
                       </div>    
                    </li>   
                </div>
            @endif
            

            
        @php $i++;  @endphp
        @endforeach
        </ul>
        
    </div>
    
</div>



@php
/*
echo "<h2>Cycle préparatoire</h2>";


foreach($modules as $module){

    if(is_array($module) && $module[0]->cycle == "Cycle préparatoire"){
        echo '<h4>'.$module[0]->level.'</h4>';
        echo '<ul>';
        foreach($module as $key => $mod){
                echo '<li>-'. $mod->module .'</li>';
        }
        echo '</ul>';
    }
}

*/
@endphp
<script>
    $(function(){
        $('.item').hover(function(){
            $(this).css({'box-shadow': '0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)'});
            var id = $(this).attr("id");
            $('#'+id + '+ul').slideDown(500);
            console.log(id);
        }, function(){
             $(this).css({'box-shadow': ''});
             id = $(this).attr("id");
             $('#'+id + '+ul').slideUp(200);
        });    
    });
</script>


@include("includes.footer")