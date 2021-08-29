@include('includes.head')
@include('includes.menu')
<div class = "bootstrap">
    <div class="w-75 mx-auto p-3 mt-45 mb-10">
        <h2>Gestion des cours</h2>
    </div>
<div class="card w-95 mx-auto p-3 mt-2 mb-10">
    <button class="ui button positive w-160px"  id="showForm">Ajouter un cours</button>
    <button class="ui button negative w-160px hidden" id="hideForm">Annuler</button>
</div>
<div class="card w-95 mx-auto p-3 mt-2 mb-10 hidden" id="formCourses">
    <form id="formSubmit" method="POST" enctype="multipart/form-data">
        <div class="row mt-2">
            <div class="col-lg-4">
                <label for="code">Description ou titre : </label>
            </div>
            <div class="col-lg-6">
                <input id="description" name="description" class="form-control" type="text"/>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-4">
                <label for="module">Modules : </label>
            </div>
            <div class="col-lg-6">
                <select id="module" name="module"></select>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-10">
                <label class="ui primary button" for="pdf">
                    <i class="fas fa-file-pdf"></i> Uploader un fichier PDF
                </label>
                <p id="uploaded">Il y a pas encore un fichier sélectionner</p> 
                <input type="file" id="pdf" name="pdf_path" accept=".pdf" hidden/>
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
    <table class="table table-striped table-bordered  dataTable no-footer w-100" id="courses">
        <thead class="bg-primary" style="color:white;">
          <tr>
            <th scope="col"></th>
            <th scope="col">#</th>
            <th scope="col">Niveau</th>
            <th scope="col">Module</th>
            <th scope="col">Description</th>
            <th scope="col">Année scholaire</th>
            <th scope="col">Ficher PDF</th>
            <th scope="col">Video</th>
            <th scope="col">Date du creation</th>
            <th scope="col">Date du modification</th>
          </tr>
        </thead>
    </table>
</div>
</div>
<script src="{{URL::asset('resources/js/uploadFunct.js')}}?t={{time()}}"></script>
<script src="{{URL::asset('resources/js/course_management.js')}}?t={{time()}}"></script>
    <script type="text/html" id="files-template">
      <li class="media">
        <div class="media-body mb-1">
          <p class="mb-2">
            <strong>%%filename%%</strong> - Status: <span class="text-muted">Waiting</span>
          </p>
          <div class="progress mb-2">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
              role="progressbar"
              style="width: 0%" 
              aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            </div>
          </div>
          <hr class="mt-1 mb-1" />
        </div>
      </li>
    </script>
@include('includes.footer')