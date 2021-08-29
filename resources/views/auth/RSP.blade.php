@extends('layouts.app')

@section('content')
<div class="container________RSP">
    <div class="container________RSP__elem">
        <form  method="POST" action="{{ route('RS2') }}"  enctype="multipart/form-data">
            @csrf
            <div class="img___pt">
                <input type="file" name="img" id="file__img___pt" onchange="Onchangeppimh(this)" accept="image/*" />
                <div class="up___img__lb">
                    <img src="{{URL::asset('/resources/images/Upload.svg')}}" id="img____photo__profil"/>
                </div>
               
            </div>
             
            @error('img')
                <span class="invalid-feedback" role="alert" style=" display: flex; align-self: center; width: 100%; align-items: center; justify-content: center; " >
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="l____elem___type02">
                @if($isstudent)
                    <div class="l____elem">
                        <span >CNE</span>
                        <input id="CNE" type="text" class="form-control @error('CNE') is-invalid @enderror" name="CNE" value="{{ old('CNE') }}" required  autofocus>
                        @error('CNE')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="l____elem">
                        <span >Level</span>
                        <select name="Level" id="r___rp_select">
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
                    <span >Adress</span>
                    <!---->
                    <textarea name="Adress" cols="30" rows="10"@if(!$isstudent) class="txt____ar___forstd" @endif  value="{{ old('Adress') }}"></textarea>
                    @error('Adress')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
                <div class="l____elem___type01">
                    <div class="l____elem">
                        <span >Telephone</span>
                        <input id="Telephone" type="text" class="form-control @error('Telephone') is-invalid @enderror" name="Telephone" value="{{ old('Telephone') }}" required  autofocus>
                        @error('Telephone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="l____elem">
                        <span >Sexe</span>
                        <select name="Sexe" id="r___rp_select">
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
                        <span >Doctorat subject</span>
                        <input id="subject" type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{ old('subject') }}" autofocus>
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
                             <span >Bac Type</span>
                             <input id="Bac_Type" type="text" class="form-control @error('Bac_Type') is-invalid @enderror" name="Bac_Type" value="{{ old('Bac_Type') }}" required  autofocus>
                             @error('Bac_Type')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                             @enderror
                         </div>
                         <div class="l____elem">
                             <span >Bac Mark</span>
                             <input id="Bac_Mark" type="text" class="form-control @error('Bac_Mark') is-invalid @enderror" name="Bac_Mark" value="{{ old('Bac_Mark') }}" required  autofocus>
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
                 <div class="l____elem___type02">
                         <div class="l____elem">
                             <span >start</span>
                             <input id="date_start" type="datetime-local"   class="form-control @error('Bac_Type') is-invalid @enderror" name="date_start" value="{{ old('date_start') }}"   autofocus>
                             @error('date_start')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                             @enderror
                         </div>
                         <div class="l____elem">
                             <span >end </span>
                             <input id="date_end" type="datetime-local"  value=""  class="form-control @error('Bac_Mark') is-invalid @enderror" name="date_end" value="{{ old('date_end') }}"   autofocus>
                             @error('date_end')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                             @enderror
                          </div>
                        </div>
                    <div>
                @endif
            <div >
                <button  class="bttn" type="submit"  id="submit">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
<script >
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
</script>
@endsection
