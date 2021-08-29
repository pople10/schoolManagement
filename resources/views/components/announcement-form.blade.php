<div class="bootstrap">
<form  method="POST" enctype="multipart/form-data" id="create-announcement">
    <div class="form-group">
      <label for="title">Title</label>
      <input type="text" name="title" class="form-control" id="title" placeholder="Title" value="{!!$titleValue!!}" required>
    </div>

    <div class="form-group">
      <label for="type">Select Type</label>
      <select class="form-control" name="type" id="type" style="height: 34px"required>
        <option>evenement</option>
        <option default>examen</option>
        <option>administratif</option>
        <option>important</option>
        <option>...</option>
      </select>
    </div>

    <div class="form-group">
      <label for="role">Role</label>
      <select multiple class="form-control" name="role" id="role" >
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5</option>
      </select>
    </div>

    <div class="form-group">
      <label for="content">Content</label>
      <textarea name="content" class="form-control" id="content" rows="6" required>{!!$contentValue!!}</textarea>
    </div>

    <div class="form-group">
      <label for="file">Upload file</label>
      <input type="file" id="attachement" name="attachement" accept=".doc,.docx,.pdf,.xslt,.jpeg,.jpg,.png" multiple/>
    </div>

    <div class="form-row">
        <input id="submit" type="submit" value="{{$type}}">
    </div>
</form>

</div>


<script src="{{URL::asset('resources/js/AddNews.js')}}?t={{time()}}"></script>