<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();

include('includes/header.php');

if (isset($_POST['title'])){

    if ($stm = $connect->prepare('INSERT INTO posty (tytul, tresc, autor, data) VALUES (?, ?, ?, ?)')){
        
        $stm->bind_param('ssis', $_POST['title'], $_POST['content'], $_SESSION['id'],  $_POST['date']);
        $stm->execute();
        

        set_message("Nowy post dodany przez " . $_SESSION['username']);
        header('Location: posts.php');
        $stm->close();
        die();

    } else {
        echo 'Nie mozna przygotowac instrukcji!';
    }


}


?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
        <h1 class="display-1">Dodaj post</h1>
       
        <form method="post">
                
                <div class="form-outline mb-4">
                    <input type="text" id="title" name="title" class="form-control" />
                    <label class="form-label" for="title">Tytul</label>
                </div>
     

                
                <div class="form-outline mb-4">
                    <textarea name="content" id="content" ></textarea>
                </div>

                
                <div class="form-outline mb-4">
                <input type="date" id="date"  name="date" class="form-control" />
                <label class="form-label" for="date">Data</label>


                </div>

                
                <button type="submit" class="btn btn-primary btn-block">Dodaj post</button>
            </form>


       
        </div>

    </div>
</div>

<script src="js/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#content'
    });
</script>
<?php
include('includes/footer.php');
?>
