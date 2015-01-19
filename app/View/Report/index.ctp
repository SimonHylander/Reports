<html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>
<div id="contentpage">
    <div id="container">
    <?php
       echo $this->Form->create(false, array('id'=> 'dateSearchForm', 'type' => 'get', 'action' => 'search'));
        echo $this->Form->input('search', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => 'YYYY-MM-DD'));
        echo $this->Form->submit("search", array('div' => false));
        echo $this->Form->end();
       ?>


    <table id="pdfTable">
        <th>Name</th>
        <th>Date</th>
        <?php if(count($pages) > 0) :?>
        <?php foreach($pages[$currentPage-1] as $file): ?>
            <tr>
                <td><a href="<?php echo $href.$file;?>" target="_blank"><?php echo $file; ?></a></td>
                <td><?php echo date("Y-m-d H:i:s", filemtime($dir."/".$file))?></td>
            </tr>
        <?php endforeach; ?>
        <?php endif;?>
    </table>

    <div id="pageContainer">
        <div class="pagination">
            <a href="?page=<?php echo $previousPage?>" class="pageButton">Previous</a>

            <?php foreach($pageButtons as $page):
                if($currentPage == $page):?>
                    <span class="pageButton active"><?php echo $page ?></span>
                <?php else:
                    $queryStr = (!empty($searchDate))?"?search=".$searchDate."&page=".$page:"?page=".$page;
                    ?>
                    <a href="<?php echo $queryStr ?>" class="pageButton"><?php echo $page?></a>
                    <?php  ?>
                <?php endif;?>

            <?php endforeach;?>
            <a href="?page=<?php echo $nextPage?>" class="pageButton">Next</a>
        </div>
    </div>
    </div>
</div>
</body>
</html>
