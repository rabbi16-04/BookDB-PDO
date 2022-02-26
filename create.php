<?php
require_once 'book.php';
require_once 'db.php';

$title = $author = "";
$available = true;
$pages = $isbn = 0;
$title_err = $author_err = $pages_err = $isbn_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $input_title = trim($_POST["title_"]);
    if(empty($input_title))
    {
        $title_err = "Please enter a title.";
    } 
    elseif(!filter_var($input_title, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))))
    {
        $title_err = "Please enter a valid title.";
    } else
    {
        $title = $input_title;
    }

    $input_author = trim($_POST["author"]);
    if(empty($input_author))
    {
        $author_err = "Please enter a author.";
    } 
    elseif(!filter_var($input_author, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))))
    {
        $author_err = "Please enter a valid author.";
    } 
    else
    {
        $author = $input_author;
    }

    $input_isbn = trim($_POST["isbn"]);
    if (empty($input_isbn))
    {
        $isbn_err = "Please enter an isbn.";     
    } 
    elseif (!ctype_digit($input_isbn))
    {
        $isbn_err = "Please enter a positive integer value.";
    } 
    elseif (strlen((string)$input_isbn) != 13) 
    {
        $isbn_err = "Please enter a valid 13 digit ISBN";
    }
    else 
    {
        $isbn = (int)$input_isbn;
    }

    $input_pages = trim($_POST["pages"]);
    if(empty($input_pages))
    {
        $pages_err = "Please enter the amount of pages.";     
    } 
    elseif(!ctype_digit($input_pages))
    {
        $pages_err = "Please enter a positive integer value.";
    } 
    else 
    {
        $pages = (int)$input_pages;
    }

    $input_availablity = $_POST["available"];
    
    // echo $input_availablity;
    
    // Check input errors before inserting in database
    if(empty($title_err) && empty($author_err) && empty($pages_err) && empty($isbn_err))
    {
        // $content = file_get_contents("books.json", true);
        // $last_id = 0;
        // $books = array();
        // if($content == TRUE) 
        // {
        //     $books = json_decode($content);
        //     $number_of_books = count($books);
        //     if($number_of_books > 0) 
        //     {
        //         $last_book = $books[$number_of_books - 1];
        //         $book = new Book($db);
        //         $book->setData($last_book);
        //         $last_id = $book->id;
        //     }
        // }
        $db = new Database();
        $book = new Book($db);
        // $book->id = $last_id + 1;
        $book->author = $author;
        $book->title = $title;
        $book->pages = $pages;
        $book->available = $available;
        $book->isbn = $isbn;
        $res = $book->insertData($book);
        // $books[] = $book;
        // $content = json_encode($books, JSON_PRETTY_PRINT);
        // file_put_contents("books.json", $content);
        header('location: main.php');
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill in the required information.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Title</label>
                            <textarea name="title_" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>"></textarea>
                            <span class="invalid-feedback"><?php echo $title_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Author</label>
                            <input type="text" name="author" class="form-control <?php echo (!empty($author_err)) ? 'is-invalid' : ''; ?>"><?php echo $author; ?>
                            <span class="invalid-feedback"><?php echo $author_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Pages</label>
                            <input type="text" name="pages" class="form-control <?php echo (!empty($pages_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $pages_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>ISBN</label>
                            <input type="text" name="isbn" class="form-control <?php echo (!empty($isbn_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $isbn_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Aavailablity</label>
                            <select class="form-control" aria-label="Yes" name="available">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>


                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="main.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>