@include("includes.head")
@include("includes.menu")

<div class="bootstrap">        
    <div class="ui card w-95 h-100 mx-auto" style='margin-top:80px;margin-bottom:20px;overflow:false;border: 1px solid white ' >
        <div class="content">
            <div class="header">
                <center>
                <h1>Départements</h1>
                <hr>
                </center>
            </div>
            <div class="ui internally celled grid">
            @foreach($faculty as $val)
              <div class="row">
                <div class="three wide column">
                  <img class="image small mx-auto" src="{{$val->logo_url}}">
                </div>
                <div class="ten wide column" style="min-height:300px">
                  <center><h2 class="header">{{$val->label}}</h2></center>
                  <p>{{$val->description}}</p>
                </div>
                <div class="three wide column">
                  @php
                    $png = explode('.', $val->logo_url);
                  @endphp
                  <img class="image small mx-auto" src = "{{$png[0] . '.png'}}">
                </div>
              </div>
            @endforeach  
              <div class="row">
                <div class="three wide column">
                  <img>
                </div>
                <div class="ten wide column">
                  <p></p>
                </div>
                <div class="three wide column">
                  <img>
                </div>
              </div>
            </div>

            
        </div>
    </div>
</div>
    
<script>

</script>

@include("includes.footer")