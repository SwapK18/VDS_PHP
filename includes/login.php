<?php
if (isset($_POST['login']))
{
    $emailz = $_POST['email'];
    $passwordz = $_POST['password'];
$table_name = 'tblusers ';

    $query = "SELECT id,EmailId,Password,FullName FROM " . $table_name . "  WHERE EmailId=:email";
    $query = $dbh->prepare($query);
    $query->bindParam(':email', $emailz, PDO::PARAM_STR);
    $query->execute();
    $num = $query->rowCount();

    if ($num > 0)
    {
        $row = $query->fetch(PDO::FETCH_ASSOC);

        $password2 = $row['Password'];

        if (password_verify($passwordz, $password2))
        {
            $_SESSION['login'] = $_POST['email'];
            $_SESSION['fname'] = $results->FullName;
            $currentpage = $_SERVER['REQUEST_URI'];
            // echo "<script type='text/javascript'> document.location = '$currentpage'; </script>";

        }
        else
        {

            echo "<script>alert('Invalid Details');</script>";

        }
    }else
        {

            echo "<script>alert('Invalid Details');</script>";

        }

}

?>

<div class="modal fade" id="loginform">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Sign In</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="login_wrap">
            <div class="col-md-12 col-sm-6">
              <form method="post">
                <div class="form-group">
                  <input type="email" class="form-control" name="email" placeholder="Email address*">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password" placeholder="Password*">
                </div>
                <div class="form-group checkbox">
                  <input type="checkbox" id="remember">
               
                </div>
                <div class="form-group">
                  <input type="submit" name="login" value="Login" class="btn btn-block">
                </div>
              </form>
            </div>
           
          </div>
        </div>
      </div>
      <div class="modal-footer text-center">
        <p>Don't have an account? <a href="#signupform" data-toggle="modal" data-dismiss="modal">Signup Here</a></p>
        <p><a href="#forgotpassword" data-toggle="modal" data-dismiss="modal">Forgot Password ?</a></p>
      </div>
    </div>
  </div>
</div>
