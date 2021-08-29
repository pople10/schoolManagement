@include('includes.head')
@include('includes.menu')

<div class = "bootstrap">
    <div class="w-75 mx-auto p-3 mt-45 mb-10">
        <h2>Les cours par module et niveau</h2>
    </div>
    <div class="card w-95 mx-auto mt-2 mb-10">
        <div class="card-header">
            @if(!isset($courses) and isset($temp))
            {{$temp->level_name}} - {{$temp->module_name}}
            @else
                {{$courses[0]->level_name}} - {{$courses[0]->module_name}}
            @endif
        </div>
        <div class="card-body p-4">
            @if(!isset($courses) or empty($courses))
                <h4>Il y a pas encore du cours pour le moment, veuillez revenir après.</h4>
            @else
                <table class="ui celled striped table">
                  <tbody>
                    @foreach($courses as $course)
                    <tr>
                      <td class="single line" style="width:1%;">Professeur {{$course->prof_name}}</td>
                      <td>{{$course->description}}</td>
                      <td class="single line" style="width:1%;"><a target="_blank" class="btn btn-success" href="{{url('/cours/'.$course->id)}}"><i class="fas fa-book-open"></i> Voir le cours</a></td>
                      <td class="single line" style="width:1%;">{{$course->timeLabel}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr><th colspan="4">
                      <div class="ui right floated pagination menu">
                        <a <?php if($courses[0]->prev!="") echo "href='/cours/module/".$courses[0]->prev."'"; ?> class="<?php if($courses[0]->prev=="") echo "disabled"; ?> icon item">
                          <i class="fas fa-arrow-left mr-1"></i>Module précedant
                        </a>
                        <a <?php if($courses[0]->next!="") echo "href='/cours/module/".$courses[0]->next."'"; ?> class="<?php if($courses[0]->next=="") echo "disabled" ?> icon item">
                          Module suivant<i class="fas fa-arrow-right ml-1"></i>
                        </a>
                      </div>
                    </th>
                    </tr>
                  </tfoot>
                </table>
            @endif
        </div>
    </div>
</div>
@include('includes.footer')