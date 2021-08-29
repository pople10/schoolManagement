<?php
    function jsonToQst($json)
    {
        $json=str_replace("{","",$json);
        $json=str_replace("}","",$json);
        $json=str_replace(",","\n",$json);
        return $json;
    }
?>
@include("includes.head")
<div class="bootstrap">
    <div class="card examsWidth mx-auto" style="margin-top:50px;margin-bottom:20px;">
        <div class="card-header">Modification du questions pour examen {{ $merged->exam }}</div>
        <div class="row mx-auto mt-3">
            Nombre des questions : <input class="form-control" style="width:100px;" value="{{count($merged->qst)}}" type="number" step="1" min="0" id="nbr">
        </div>
        <div class="p-3">
            <div id="wrapper" class="mt-2">
                @for($i=0;$i<count($merged->qst);$i++)
                <hr> 
                <h3>Question {{$i+1}} : </h3> 
                <div class="row mb-4"> 
                    <div class="col-md-3"> 
                        <label for="qst-{{$i+1}}">Question</label> 
                    </div> 
                    <div class="col-md-9 mt-2"> 
                        <input class="form-control" type="text" value="{{$merged->qst[$i]->qst}}" id="qst-{{$i+1}}"/> 
                    </div> 
                    <div class="col-md-3 mt-2"> 
                        <label for="tmp-{{$i+1}}">Duré en seconds</label> 
                    </div> 
                    <div class="col-md-2 mt-2"> 
                        <input class="form-control" type="number" value="{{$merged->qst[$i]->time}}" step="1" min="0" id="tmp-{{$i+1}}"/> 
                    </div> 
                    <div class="col-lg-12 mr-3 ml-3">
                        <small>Pour les réponses sous forme "val0":"V" ou "val1":"F" dans chaque ligne</small>
                    </div> 
                    <div class="col-lg-12"> 
                        <center><textarea class="examsWidthTextarea" id="rsp-{{$i+1}}">{{jsonToQst($merged->qst[$i]->data)}}</textarea></center> 
                    </div> 
                </div>
                @endfor
            </div>
            <div id="buttonsSection" class="row mt-4">
                <div class="ui buttons mx-auto"> 
                    <button class="ui button positive" id="submit" type="submit" op="add">Modifier</button> 
                    <div class="or" data-text="ou"></div> 
                    <button id="cancel" class="ui button red">Annuler</button> 
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function treatInt__d(value)
{
    return isIntgerChecker(value) && (parseInt(value)>0);
}
function errorTreat(response)
{
    if( response.status === 422 ) { var errors = $.parseJSON(response.responseText); $.each(errors, function (key, value) { swal("Error!", value, "error"); } ); } else{ swal("Error!", "Something went wrong!", "error"); }
}
$(document).ready(()=>{
                $("#cancel").click(function(){$("#nbr").val("0").focus().blur();});
                $("#submit").click(function(){
                    var data=[];
                    var response = true;
                    for(let i=1;i<=parseInt({{count($merged->qst)}});i++)
                    {
                        let temp = $("#rsp-"+i).val();
                        temp=temp.replaceAll("\n",",");
                        temp="{"+temp+"}";
                        var qst = $("#qst-"+i).val();
                        var tmp = $("#tmp-"+i).val();
                        try{
                            data.push({qst:qst,tmp:tmp,r:temp});
                            var json = JSON.parse(temp);
                            if(qst==""||tmp==""||qst==null|tmp==null)
                            {
                                toastr["error"]("Veuillez remplir tous les champs de la question "+i);
                                response = false;
                            }
                            if(!treatInt__d(tmp))
                            {
                                toastr["error"]("Veuillez remplir temps entier superieurs à 0 pour la question "+i);
                                response = false;
                            }
                        }
                        catch(e)
                        {
                            response = false;
                        }
                    }
                    if(response)
                    {
                        $.ajax({
                            url:"/api/prof/exam/{{ $merged->exam }}",
                            type:"POST",
                            data:{data:data},
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            beforeSend:function(){$("#submit").addClass("loading").attr("disabled");},
                            success:function(d)
                            {
                                swal("Succès!", "Ajoutée avec succès!", "success");
                            },
                            error:function(xhr)
                            {
                                errorTreat(xhr);
                            },
                            complete:function(){$("#submit").removeAttr("disabled").removeClass("loading");}
                        });
                    }
                });
    $("#nbr").blur(function(){
        var value = $(this).val();
        if(!isIntgerChecker(value))
        {
            $("#buttonsSection").addClass("hidden");
            $(this).val("0");
            $("#wrapper").html("");
        }
        else if(parseInt(value)<=0)
        {
            $("#buttonsSection").addClass("hidden");
            $(this).val("0");
            $("#wrapper").html("");
        }
        else
        {
            $("#buttonsSection").removeClass("hidden");
            $("#wrapper").html("");
            for(let i=1;i<=parseInt(value);i++)
            {
                var s='<hr> <h3>Question **id** : </h3> <div class="row mb-4"> <div class="col-md-3"> <label for="qst-**id**">Question</label> </div> <div class="col-md-9 mt-2"> <input class="form-control" type="text" id="qst-**id**"/> </div> <div class="col-md-3 mt-2"> <label for="tmp-**id**">Duré en seconds</label> </div> <div class="col-md-2 mt-2"> <input class="form-control" type="number" step="1" min="0" id="tmp-**id**"/> </div> <div class="col-lg-12 mr-3 ml-3"><small>Pour les réponses sous forme "val0":"V" ou "val1":"F" dans chaque ligne</small></div> <div class="col-lg-12"> <center><textarea class="examsWidthTextarea" id="rsp-**id**"></textarea></center> </div> </div>';
                s=s.replaceAll("**id**",i);
                $("#wrapper").append(s);
            }
                $("#cancel").click(function(){$("#nbr").val("0").focus().blur();});
                $("#submit").click(function(){
                    var data=[];
                    var response = true;
                    for(let i=1;i<=parseInt(value);i++)
                    {
                        let temp = $("#rsp-"+i).val();
                        temp=temp.replaceAll("\n",",");
                        temp="{"+temp+"}";
                        var qst = $("#qst-"+i).val();
                        var tmp = $("#tmp-"+i).val();
                        try{
                            data.push({qst:qst,tmp:tmp,r:temp});
                            var json = JSON.parse(temp);
                            if(qst==""||tmp==""||qst==null|tmp==null)
                            {
                                toastr["error"]("Veuillez remplir tous les champs de la question "+i);
                                response = false;
                            }
                            if(!treatInt__d(tmp))
                            {
                                toastr["error"]("Veuillez remplir temps entier superieurs à 0 pour la question "+i);
                                response = false;
                            }
                        }
                        catch(e)
                        {
                            response = false;
                        }
                    }
                    if(response)
                    {
                        $.ajax({
                            url:"/api/prof/exam/{{ $merged->exam }}",
                            type:"POST",
                            data:{data:data},
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            beforeSend:function(){$("#submit").addClass("loading").attr("disabled");},
                            success:function(d)
                            {
                                swal("Succès!", "Ajoutée avec succès!", "success");
                            },
                            error:function(xhr)
                            {
                                errorTreat(xhr);
                            },
                            complete:function(){$("#submit").removeAttr("disabled").removeClass("loading");}
                        });
                    }
                });
        }
    });
});
</script>
<!--<script src="{{URL::asset('resources/js/addExam.js')}}"></script>-->
<script src="{{URL::asset('resources/js/global.js')}}"></script>
</body>
</html>