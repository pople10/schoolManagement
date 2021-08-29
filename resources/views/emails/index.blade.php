@include("includes.head")
<div class="bootstrap">
    @if(count($data)==0)
    <div class="card w-75 mx-auto mt-4" id="addAcc">
        <div class="m-4">
            <center><h3 class="m-3">Create an account</h3></center>
            <div class="row mb-4">
                <div class="col-xl-3">
                    <label for="user">Nom d'utilisateur</label>
                </div>
                <div class="col-xl-3">
                    <input type="text" class="form-control" id="user"/> 
                </div>
                <div class="col-xl-3">
                    <label for="user">Mot de passe</label>
                </div>
                <div class="col-xl-3">
                    <input type="password" class="form-control" id="pass"/> 
                </div>
            </div>
            <div class="row mt-4">
                <button class="ui button primary mx-auto" id="submitAcc">Ajouter</button>
            </div>
        </div>
    </div>
    @endif
    <div class="card w-75 mx-auto mt-4">
        <div class="m-4">
            <center><h3 class="m-3">Envoyer un email</h3></center>
            <div class="row mb-4">
                <div class="col-xl-3">
                    <label for="user">Choisit une promo</label>
                </div>
                <div class="col-xl-9">
                    <select id="promos" class="form-control">
                        @foreach($data->levels as $level)
                        <option value="{{$level->id}}">{{$level->label}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-2"></div>
                <div class="col-xl-3">Message : </div>
                <div class="col-xl-12">
                    <center><textarea id="msg" class="textareaWidth"></textarea></center>
                </div>
            </div>
            <div class="row mt-4">
                <button class="ui button positive mx-auto" id="submit">Envoyer</button>
            </div>
        </div>
    </div>
</div>
<script src="{{URL::asset('resources/js/emailing.js')}}"></script>
<script src="{{URL::asset('resources/js/global.js')}}"></script>
</body>
</html>