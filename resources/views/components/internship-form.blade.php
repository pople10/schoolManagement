<form method="POST" class="ui form bordered " id="internship-form{{ $action }}" >
    @csrf
    @if ($action == "-edit")
        <h3 class="ui dividing header">Modification d'élément</h3>
    @else
        <h3 class="ui dividing header">Creation d'un élément</h3>
    @endif
    <div class="field">
        <label for="etudiant">CNE</label>
        <input type="text" name="assigned_to" id="etudiant" required autocomplete="off" value="{{ $cne }}"  autofocus />
    </div>
  
    <div class="field">
        <label for="type">Type de stage</label>
        <select name="type" id="type" data-atr="{{$type}}">
            <option value="Normal">Normal</option>
            <option value="PFA">PFA</option>
            <option value="PFE">PFE</option>
        </select>
    </div>
  
  
    <div class="field">
        <label for="prof">Professeur responsable</label>
        <select name="assigned_by" data-atr="{{$addedBy}}" id="prof">
            <option value="">Selectionner prof</option>
            {{-- add assigned_by values here --}}
  
        </select>
    </div>
  
  
    <div class="ui form">
        <div class="field">
            <label for="promo">Promotion</label>
            <select name="level" id="promo" data-atr="{{$promo}}">
                <option value="">Selectionner Promo</option>
                {{-- add values of level here --}}
            </select>
        </div>
    </div>
  
    <div class="field">
        <label for="object">Sujet de stage</label>
        <input type="text" name="object" id="object" value="{{ $object }}" />
    </div>
  
    <div class="field">
        <label for="entreprise">Entrepirse</label>
        <input type="text" name="entreprise" id="entreprise" value="{{ $entreprise }}" />
    </div>
  
    <div class="two fields">
        <div class="field">
            <label for="start">Date de commencement</label>
            <input type="datetime-local" class="" name="date_start" id="start" value="{{ date("Y-m-d\TH:i", strtotime($start)) }}" />
        </div>
        <div class="field">
            <label for="end">Date du termination</label>
            <input type="datetime-local" class="" name="end_offer" id="end"  value="{{ date("Y-m-d\TH:i", strtotime($end)) }}" />
        </div>
    </div>
    <div class="form-row" >
        <div class="ui buttons mx-auto">
            <button class="ui positive button" type="submit" id="submit{{ $action }}"><?php if($action=="-edit") echo "Modifier"; else echo "Ajouter";?></button>
            <div class="or" data-attr="ou"></div>
            <button class="ui button red" type="cancel" id="cancel{{ $action }}">Annuler</button>
        </div>
    </div>
  </form>
