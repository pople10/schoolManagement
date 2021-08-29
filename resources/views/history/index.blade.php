@include('includes.head')
@include('includes.menu')
<div class = "bootstrap">
    <div class="w-75 mx-auto p-3 mt-45 mb-10">
        <h2>Historique</h2>
    </div>
<div class="card w-95 mx-auto p-3 mt-2 mb-10">
<table class="table table-striped table-bordered  dataTable no-footer w-100" id="history">
    <thead class="bg-primary" style="color:white;">
      <tr>
        <th scope="col">User ID</th>
        <th scope="col">Utilisateur</th>
        <th scope="col">Action</th>
        <th scope="col" >Donnée précédantes</th>
        <th scope="col" >Donnée précédantes</th>
        <th scope="col">Temps</th>
      </tr>
    </thead>
</table>
</div>
</div>
<script src="{{URL::asset('resources/js/history.js')}}"></script>
@include('includes.footer')