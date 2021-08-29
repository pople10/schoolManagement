@include('includes.head')
@include('includes.menu')

<div class="R___P">
    <div id="add__r_cc">
        <div class="el_add__r_cc">
            <div class="pr_v_t">
               ajouter un nouveau Role
            </div>
            <div class="pr_v_e">
                <div class="pr_v_r">
                    <span class="lb__v_r">Role</span>
                    <input type="text" id="role_r" onkeyup="sendv()" onkeydown="sendv()"/>
                </div>
                <span class="lb__v_r">Previllèges<span style="color:red;">*</span></span>
                <div class="pr_v_rr" id="ipr_v_rr">
                   
                </div>
            </div>
            <div class="pr_v_tp">
         
                <div class="bootstrap">
                    <div class="form-row"> 
                    <div class="ui buttons mx-auto">
                         <button  onclick="send_data()" class="ui button positive" id="submit_r" disabled style="background: #2e30b1a3;" type="submit" op="add">Ajouter</button> 
                         <div class="or" data-text="ou">
                             
                         </div> <button id="cancel_rr" onclick="rmvrole()" class="ui button red">Annuler</button> </div></div>
                </div>
             </div>
        </div>
   </div>
    <div class="addr">
        <div class="bootstrap">
        <button type="submit" id="Add__r" class="ui positive button mx-auto" onclick="shwrole()">
            <span>ajouter un nouveau Role</span>
        </button>
        </div>
            <div class="bootstrap " style=" width: 100%;" >
                <table class="table table-striped table-bordered dataTable no-footer" style="width:100%" id="roles-table">
                    <thead class="bg-primary" style="color:white;">
                      <tr>
                        <th scope="col"></th>
                        <th scope="col">#</th>
                        <th scope="col" >Roles</th>
                        <th scope="col" >Prévilleges</th>
                      </tr>
                    </thead>
                </table>
             </div>
    </div>
</div>
<script src="{{URL::asset('resources/js/roles.js')}}?t={{time()}}"></script>
<script src="{{URL::asset('resources/js/rolesFunct.js')}}?t={{time()}}"></script>
@include('includes.footer')