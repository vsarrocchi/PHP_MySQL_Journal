<form id="form" action="?action=newpost" method="POST">
  <h2 class="h3 mb-3 font-weight-normal" style="text-align: center !important;">New Post</h2>

  <label for="title" class="sr-only">Title</label>
  <input type="text" class="form-control" placeholder="Title" name="title" required>
  <br>
  <label for="content" class="sr-only">Content</label>
  <textarea type="text" id="content" class="form-control" placeholder="Content" name="content" required></textarea>
  <br>
  <button id="btn-post" class="btn-lg btn-primary" type="submit">Post</button>
</form>
