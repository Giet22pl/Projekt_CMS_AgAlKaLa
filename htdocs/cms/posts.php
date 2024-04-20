<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();

include('includes/header.php');

if (isset($_GET['delete'])){
    if ($stm = $connect->prepare('DELETE FROM posty where id = ?')){
        $stm->bind_param('i',  $_GET['delete']);
        $stm->execute();

        set_message("Post o numerze ID " . $_GET['delete'] . " zostal usuniety");
        header('Location: posts.php');
        $stm->close();
        die();

    } else {
        echo 'Nie mozna przygotowaa instrukcji!';
    }

}

if ($stm = $connect->prepare('SELECT * FROM posty')){
    $stm->execute();

    $result = $stm->get_result();



    
    if ($result->num_rows >0){
  


?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
        <h1 class="display-1">Zarzadzanie postami</h1>
        <table class="table table-striped table-hover">
         <tr>
            <th>Id</th>
            <th>Tytul</th>
            <th>ID Autora</th>
            <th>Tresc</th>
            <th>Edytuj | Usun</th>

         </tr>

         <?php while($record = mysqli_fetch_assoc($result)){  ?>
        <tr>

        <td><?php echo $record['id']; ?> </td>
        <td><?php echo $record['tytul']; ?> </td>
        <td><?php echo $record['autor']; ?> </td>
        <td><?php echo $record['tresc']; ?> </td>
        <td><a href="posts_edit.php?id=<?php echo $record['id']; ?>">Edytuj</a> | 
            <a href="posts.php?delete=<?php echo $record['id']; ?>">Usun</a></td>
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
    echo 'Nie znaleziono zadnych postow';
   }

    
   $stm->close();

} else {
   echo 'Nie mozna przygotowac instrukcji!';
}
include('includes/footer.php');
?>
