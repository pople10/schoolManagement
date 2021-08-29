@extends('layouts.app')

@section('content')
        <div class="back-to-home rounded d-sm-block">
            <a href="{{url('/')}}" class="btn btn-icon btn-soft-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home icons"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
        </div>
<div class='con____x___lr'>
      <div class="container">
        <div class="img___nvl">
            <img src="{{URL::asset('/resources/images/Logo01blue.svg')}}" alt="" class="lg___nvl">
        </div>
        <form  method="POST" action="{{ route('register') }}"  >
          @csrf
            <div class="first___elmr__cc">
                <div class="fe___elmr">
                    <span >Prénom</span>
                    <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" required autocomplete="fname" autofocus>
                    @error('fname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
                <div class="fe___elmr">
                    <span >Nom</span>
                    <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}" required autocomplete="lname" autofocus>
                    @error('lname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
            </div>
            <div class="first___elmr__cc">
                <div class="fe___elmr">
                    <span >CIN</span>
                    <input id="cne" type="text" class="form-control @error('cne') is-invalid @enderror" name="cne" value="{{ old('cne') }}" required  autofocus>
                    @error('cne')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
                <div class="fe___elmr">
                    <span >Role</span>
                    <select name="role_id" id="r___rp_select">
                        @foreach ($rl as $r)
                            <option value="{{ $r->id }}"  >{{ $r->label }}</option>
                        @endforeach
                    </select>
                    @error('role_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
            </div>

            <span >Email</span>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
            @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror

            <span >Mot de passe</span>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
            @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror


            <span >Mot de passe confirmation</span>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            @error('password-confirm')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
            

              
            <div>
                <button  class="bttn" type="submit"  id="submit">
                    Registrer
                </button>
            </div>
            <p style="margin-top:10px;">Avez-vous un compte? <a href="{{url('/login')}}">Se connecter</a></p>
        </form>
    </div>
</div>
@endsection
