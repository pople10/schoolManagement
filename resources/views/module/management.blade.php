@include('includes.head')
@include('includes.menu')
<div class = "bootstrap">
    <div class="w-75 mx-auto p-3 mt-45 mb-10">
        <h2>Gestion des modules</h2>
    </div>
<div class="card w-95 mx-auto p-3 mt-2 mb-10">
    <button class="ui button positive w-160px"  id="showForm">Ajouter un module</button>
    <button class="ui button negative w-160px hidden" id="hideForm">Annuler</button>
</div>
<div class="card w-95 mx-auto p-3 mt-2 mb-10 hidden" id="formModules">
    <form>
        <div class="row mt-2">
            <div class="col-lg-3">
                <label for="code">Code : </label>
            </div>
            <div class="col-lg-3">
                <input id="code" class="form-control" type="text"/>
            </div>
            <div class="col-lg-3">
                <label for="label">Label : </label>
            </div>
            <div class="col-lg-3">
                <input id="label" class="form-control" type="text"/>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-3">
                <label for="levels">Niveaux : </label>
            </div>
            <div class="col-lg-3">
                <select id="levels"></select>
            </div>
        </div>
        <div class="row mt-4">
            <div class="ui buttons mx-auto">
                <button class="ui positive button" type="submit" id="submit" op="add">Ajouter</button>
                <div class="or" data-attr="ou"></div>
                <button class="ui button red" type="cancel" id="cancel">Annuler</button>
            </div>
        </div>
    </form>
</div>
<div class="card w-95 mx-auto p-3 mt-2 mb-10">
    <table class="table table-striped table-bordered  dataTable no-footer w-100" id="modules">
        <thead class="bg-primary" style="color:white;">
          <tr>
            <th scope="col"></th>
            <th scope="col">Code</th>
            <th scope="col">Niveaux</th>
            <th scope="col">Labelle</th>
          </tr>
        </thead>
    </table>
</div>
</div>
<script src="{{URL::asset('resources/js/management_modules.js')}}?t={{time()}}"></script>
@include('includes.footer')