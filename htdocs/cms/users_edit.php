<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();

include('includes/header.php');

if (isset($_POST['username'])) {
    if ($stm = $connect->prepare('UPDATE uzytkownicy set nazwauzytkownika = ?, email = ?, aktywny = ? WHERE id = ?')){
        $stm->bind_param('sssi', $_POST['username'], $_POST['email'], $_POST['active'], $_GET['id']);
        $stm->execute();


        
        $stm->close();

        if (isset($_POST['password'])) {
            if ($stm = $connect->prepare('UPDATE uzytkownicy set haslo = ? WHERE id = ?')){
                $hashed = SHA1($_POST['password']);
                $stm->bind_param('si', $hashed, $_GET['id']);
                $stm->execute();

                $stm->close();
    
        } else {
            echo 'Could not prepare password update statement!';
        }
    }
        set_message('Użytkownik ' . $_GET['id'] . ' został zaktualizowany');
        header('Location: users.php');
        die();


    } else {
        echo 'Could not prepare user update statement!';
    }

   

    

}




if (isset($_GET['id'])){

    if ($stm = $connect->prepare('SELECT * from uzytkownicy WHERE id = ?')){        
        $stm->bind_param('i', $_GET['id']);
        $stm->execute();

        $result = $stm->get_result();
        $user = $result->fetch_assoc();

        if ($user){
           
            ?>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                    <h1 class=display-1>Edytuj użytkownika</h1>   
                
                    <form method="post">
                    
                            <div class="form-outline mb-4">
                                <input type="text" id="username" name="username" class="form-control active" value="<?php echo $user['nazwauzytkownika'] ?>" />
                                <label class="form-label" for="username">Nazwa użytkownika</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="email" id="email" name="email" class="form-control active" value="<?php echo $user['email'] ?>" />
                                <label class="form-label" for="email">Adres email</label>
                            </div>

                            
                            <div class="form-outline mb-4">
                                <input type="password" id="password"  name="password" class="form-control" />
                                <label class="form-label" for="password">Hasło</label>
                            </div>

                            <div class="form-outline mb-4">
                                <select name="active" class="form-select" id="active">
                                    <option <?php echo($user['aktywny']) ? "selected" : ""; ?> value="1">Aktywny</option>
                                    <option <?php echo($user['aktywny']) ? "" : "selected"; ?> value="0">Nieaktywny</option>
                                </select>

                            </div>

            

                            
                            <button type="submit" class="btn btn-primary btn-block">Aktualizuj</button>
                        </form>

                    </div>

                </div>
            </div>
            <?php
        }
        $stm->close();

    } else {
        echo 'Could not prepare statement!';
    } 

} else {
    echo "Nie wybrano użytkownika";
    die();
}


include('includes/footer.php');
?>
