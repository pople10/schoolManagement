<form action="announcement/{{$announcement->id}}" method="post">
    @method('DELETE')
    @csrf
    <button class="btn btn-danger" > delete </button>
</form>