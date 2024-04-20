<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();

include('includes/header.php');

if (isset($_GET['delete'])){
    if ($stm = $connect->prepare('DELETE FROM posts where id = ?')){
        $stm->bind_param('i',  $_GET['delete']);
        $stm->execute();

        set_message("Post o numerze ID " . $_GET['delete'] . " zosta� usuni�ty");
        header('Location: posts.php');
        $stm->close();
        die();

    } else {
        echo 'Nie mo�na przygotowa� instrukcji!';
    }

}

if ($stm = $connect->prepare('SELECT * FROM posts')){
    $stm->execute();

    $result = $stm->get_result();



    
    if ($result->num_rows >0){
  


?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
        <h1 class="display-1">Zarz�dzanie postami</h1>
        <table class="table table-striped table-hover">
         <tr>
            <th>Id</th>
            <th>Tytu�</th>
            <th>ID Autora</th>
            <th>Tre��</th>
            <th>Edytuj | Usu�</th>

         </tr>

         <?php while($record = mysqli_fetch_assoc($result)){  ?>
        <tr>

        <td><?php echo $record['id']; ?> </td>
        <td><?php echo $record['title']; ?> </td>
        <td><?php echo $record['author']; ?> </td>
        <td><?php echo $record['content']; ?> </td>
        <td><a href="posts_edit.php?id=<?php echo $record['id']; ?>">Edytuj</a> | 
            <a href="posts.php?delete=<?php echo $record['id']; ?>">Usu�</a></td>
        </tr>
        
        
        <?php } ?> 


        </table>

        <a href="posts_add.php">Dodaj nowy post</a>
       
        </div>

    </div>
</div>


<?php
   } else 
   {
    echo 'Nie znaleziono �adnych post�w';
   }

    
   $stm->close();

} else {
   echo 'Nie mo�na przygotowa� instrukcji!';
}
include('includes/footer.php');
?>