<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();

include('includes/header.php');

if (isset($_POST['title'])) {

    if ($stm = $connect->prepare('UPDATE posty set  tytul = ?, tresc = ? , data = ?  WHERE id = ?')) {
        $stm->bind_param('sssi', $_POST['title'], $_POST['content'], $_POST['date'], $_GET['id']);
        $stm->execute();




        $stm->close();

        set_message("Post o id  " . $_GET['id'] . " zostal zaktualizowany");
        header('Location: posts.php');
        die();

    } else {
        echo 'Could not prepare post update statement statement!';
    }





}


if (isset($_GET['id'])) {

    if ($stm = $connect->prepare('SELECT * from posty WHERE id = ?')) {
        $stm->bind_param('i', $_GET['id']);
        $stm->execute();

        $result = $stm->get_result();
        $post = $result->fetch_assoc();

        if ($post) {


            ?>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h1 class="display-1">Edytuj post</h1>

                        <form method="post">
                            
                            <div class="form-outline mb-4">
                                <input type="text" id="title" name="title" class="form-control"
                                    value="<?php echo $post['tytul'] ?>" />
                                <label class="form-label" for="title">Tytul</label>
                            </div>


                            
                            <div class="form-outline mb-4">
                                <textarea name="content" id="content"><?php echo $post['tresc'] ?></textarea>
                            </div>

                            
                            <div class="form-outline mb-4">
                                <input type="date" id="date" name="date" class="form-control" value="<?php echo $post['data'] ?>" />
                                <label class="form-label" for="date">Data</label>


                            </div>

                            
                            <button type="submit" class="btn btn-primary btn-block">Edytuj post</button>
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
        }
        $stm->close();


    } else {
        echo 'Could not prepare statement!';
    }

} else {
    echo "Nie wybrano uzytkownika";
    die();
}

include('includes/footer.php');
?>
