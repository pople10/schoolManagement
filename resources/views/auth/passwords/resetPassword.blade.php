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
                            <img src="{{URL::asset('resources/images/login.svg')}}" class="img-fluid d-block mx-auto" alt="">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="card login-page bg-white shadow rounded border-0">
                            <div class="card-body">
                                <h4 class="card-title text-center">Mise à jour du mot de passe</h4> 
                                <form action="{{url()->current()}}" method="POST">
                                    @csrf
                                    <div class="row">
                                            <div class="col-lg-12">
                                                <?php echo @$user->message ?>
                                                <div class="form-group position-relative">
                                                    <label>Mot de passe <span class="text-danger">*</span></label>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-key fea icon-sm icons"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>
                                                    <input hidden name="user_id" type="text" value="{{$user->id}}">
                                                    <input type="password" name="newpass" class="form-control pl-5" placeholder="Nouveau mot de passe" required="">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-0 bootstrap">
                                                <button type="submit" id="resetpass" class="btn btn-success btn-block">Changer</button>
                                            </div>
                                    </div>
                                </form>
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
