<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: url('https://images-ext-2.discordapp.net/external/_1pe7tnGlASV3uV6ecrmzyJypc4XTqocj0TZa-OT4yA/https/i.pinimg.com/originals/bd/b4/a4/bdb4a461f23e2f8d17f788daa6b01825.png?format=webp&quality=lossless&width=1645&height=925') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .wrapper {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
            text-align: center; /* Center-align text */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        h1 {
            font-family: Helvetica, sans-serif; /* Change font to Helvetica */
            color: #333;
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 40px;
            animation: fadeIn 1s ease forwards, scale 2s ease infinite alternate;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes scale {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(1.1); /* Scale to 110% */
            }
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 20px;
            padding: 15px 30px;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        select {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 18px;
            border: none;
            border-radius: 20px;
            background-color: rgba(255, 255, 255, 0.8);
        }

        label {
            color: #333;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<?php
require "vendor/autoload.php";

$servername = "localhost";
$username = "root";
$password = "";
$database = "Information";
$con = mysqli_connect($servername, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name=$_POST["newContent"];
    $homeAddress = $_POST["homeAddress"];
    $workAddress = $_POST["workAddress"];
    $phoneNumber = $_POST["phoneNumber"];
    $insta = $_POST["Insta"];
    
    $geocoder = new \OpenCage\Geocoder\Geocoder('0d037ba79d3a4957ab36d3bda3f0f2d6');
    $homeResult = $geocoder->geocode($homeAddress);
    $first = $homeResult['results'][0];
    $longHome = $first['geometry']['lng'];
    $latHome = $first['geometry']['lat'];
    $workResult = $geocoder->geocode($workAddress);
    $second = $workResult['results'][0];
    $longWork = $second['geometry']['lng'];
    $latWork = $second['geometry']['lat'];
    $query = "INSERT INTO `namedata`(`Name`, `AcumRating` , `numRatings`, `longHome` , `latHome`, `longWork`, `latWork`, `phoneNumber`,`insta`) VALUES ('$name',1.0,1,'$longHome','$latHome','$longWork','$latWork','$phoneNumber','$insta')";
    $result = mysqli_query($con, $query);
}
echo "<div class='wrapper'>";
echo "<h1>Hello, ".$name."</h1>";
?>
<form action="process_distance.php" method="post">
    <label for="distance">Select a max distance for carpool in km:</label>
    <select id="distance" name="distance">
        <option value="1">1</option>
        <option value="5">5</option>
        <option value="10">10</option>
    </select>
    <input type="submit" value="Submit">
    <input type="hidden" id="latHome" name="latHome" value="<?php echo $latHome?>">
    <input type="hidden" id="longHome" name="longHome" value="<?php echo $longHome?>">
    <input type="hidden" id="latWork" name="latWork" value="<?php echo $latWork?>">
    <input type="hidden" id="longWork" name="longWork" value="<?php echo $longWork?>">
    <input type="hidden" id="phoneNumber" name="phoneNumber" value="<?php echo $phoneNumber?>">
    <input type="hidden" id="Insta" name="Insta" value="<?php echo $insta?>">
</form>
</div>
</body>
</html>