<form method="POST" class="ui form bordered " id="request-type-form" >
    @csrf
        <h3 class="ui dividing header">Creation d'un élément</h3>
        
    <div class="field">
        <label for="label">Label de demande</label>
        <input type="text" name="label" id="label" required autocomplete="off" value=""  autofocus />
    </div>
  
    
    @php
        
    @endphp
    <div class="field">
        <label for="min_duration">Duration minimale</label>
        <select name="min_duration" id="min-duration">
            <option value="">Sélectionner la durée</option>
            @php
                echo '<option value="1">1 jour</option>';
                for($i=2;$i<31;++$i){
                    echo '<option value="'.$i.'">'. $i .' jours</option>'; 
                }
            @endphp
        </select>
    </div>    
 
    <div class="form-row" >
        <div class="ui buttons mx-auto">
            <button class="ui positive button" type="submit" id="submit">Ajouter</button>
            <div class="or" data-attr="ou"></div>
            <button class="ui button red" type="cancel" id="cancel">Annuler</button>
        </div>
    </div>
 
  </form>




