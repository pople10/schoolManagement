@include('includes.head')
<link href="{{ URL::asset('css/trackiness.css') }}" rel="stylesheet">
        <div class="back-to-home rounded d-sm-block">
            <a href="{{url('/')}}" class="btn btn-icon btn-soft-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home icons"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
        </div>
        <section class="bg-home d-flex align-items-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-6">
                        <div class="mr-lg-5">   
                            <img src="{{URL::asset('resources/images/recovery.svg')}}" class="img-fluid d-block mx-auto" alt="">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="card login_page shadow rounded border-0">
                            <div class="card-body">
                                <h4 class="card-title text-center">Récupération du compte</h4>  
                                    <div class="row">
                                        <form class="bootstrap" method="POST" action="{{route('reset')}}">
                                            @csrf 
                                            <div class="col-lg-12">
                                                <p class="text-muted">Veuillez saisir votre adresse e-mail. Vous recevrez un lien pour créer un nouveau mot de passe par e-mail.</p>
                                                    <?php echo @$message ?>
                                                <div class="form-group position-relative">
                                                    <label>Adresse Email <span class="text-danger">*</span></label>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail fea icon-sm icons"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                                    <input type="text" name="email" class="form-control pl-5" placeholder="Entrer Votre Email" required="">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <button id="resetpass" type="submit" class="btn btn-primary btn-block">Envoyer</button>
                                            </div>
                                            <div class="mx-auto">
                                                <p class="mb-0 mt-3"><small class="text-dark mr-2">Vous avez bien reconnaître votre mot de passe? ?</small> <a href="{{url('/login')}}" class="text-dark font-weight-bold">Se connecter</a></p>
                                            </div>
                                        </form>
                                    </div>
                            </div>
                        </div>
                    </div> <!--end col-->
                </div><!--end row-->
            </div> <!--end container-->
        </section>
<script>
    function loading(){$(".loading-container").fadeOut(300);}
</script>
</body>
</html>
