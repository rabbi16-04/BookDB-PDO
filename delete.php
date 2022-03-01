<?php
require_once 'book.php';
require_once 'db.php';
if(isset($_POST["id"]) && !empty($_POST["id"]))
{
    $id = trim($_POST["id"]);
    // $content = file_get_contents('books.json');
    // $json = json_decode($content, true);
    // $index = 0;
    // foreach($json as $book_mixed) 
    // {
    //     $book = new Book();
    //     $book->setData($book_mixed);
    //     if($book->id === (int)$id)
    //     {
    //         unset($json[$index]);
    //         break;
    //     }
    //     $index++;
    // }
    // $json = array_values($json);
    // $content = json_encode($json, JSON_PRETTY_PRINT);
    // file_put_contents('books.json', $content);
    $db = new Database();
    $book = new Book($db);
    $res = $book->removeData($id);
    header('location: index.php'); 
} 
else
{
    if(empty(trim($_GET["id"])))
    {
        header("location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Book</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Delete Book</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Are you sure you want to delete the book <?php echo trim($_GET["title_"]); ?>?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="main.php" class="btn btn-secondary">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>

