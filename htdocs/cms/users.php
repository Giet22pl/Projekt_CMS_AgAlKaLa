<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();

include('includes/header.php');

if (isset($_GET['delete'])){
    if ($stm = $connect->prepare('DELETE FROM users where id = ?')){        
        $stm->bind_param('i', $_GET['delete']);
        $stm->execute();

        set_message('Użytkownik ' . $_GET['delete'] . 'został usunięty');
        header('Location: users.php');
        $stm->close();
        die();

    } else {
        echo 'Could not prepare statement!';
    }

}

if ($stm = $connect->prepare('SELECT * FROM users')){
    $stm->execute();

    $result = $stm->get_result();
    
    
    if ($result->num_rows >0){
       
    


?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
        <h1 class=display-1>Zarządzanie użytkownikami</h1>   
        <table class="table table-striped table-hover">
        <tr>
            <th>Id</th>
            <th>Nazwa użytkownika</th>
            <th>Email</th>
            <th>Status</th>
            <th>Edytuj  |  Usuń</th>

        </tr>

         <?php while($record = mysqli_fetch_assoc($result)){  ?>
        <tr>
        <td><?php echo $record['id']; ?> </td>
        <td><?php echo $record['username']; ?> </td>
        <td><?php echo $record['email']; ?> </td>
        <td><?php echo $record['active']; ?> </td>
        <td><a href="user_edit.php?id=<?php echo $record['id']; ?>">Edytuj</a>
            <a href="users.php?delete=<?php echo $record['id']; ?>">Usuń</a></td>
        </tr>
            
        <?php } ?>
        
        </table>

        <a href="users_add.php"> Dodaj nowego użytkownika</a>

         </div>

    </div>
</div>



<?php
    } else
    {
        echo 'Nie znaleziono użytkowników';
    }

     
    $stm->close();

} else {
    echo 'Could not prepare statement!';
}

include('includes/footer.php');
?>