<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>STUDYSMART</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"></script>
</head>
<body>


<?php
$url = "http://universities.hipolabs.com/";
if (isset($_GET["search"])) {
    $_GET["country"] = $_GET["search"];
    $url = $url . "search?country=" . $_GET["country"];
}


$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);
$res = curl_exec($ch);
$result_arr = json_decode($res, true);

/*
echo "<pre>";
var_export( $result_arr);

echo "</pre>";

*/

?>

<!-- Hero -->
<div class="p-5 text-center w-100  bg-image rounded-0" style="
    background-image: url('https://d36tnp772eyphs.cloudfront.net/blogs/1/2020/09/Nakajima-Library-Akita-International-University-Japan.jpg');
    height: 500px;
  ">
    <div class="mask w-100 h-100" style="background-color: rgba(0, 0, 0, 0.6);">
        <div class="d-flex  justify-content-around  align-items-center h-100">
            <img src="studysmart.png" class=" justify-content-start">
            <div class="text-white">
                <h5 class="d-flex  justify-content-center">Go where the winners go - Find University,dream study!</h5>
                <form class="d-flex" method="GET" role="search">
                    <input class="form-control  w-75" type="search" id="search" name="search" placeholder="Search"
                           aria-label="Search" style="border-radius: 0px;">
                    <button class="btn  bg-success text-bg-dark btn-outline-success rounded-0" type="submit">Search
                    </button>
                </form>
            </div>
        </div>


        <br>
        <br>
        <?php if (isset($_GET["search"])) { ?>
            <h1 class="d-flex justify-content-center"><?php echo $_GET["search"] ?></h1>
        <?php } else { ?>

        <?php } ?>
        <br>
        <?php
        //determine the page number, the user is currently visiting
        //if not present, we set it to 1
        if (!isset($_GET['page'])) {

            $page = 1;
        } else {

            //convert the pagenum to int

            $page = (int)$_GET['page'];
        }

        $results_per_page = 10; //amount of entries you want to show
        $page_first_result = ($page - 1) * $results_per_page; //first entry depending on current page
        $amt_entries = count($result_arr); //total number of universities
        $amt_pages = ceil($amt_entries / $results_per_page);
        $final = array_slice($result_arr, $page_first_result, $results_per_page);
        $this_site = $_SERVER['PHP_SELF'];
        echo "<br><br>"; ?>


    </div>
</div>
</div>
</div>
<br>
<br>
<div class="container">
    <div class="accordion" id="accordionExample">

        <?php $count = 1;
        if (isset($_GET["search"])) {
            foreach ($final as $array) {
                ?>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse<?php echo $count; ?>" aria-expanded="false"
                                aria-controls="collapse<?php echo $count; ?>">
                            <?php echo $array["name"]; ?>
                        </button>
                    </h2>
                    <div id="collapse<?php echo $count; ?>" class="accordion-collapse collapse"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>Website:</strong> <a
                                    href=" <?php echo $array["web_pages"]["0"]; ?>"> <?php echo $array["web_pages"]["0"]; ?> </a>
                        </div>
                    </div>
                </div>


                <?php $count++;
            } ?>
            <section class="container d-flex justify-content-center">
                <ul class="pagination">
                    <li class="page-item">
                        <?php if ($page > 1) { ?>
                            <a class="page-link"
                               href="<?php echo $this_site . '?page=' . ($page - 1) ?>">Previous</a>
                        <?php } else { ?>
                            <a class="page-link"
                               href="<?php echo $this_site . '?page=' . $page ?>">Previous</a>
                        <?php } ?>
                    </li>
                    <?php for ($x = $page; $x <= ($page + $results_per_page); $x++) {
                        if ($x <= $amt_pages) { ?>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo $this_site .'?page=' . $x ?>"><?php echo $x ?></a>
                            </li>
                        <?php }
                    } ?>
                    <li class="page-item">
                        <?php if ($page < $amt_pages) { ?>
                            <a class="page-link"
                               href="<?php echo $this_site . '?page=' . ($page + 1) ?>">Next</a>
                        <?php } else { ?>
                            <a class="page-link"
                               href="<?php echo $this_site . '?page=' . $page ?>">Next</a>
                        <?php } ?>
                    </li>

                </ul>
            </section>
            <?php


        } ?>
    </div>
</div>
</body>
</html>

