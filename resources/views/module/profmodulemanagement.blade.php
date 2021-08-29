@include('includes.head')
@include('includes.menu')
<div class = "bootstrap">
    <div class="w-75 mx-auto p-3 mt-45 mb-10">
        <h2>Gestion des professeurs selon les modules</h2>
    </div>
    <div class="card w-95 mx-auto p-3 mt-2 mb-10">
        <table class="table table-striped table-bordered  dataTable no-footer w-100" id="modules">
            <thead class="bg-primary" style="color:white;">
              <tr>
                <th scope="col"></th>
                <th scope="col">#</th>
                <th scope="col">Labelle du module</th>
                <th scope="col">Niveau</th>
                <th scope="col">Professeur</th>
              </tr>
            </thead>
        </table>
    </div>
</div>
<script src="{{URL::asset('resources/js/management_modules_prof.js')}}?t={{time()}}"></script>
@include('includes.footer')