@extends('layouts.app')

@section('content')
        <div class="back-to-home rounded d-sm-block">
            <a href="{{url('/')}}" class="btn btn-icon btn-soft-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home icons"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
        </div>
<div class='con____x___lr'>
      <div class="container cc___login">
        <div class="img___nvl">
            <img src="{{URL::asset('/resources/images/Logo01blue.svg')}}" alt="" class="lg___nvl">
        </div>
        <form  method="POST" action="{{ route('login') }}" style="width: 100%;" >
          @csrf

            <span class="lg_____sp__lb">Email</span>
            <input    id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
            @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror

            <span class="lg_____sp__lb">Mot de passe</span>
            <input  id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
            @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
            <p>Avez-vous oublié votre mot de passe? <a href="{{url('/forget')}}">Réinitialiser</a></p>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <span class="nv____sp" >
                     Se souvenir de moi 
                </label>
            </div>
            <div>
                <button  class="bttn" type="submit"  id="submit">
                    Se connecter
                </button>
            </div>
            <p style="margin-top:10px;">Avez-vous pas un compte? <a href="{{url('/register')}}">Registre maintenenant</a></p>
        </form>
    </div>
</div>
@endsection
