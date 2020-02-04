<?php 
// Start the session
session_start();
    require "connection/connect.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>meSSION</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/common/header.php'; ?> 
    </header>
    <main>
        <section  class="content-width">

        <div class="search-box">            

            <form method="post" action="index.php">
                <input type="text" name="query" placeholder="Search information...">
                <select name="typeOfQuery">
                    <option value="">Select Filter</option>
                    <option value="firstName">First Name</option>
                    <option value="lastName">Last Name</option>
                    <option value="missionaryTitle">Missionary Title</option>
                    <option value="churchUnit">Ward/Branch</option>
                </select>
                <input type="submit" name="submit" value="Find">
            </form>
        </div>

        <div class="search-result">
            <?php
                if(isset($_POST['submit'])) {
                    $query = htmlspecialchars($_POST['query']);
                    $typeOfQuery = htmlspecialchars($_POST['typeOfQuery']);

                    if($typeOfQuery == "" || ($typeOfQuery != "firstName" && $typeOfQuery != "lastName" && $typeOfQuery != "missionaryTitle" && $typeOfQuery != "churchUnit")) {
                        $typeOfQuery = "firstName";
                    }

                    foreach ($db->query("SELECT
                    us.first_name || ' ' || us.last_name AS full_name,
                    ms.missionary_title AS missionary_name,
                    mt.companion_name AS companion,
                    un.unit_name AS ward_or_branch,
                    un.stake_name AS stake
                FROM
                    public.users us
                INNER JOIN public.missionary_timeline mt ON us.user_id = mt.user_id
                INNER JOIN public.unit un ON un.unit_id = mt.unit_id
                INNER JOIN public.missionary_service ms ON us.user_id = ms.user_id
                    WHERE un.unit_name = 'Ramo Oswaldo Cruz'") as $row) {
                        echo 'Fullname: ' . $row['full_name'] . '<br>';
                        echo 'Missionary Name: ' . $row['missionary_name'] . '<br>';
                        echo 'Ward/Branch: ' . $row['ward_or_branch'] .  '<br>';
                    }

                }
            ?>
        </div>

        </section>
    </main>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php'; ?> 
    </footer>

    <script src=""></script>    

    <!-- Importing FontAwesome icons -->
    <script src="https://kit.fontawesome.com/d92ab94eeb.js"></script>

</body>
</html>