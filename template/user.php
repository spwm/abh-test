<?php 
/*
*
* User
*
*/

include 'header.php'; 

?>

<div class="container">
    <div class="row flex-center position-ref full-height">
        <div class="col-md-8 content">
            <p class="h1 .title ">Сервис коротких ссылок. </p>
            <form id="link_form" class="text-center" >
              <div class="form-row">
                <div class="col-8">
                  <input type="url" name="link" class="form-control" placeholder="Url format http://example.com/">
                </div>
                <div class="col">
                  <button type="submit" class="btn btn-ajax-create-link btn-primary">Создать</button>
                </div>
              </div>
            </form>
            <div class="row">
                <div id="message" class="col-12 text-left mt-3"></div>
            </div>
        </div>
    </div>
</div>





<?php  include 'footer.php';