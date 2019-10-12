<?php 
/*
*
* admin
*
*/

include 'header.php'; 

$links = new LinksController();  

?>

<div class="container">
    <div class="row flex-center">
        <div class="col-md-8 content">
            <p class="h1 .title ">Сервис коротких ссылок. Админка</p>
        </div>
        <div class="col-md-2 ml-4">
            <a href="/" class="links" style="font-size: 12px;">Создание ссылки</a>
            <a href="admin?logout=true" class="links">Выход</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table" style="font-size: 10px;">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Ссылка</th>
                    <th scope="col">Короткая ссылка</th>
                    <th scope="col">Дата создания</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($links->getAllLinks() as $key => $value) : ?>
                         <tr>
                           <th scope="row"><?php echo $value['id']?></th>
                           <td><a href="<?php echo $value['url']?>" class="links"><?php echo $value['url']?></a></td>
                           <td><a href="<?php echo $value['short_url']?>" class="links"><?php echo BASE_URL . $value['short_url']?></a></td>
                           <td><?php echo $value['date_create']?></td>
                           <td><a href="admin?delete=true&id=<?php echo $value['id']?>" class="links">Удалить</a></td>
                         </tr>
                <?php endforeach;?>
                </tbody>
              </table>
        </div>      
    </div>
</div>





<?php  include 'footer.php';