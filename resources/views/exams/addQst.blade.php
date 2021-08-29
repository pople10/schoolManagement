@include("includes.head")
<div class="bootstrap">
    <div class="card examsWidth mx-auto" style="margin-top:50px;margin-bottom:20px;">
        <div class="card-header">Questions pour examen {{ $exam }}</div>
        <div class="row mx-auto mt-3">
            Nombre des questions : <input class="form-control" style="width:100px;" type="number" step="1" min="0" id="nbr">
        </div>
        <div class="p-3">
            <div id="wrapper" class="mt-2">
                
            </div>
            <div id="buttonsSection" class="row mt-4 hidden">
                <div class="ui buttons mx-auto"> 
                    <button class="ui button positive" id="submit" type="submit" op="add">Ajouter</button> 
                    <div class="or" data-text="ou"></div> 
                    <button id="cancel" class="ui button red">Annuler</button> 
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{URL::asset('resources/js/addExam.js')}}"></script>
<script src="{{URL::asset('resources/js/global.js')}}"></script>
</body>
</html>