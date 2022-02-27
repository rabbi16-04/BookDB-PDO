<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Book Details</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Book</a>
                    </div>
                    <?php
                    // Attempt select query execution
                    require_once 'book.php';
                    require_once 'db.php';
                    $database = new Database();
                    $bk = new Book($database);
                    $res = $bk->getAllBooks();
                    $content = $res[0];
                    $books = $res[1];
                    // $content = file_get_contents("books.json", true);
                    $search_query = "";
                    if(isset($_GET["search_title"]))
                        $search_query = trim($_GET["search_title"]);
                    if($content == TRUE) 
                    {
                        // $books = array();

                        // $books = json_decode($content);
                        if(count($books) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Book Id</th>";
                                        echo "<th>Author</th>";
                                        echo "<th>Title</th>";
                                        echo "<th>Available</th>";
                                        echo "<th>Pages</th>";
                                        echo "<th>ISBN</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                
                                foreach($books as $book_mixed)
                                {
                                    $book = new Book($database);
                                    $book->setData($book_mixed);
                                    if(empty($search_query) || strpos($book->title, $search_query) !== FALSE)
                                    {
                                        echo "<tr>";
                                            echo "<td>" . $book->id . "</td>";
                                            echo "<td>" . $book->author . "</td>";
                                            echo "<td>" . $book->title . "</td>";
                                            echo "<td>" . ($book->available ? 'Yes' : 'No') . "</td>";
                                            echo "<td>" . $book->pages . "</td>";
                                            echo "<td>" . $book->isbn . "</td>";
                                            echo "<td>";
                                                echo '<a href="delete.php?id='. $book->id .'&title_='. $book->title .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                ?>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
                <div class="input-group mb-3">
                    <input name="search_title" type="text" class="form-control" placeholder="Part of the title" aria-label="Part of the title" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>