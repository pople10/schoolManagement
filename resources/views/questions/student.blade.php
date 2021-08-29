@include('includes.head')
@include('includes.menu')
<div class = "bootstrap">
    <div class="w-75 mx-auto p-3 mt-45 mb-10">
        <h2>Questions</h2>
    </div>
<div class="card w-95 mx-auto p-3 mt-2 mb-10">
    <div class="mx-auto">
        <div class="row mb-1 p-1">
            <div class="col-sm-3 inline field">
                <label for="prof">Professeur : </label>
                <div class="ui left pointing green basic label" style="float: none;"> Vous pouvez choisi avec le module aussi! </div>
            </div>
            <div class="col-sm-9">
                <select id="prof"></select>
            </div>
        </div>
        <div class="field">
            <center><textarea id="question" class="textareaWidth"></textarea></center>
        </div>
        <center><button class="ui button positive submit" id="add">Ajouter une question <i class="fas fa-question"></i></button></center>
    </div>
    <hr>
    <div class="ui comments" id="questions" style="max-width:100%;">
    </div>
</div>
<script src="{{URL::asset('resources/js/question_student.js')}}"></script>
@include('includes.footer')