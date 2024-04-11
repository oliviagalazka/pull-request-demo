<?php

// We'll create an empty array of dogs
$dogs = [];

if (file_exists("dogs.json")) {
    // ...And if the file exists (with our dogs)
    $json = file_get_contents("dogs.json");
    // We'll insert them into our array
    $dogs = json_decode($json, true);
}

// The user message starts out as an empty string
$message = "";

// We'll check if we received what we wanted
if (isset($_POST["name"], $_POST["breed"], $_POST["age"], $_POST["favoriteFood"])) {
    $name = $_POST["name"];
    $breed = $_POST["breed"];
    $age = $_POST["age"];
    $food = $_POST["favoriteFood"];

    // ...And that the values are not empty
    if ($name != "" && $breed != "" && $age != "" && $food != "") {
        $newDog = [
            "name" => $name,
            "breed" => $breed,
            "age" => intval($age),    // NOTE: intval converts a variable to an integer (https://www.php.net/manual/en/function.intval.php)
            "favoriteFood" => $food,
        ];

        // ...If so, we'll add the new dog to our database
        $dogs[] = $newDog;
        file_put_contents("dogs.json", json_encode($dogs, JSON_PRETTY_PRINT));

        // Here we set the user message, so we can notify them of what happened
        $message = "$name ($breed) was added to the kennel!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Buddies</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

    <main>
        <h1>Best Buddies</h1>

        <?php
        if ($message != "") {
            echo "<p class=info>$message</p>";
        }
        ?>

        <section id="dogs">
        <?php
        if (count($dogs) == 0) {
            echo "<p>There are no dogs yet.</p>";
        } else {
            echo "
            <div>
                <div>Name</div>
                <div>Breed</div>
                <div>Age</div>
                <div>Favorite Food</div>
            </div>
            ";
        }

        foreach ($dogs as $dog) {
            $name = $dog["name"];
            $breed = $dog["breed"];
            $age = $dog["age"];
            $food = $dog["favoriteFood"];

            echo "
            <div>
                <div>$name</div>
                <div>$breed</div>
                <div>$age</div>
                <div>$food</div>
            </div>
            ";
        }
        ?>
        </section>

        <h2>Add a new dog</h2>

        <form action="index.php" method="POST">
            <input type="text" name="name" placeholder="Name">
            <input type="text" name="breed" placeholder="Breed">
            <input type="number" name="age" placeholder="Age">
            <input type="text" name="favoriteFood" placeholder="Favorite Food">
            <button type="submit">Save</button>
        </form>
    </main>
    
</body>
</html>