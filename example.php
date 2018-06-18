<?php 
require './Pagination.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>
    .pagination {
      display: flex;
      justify-content: center;
      width: 100%;
      margin: 0;
      padding: 0;
      list-style: none;
    }
    .pagination-link {
      padding: 10px;
      background-color: #0375B4;
      color: #fff;
      text-decoration: none;
    }
    .pagination-item.active .pagination-link, .pagination-link:hover {
      background-color: #0264a3;
    }
  </style>
</head>
<body>
<?php  
    $currentPage = $_GET['page'] ?? 1;

    $items = range(1, 60);

    $pagination = new Pagination($currentPage, count($items), 10, 2);

    echo $pagination->getHTMLList('/pagination/example.php?page=%page', [
        'previousText' => 'Previous',
        'previousClass' => 'pagination-previous',
        'nextText' => 'Next',
        'nextClass' => 'pagination-next',
        'listClass' => 'pagination',
        'listItemClass' => 'pagination-item',
        'linkClass' => 'pagination-link',
        'currentClass' => 'active'
    ]);
?>
</body>
</html>