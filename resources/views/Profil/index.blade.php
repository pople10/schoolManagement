@extends('layouts.app')

@section('content')
    <div class="back-to-home rounded d-sm-block">
            <a href="{{url('/')}}" class="btn btn-icon btn-soft-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home icons"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
        </div>
<div class="container________RSP">
    <div class="container________RSP__elem">
            @csrf
            <div class="img___pt">
                <input type="file" name="img" id="file__img___pt" onchange="{Onchangeppimh(this);sb__t();}" accept="image/*" disabled="true"/>
                <div class="up___img__lb">
                    <img src="{{ $userId->photo_path }}" id="img____photo__profil" style=" width: 100%; margin: 0; "/>
                </div>
            </div>
            <div class="l____elem___type02">
                <div class="l____elem">
                    <span >First name</span>
                    <input onkeydown="sb__t()" onkeyup="sb__t()"  id="fname" type="text"  disabled="true" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ $userId->fname }}"   autofocus>
                    @error('fname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
                <div class="l____elem">
                    <span >Last name </span>
                    <input  onkeydown="sb__t()" onkeyup="sb__t()"  id="lname" type="text"disabled="true"  class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ $userId->lname  }}"   autofocus>
                    @error('lname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                 </div>
               </div>
           <div>
            <div class="l____elem___type02">
                @if($isstudent)
                    <div class="l____elem">
                        <span >CNE</span>
                        <input onkeydown="sb__t()" onkeyup="sb__t()" id="CNE" type="text" disabled="true" class="form-control @error('CNE') is-invalid @enderror" name="CNE" value="{{ $userId->cne }}" required  autofocus>
                        @error('CNE')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="l____elem">
                        <span >Level</span>
                        <select name="Level" id="r___rp_select" disabled="true" style="color:#000;opacity: 1;">
                            @foreach ($lev as $r)
                                <option value="{{ $r->id }}"  >{{ $r->label }}</option>
                            @endforeach
                        </select>
                        @error('Level')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                @endif
            </div>
            <div class="first___l__sp">
                <div class="l____elem">
                    <span >Adresse</span>
                    <!---->
                    <textarea onkeydown="sb__t()" onkeyup="sb__t()" disabled="true"  cols="30" rows="10" @if(!$isstudent) class="txt____ar___forstd" @endif style="color:#000;opacity: 1;background:#fff;" id="tx___area"  name="Adress">{{ $userId->adress }} </textarea>
                    @error('Adress')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
                <div class="l____elem___type01">
                    <div class="l____elem">
                        <span >Telephone</span>
                        <input onkeydown="sb__t()" onkeyup="sb__t()" id="Telephone" disabled="true" type="text" class="form-control @error('Telephone') is-invalid @enderror" name="Telephone" value="{{ $userId->telephone }}" required  autofocus>
                        @error('Telephone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="l____elem">
                        <span >Sexe</span>
                        <select name="Sexe" disabled="true" id="r___rp_select" value="{{ $userId->sexe }}" style="color:#000;opacity: 1;">
                            <option value="M"  >Male</option> 
                            <option value="F"  >Female</option>
                        </select>
                        @error('Sexe')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <!---->
                    @if(!$isstudent)
                    <div class="l____elem">
                        <span >Sujet du Doctorat</span>
                        <input onkeydown="sb__t()" onkeyup="sb__t()" name="subject"  disabled="true"  id="subject" type="text" class="form-control @error('subject') is-invalid @enderror" value="{{ $phdd->subject }}" autofocus>
                        @error('subject')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    @endif
                </div>
            </div>

                @if($isstudent)
                 <div class="l____elem___type02">
                         <div class="l____elem">
                             <span >Type du Bac</span>
                             <input onkeydown="sb__t()" onkeyup="sb__t()" disabled="true" id="Bac_Type" type="text" class="form-control @error('Bac_Type') is-invalid @enderror" name="Bac_Type" value="{{ old('Bac_Type') }}" required  autofocus>
                             @error('Bac_Type')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                             @enderror
                         </div>
                         <div class="l____elem">
                             <span >Note du Bac</span>
                             <input onkeydown="sb__t()" onkeyup="sb__t()" disabled="true" id="Bac_Mark" type="text" class="form-control @error('Bac_Mark') is-invalid @enderror" name="Bac_Mark" value="{{ old('Bac_Mark') }}" required  autofocus>
                             @error('Bac_Mark')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                             @enderror
                          </div>
                        </div>
                    <div >
                @endif
                <!---->
                @if(!$isstudent)
                 <div class="l____elem___type02" onchange="">
                         <div class="l____elem">
                             <span >start</span>
                             <input  disabled="true" id="date_start" type="datetime-local"   class="form-control @error('Bac_Type') is-invalid @enderror" name="date_start" value="{{ $phdd->date_start."T00:00" }}"   autofocus>
                             @error('date_start')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                             @enderror
                         </div>
                         <div class="l____elem">
                             <span >end </span>
                             <input  disabled="true" id="date_end" type="datetime-local"  value=""  class="form-control @error('Bac_Mark') is-invalid @enderror" name="date_end" value="{{ $phdd->date_end."T00:00"  }}"   autofocus>
                             @error('date_end')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                             @enderror
                          </div>
                        </div>
                    <div>
                @endif
            <div class="di____ed">
                <button  class="bttn" type="submit"  id="edit" onclick="editpr()">
                    Edit
                </button>
            </div>
            <div class="di____svandcl" id="sv____pf_c" >
                <button id="sv____pf" class="bttn" type="submit"  id="edit" onclick="cancel_p()" style=" background: transparent; color: #2e30b1; margin-right: 20px; ">
                    Cancel
                </button>
                <button  id="sv____pfc" class="bttn" type="submit"  id="edit" onclick="send_data()"  disabled="true" style="background:#2e30b1ab;border-color:#2e30b100;">
                    Save
                </button>
               
            </div>
    </div>
</div>
<script >
    const editpr=()=>{
        var cc=document.getElementsByClassName('container________RSP__elem')[0];
        var ccc=document.getElementsByClassName('container________RSP')[0];
        ccc.setAttribute("style","max-height:"+cc.offsetHeight+"px;overflow:hidden;");
        cc.setAttribute("style","animation-name: pf__cc__an; animation-duration: 1.5s;  ");
        setTimeout(() => {
            var x=document.getElementsByTagName('input');
            for(let i=0;i<x.length;i++){
                x[i].disabled=false;
            }
                        document.getElementById('CNE').disabled=true;
           if(document.getElementById('CNE')!=null) document.getElementById('CNE').disabled=true;
           if(document.getElementById('Bac_Mark')!=null) document.getElementById('Bac_Mark').disabled=true;
           if(document.getElementById('Bac_Type')!=null) document.getElementById('Bac_Type').disabled=true;

            document.getElementById('tx___area').disabled=false;
            var y=document.getElementsByTagName('select');
            
            document.getElementById('sv____pf_c').style.display="flex";
            document.getElementById('edit').style.display="none";

        }, 750);
        setTimeout(() => {
            cc.removeAttribute("style");
            ccc.removeAttribute("style");
        }, 1400);
        
    }
    const cancel_p=()=>{
        var cc=document.getElementsByClassName('container________RSP__elem')[0];
        var ccc=document.getElementsByClassName('container________RSP')[0];
        ccc.setAttribute("style","max-height:"+cc.offsetHeight+"px;overflow:hidden;");
        cc.setAttribute("style","animation-name: pf__cc__an1; animation-duration: 1.5s;  ");
        setTimeout(() => {
            var x=document.getElementsByTagName('input');
            for(let i=0;i<x.length;i++){
                x[i].disabled=true;
            }
            document.getElementById('tx___area').disabled=true;
            var y=document.getElementsByTagName('select');
         
            document.getElementById('sv____pf_c').style.display="none";
            document.getElementById('edit').style.display="block";

        }, 750);
        setTimeout(() => {
            cc.removeAttribute("style");
            ccc.removeAttribute("style");
        }, 1400);
    }
    const send_data=()=>{
        var sve=document.getElementById('sv____pfc');
        sve.disabled=true;sve.style.background='#2e30b1ab';sve.style.borderColor="#2e30b100";
        const dataform=new FormData();
        var txtar=document.getElementsByName('Adress')[0];
        dataform.append('Adress',txtar.value);
        var inp=document.getElementsByTagName("input");
        for(let i=1;i<inp.length;i++){
            dataform.append(inp[i].name,inp[i].value);
        }
        dataform.append('img',inp[1].files[0]);
           
        const token=document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch('/profil/edit', {
    method: 'POST',
    headers: {
        "X-Requested-With": "XMLHttpRequest","X-CSRF-TOKEN":token
    },
    body: dataform
  }).then(function(res){ return res.json();}).then(function(json) {if(json)cancel_p(); console.log(json)})
    .catch((error) => {
  alert(error);
});

    }

    const Onchangeppimh=(e)=>{
    var t=e.target || window.event.srcElement;
    var fi=t.files;
    if (FileReader && fi && fi.length){
    var f=new FileReader();
    f.onload=(a)=>{
        document.getElementById('img____photo__profil').setAttribute('src',a.target.result);
        document.getElementById('img____photo__profil').style.width="100%";
        document.getElementById('img____photo__profil').style.marginTop="0";
      
    }
    f.readAsDataURL(fi[0]);
    }

  }

  const sb__t=()=>{
      var sve=document.getElementById('sv____pfc');
      var fn=document.getElementById('fname');var ln=document.getElementById('lname');var ad=document.getElementsByName('Adress')[0];var tel=document.getElementById('Telephone');
    if(fn.value.length>2 && ln.value.length>2&&ad.value.length>0&&tel.value.length>9)
    {sve.disabled=false;sve.style.background='#2e30b1e3';sve.style.borderColor="#2e30b1e3"}
    else
    {sve.disabled=true;sve.style.background='#2e30b1ab';sve.style.borderColor="#2e30b100"}

}
    var mark_value = document.getElementById("Bac_Mark");
    mark_value.onchange = function(){
        if(parseInt(mark_value.value)>20)
            mark_value.value=20;
        else if(parseInt(mark_value.value)<0)
            mark_value.value=0;
    };
</script>
@endsection
