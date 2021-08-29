@include('includes.head')
@include('includes.menu')
<div class = "bootstrap">
    <div class="w-75 mx-auto p-3 mt-45 mb-10">
        <h2>Les cours par niveau</h2>
    </div>
    <div class="card m-95-d-50 mx-auto mt-2 mb-10">
        <div class="card-header">
            {{$data->level}}
        </div>
        <div class="card-body p-4">
            @if(!isset($data->modules) or empty($data->modules) or count($data->modules)==0)
                <h4>Il y a pas encore du modules pour le moment, veuillez revenir après.</h4>
            @else
                <table class="ui celled striped table">
                  <tbody>
                    @foreach($data->modules as $val)
                    <tr>
                      <td class="single line"> {{$val->module_name}}</td>
                      <td class="single line" style="width:1%;"><a class="btn btn-success" href="{{url('/cours/archive/module/'.$val->id)}}"><i class="fas fa-book-open"></i> Voir les cours</a></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@include('includes.footer')