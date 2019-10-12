<?php 
/*
*
* admin
*
*/

include 'header.php'; 

?>

<div class="container">
    <div class="row flex-center position-ref full-height">
        <div class="col-md-6 content">
            <p class="h1 .title ">Сервис коротких ссылок. Админка</p>
            <form id="auth" action="/" method="post">
                <div class="form-group row">
                    <label for="login" class="col-sm-2 col-form-label">Login*</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="login" name="login" placeholder="Login" required>
                    </div>
                </div>
                <div class="form-group row">
                  <label for="password" class="col-sm-2 col-form-label">Password*</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                  </div>
                </div>
                <button type="submit" name="auth" class="btn btn-primary">Войти</button>
            </form>              
            <div class="row">
                <?php if(isset($message)) : ?>
                    <div id="message" class="col-12 text-left mt-3 alert alert-danger">
                        <?php echo $message?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>





<?php  include 'footer.php';