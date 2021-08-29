<form class="ui form bordered " id="library-form" >
    @csrf
        <h3 class="ui dividing header">Creation d'un élément</h3>

    <div class="field">
        <label for="isbn">ISBN</label>
        <input type="text" name="isbn" id="isbn" autocomplete="off" value=""  autofocus />
    </div>
        
    <div class="field">
        <label for="title">titre</label>
        <input type="text" name="title" id="title" required autocomplete="off" value=""  autofocus />
    </div>
  
    <div class="field">
        <label for="author">Auteur</label>
        <input type="text" name="author" id="author" required autocomplete="off" value=""  autofocus />
    </div>
  
    <div class="field">
        <label for="type">Type de livre</label>
        <select name="type" id="type">
            <option value="">Sélectionner type</option>
            <option value="sci">scientifique</option>
            <option value="psy">psychologique</option>
            <option value="divertissement">divertissement</option>            
            @foreach($module as $mod)
                <option value="{{$mod->code}}">{{$mod->label}}</option>
            @endforeach
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

