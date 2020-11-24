<form action="?action=register" method="POST" class="form-signin" style="text-align: center !important">
  <h1 class="h3 mb-3 font-weight-normal">Register</h1>

  <label for="username" class="sr-only">Username</label>
  <input type="text" class="form-control" placeholder="Username" name="username" required>

  <label for="password" class="sr-only">Password</label>
  <input type="password" class="form-control" placeholder="Password" name="password" required>
  
  <button id="btn" class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
</form>
<?php 
  // if(isset($_GET['action']) && $_GET['action'] == register){
    // echo "The user {$_POST['username']} was created.";
  // }
?>