@include('includes.head')
@include('includes.menu')
<div class = "bootstrap">
    <div class="w-75 mx-auto p-3 mt-45 mb-10">
        <h2>Questions</h2>
    </div>
<div class="card w-95 mx-auto p-3 mt-2 mb-10">
    <div class="ui comments" id="questions" style="max-width:100%;">
        
    </div>
</div>
<script src="{{URL::asset('resources/js/question_prof.js')}}?t={{time()}}"></script>
@include('includes.footer')