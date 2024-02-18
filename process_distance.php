<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        nav {
            background-color: #ddd;
            padding: 10px;
            text-align: center;
            width: 100%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed; /* Fixed position at the top */
            top: 0; /* Set to the top of the viewport */
            z-index: 1000; /* Ensure it's above other elements */
        }

        nav a {
            color: #333;
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #4caf50;
        }

        .result-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 60%;
            margin-top: 70px; /* Adjusted margin to accommodate the fixed navbar */
            overflow-x: auto;
            max-height: 300px; /* Set a maximum height for vertical scrollbar */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #001f3f;
            color: #fff;
        }

        h1, h4 {
            text-align: center;
            margin-top: 20px;
            color: #ccffcc;
        }

        .no-results {
            color: #6C757D;
            text-align: center;
        }

        /* Add some basic styling for the button */
        button {
            margin-bottom: 10px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #001f3f; /* Dark navy */
            color: white; /* White text */
            border: none;
            border-radius: 5px;
        }

        button:hover {
            background-color: #003366; /* Darker navy on hover */
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            border: 5px solid #ccc;
            border-radius: 5px;
            z-index: 1;
            animation: fadeIn 0.5s ease-in-out; /* Fade-in animation */
        }

        /* Keyframes for the fade-in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Added styling for the chat container */
        .chat-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 300px;
            margin-top: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            background-color: #fff;
        }

        .chat-messages {
            overflow-y: auto;
            max-height: 150px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .message-input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .send-button {
            margin-top: 10px;
            background-color: #001f3f; /* Dark navy */
            color: white; /* White text */
            border: none;
            border-radius: 5px;
            padding: 8px 16px;
            cursor: pointer;
        }
    </style>
</head>
<body style="background-image: url('https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwallpapercave.com%2Fwp%2Fwp7160241.jpg&f=1&nofb=1&ipt=b1a3dc4a62b1977140b18a9fef87844aa84b5fc24ce062d942dfd5872bdd2cff&ipo=images');">
<nav>
    <a href="#">Home</a>
    <a href="#">About</a>
    <a href="#">Contact</a>
</nav>
<div class="button-container"></div>
<div class="modal" id="alertModal"></div>
<?php
    // Your PHP code here
?>
<script>
    // Your JavaScript code here
</script>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "Information";

    $con = mysqli_connect($servername, $username, $password, $database);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $latHome = $_POST["latHome"];
        $longHome = $_POST["longHome"];
        $latWork = $_POST["latWork"];
        $longWork = $_POST["longWork"];
        $distance = $_POST["distance"];
        $phoneNumber = $_POST["phoneNumber"];
        
    } else {
        echo "failed";
    }

    echo "<h1>Carpool Results</h1>";
    echo "<h4>You selected: " . $distance . " km from your home/work</h4>";

    $sql = "SELECT * FROM `namedata` WHERE 1";
    $result = $con->query($sql);

    echo "<div class='result-container'>";
    $i=1;
    $c=1000;

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Name</th><th>Distance Away From Home(km)</th><th>Distance Away From Work(km)</th><th>Phone Number</th><th>Instagram</th><th></th></tr>";

        while ($row = $result->fetch_assoc()) {
            $distanceAway = haversineDistance($row['latHome'], $row['longHome'], $latHome, $longHome);
            $distanceAway2 = haversineDistance($latWork, $longWork, $row['latWork'], $row['longWork']);
        
            if (!($latHome == $row['latHome'] && $longHome == $row['longHome'] && $latWork == $row['latWork'] && $longWork == $row['longWork'])) {
                if ($distanceAway <= $distance && $distanceAway2 <= $distance ) {                    
                    ?>
                        <tr> 
                            <td><?php echo  $row['Name']  ?> </td>
                            <td><?php echo intval($distanceAway * 1e2) / 1e2 ?> </td>
                            <td> <?php echo intval($distanceAway2 * 1e2) / 1e2 ?></td>
                            <td> <?php echo $row['phoneNumber'] ?></td>
                            <td> <button id="button_<?php echo $c; ?>" type="button">Insta</button> </td>
                            <td><button id="button_<?php echo $i; ?>" type="button">Chat</button> </td>
                                    
                            <script>
                                var button<?php echo $i; ?> = document.getElementById("button_<?php echo $i; ?>");
                                var button<?php echo $c; ?> = document.getElementById("button_<?php echo $c; ?>");
        
                                button<?php echo $i; ?>.addEventListener("click", function() {
                                    // Display the alert in the modal
                                    const myArray = [[<?php echo $latHome?>, <?php echo $longHome?>, <?php echo $latWork?>, <?php echo $longWork?>],[<?php echo $row['latHome']?>, <?php echo $row['longHome']?>, <?php echo $row['latWork']?>, <?php echo $row['longWork']?>]];
                                    console.log(myArray);
                                    showAlert("CO2 emissions saved: " + truncateDecimals(carbonESaved(myArray),2)+ " grams <br> Money saved: "+truncateDecimals(moneySaved(myArray),2)+"$");
                                    createChatBox("<?php echo $row['Name']?>");
                                });
        
                                button<?php echo $c; ?>.addEventListener("click", function() {
                                    // Display the alert in the modal
                                    showAlert("Instagram: <a href='https://www.instagram.com/<?php echo $row['Insta']?>'><?php echo $row['Insta']?></a>");
                                });
                            </script>
                        </tr>
                    <?php
                    $i++;
                    $c++;
                }
            }
        }

        echo "</table>";
    } else {
        echo "<p class='no-results'>No results found</p>";
        echo "<script>alert('No carpooling options available in this area.')</script>";
    }

    echo "</div>";

    // Close connection
    $con->close();

    function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        // Radius of the Earth in kilometers
        $R = 6371;

        // Convert latitude and longitude from degrees to radians
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        // Calculate differences
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        // Haversine formula
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Distance in kilometers
        $distance = $R * $c;

        return $distance;
    }
?>
<script>
    window.addEventListener('mouseup', function(event){
        hideAlert();
    })

    function showAlert(message) {
        var modal = document.getElementById("alertModal");
        modal.innerHTML = message;
        modal.style.display = "block";
    }

    function hideAlert() {
        var modal = document.getElementById("alertModal");
        modal.style.display = "none";
    }

    // Chat box functionality
    function createChatBox(name) {
        var chatContainer = document.createElement("div");
        chatContainer.className = "chat-container";

        var chatMessages = document.createElement("div");
        chatMessages.className = "chat-messages";
        chatContainer.appendChild(chatMessages);

        var messageInput = document.createElement("input");
        messageInput.type = "text";
        messageInput.className = "message-input";
        messageInput.placeholder = "Type your message...";
        chatContainer.appendChild(messageInput);

        var sendButton = document.createElement("button");
        sendButton.innerHTML = "Send a Message to "+name;
        sendButton.className = "send-button";
        sendButton.addEventListener("click", sendMessage);
        chatContainer.appendChild(sendButton);

        document.body.appendChild(chatContainer);

        function sendMessage() {
            var messageText = messageInput.value.trim();
            if (messageText !== "") {
                var message = document.createElement("p");
                message.innerHTML = messageText;
                chatMessages.appendChild(message);
                messageInput.value = "";
            }
        }
    }

    // Example click me button script
       
    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371e3; // metres
        const φ1 = lat1 * Math.PI / 180; // φ, λ in radians
        const φ2 = lat2 * Math.PI / 180;
        const Δφ = (lat2 - lat1) * Math.PI / 180;
        const Δλ = (lon2 - lon1) * Math.PI / 180;

        const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
            Math.cos(φ1) * Math.cos(φ2) *
            Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

        const d = R * c; // in metres
        return d / 1000; // in km 

    }

    function maxDist(array) {
        let maxDistArray = [array[0][0], array[0][1], array[0][2], array[0][3]];
        let maxDist = calculateDistance(array[0][0], array[0][1], array[0][2], array[0][3]);

        for(let i = 0; i < array.length; i++){
            let workLat = array[i][2];
            let workLon = array[i][3];

            for(let j = 0; j < array.length; j++){
                let homeLat = array[j][0];
                let homeLon = array[j][1];
                const dist = calculateDistance(homeLat, homeLon, workLat, workLon);
                if(dist > maxDist){
                    maxDist = dist;
                    maxDistArray = [homeLat, homeLon, workLat, workLon];
                }                
            }
        }
        return maxDist;
    }

    function totalDist(array){
        let dist = 0;
        for(let i = 0; i < array.length; i++){
            let tempDist = calculateDistance(array[i][0], array[i][1], array[i][2], array[i][3]);
            dist = dist + tempDist;
        }
        return dist;
    }

    function distSaved(array){
        let distSaved = totalDist(array) - maxDist(array);
        distSaved = distSaved * 0.621371;  
        return distSaved;      
    }

    function carbonESaved(array){      
        let carbon = distSaved(array) * 405.5;
        return carbon; 
    }

    function moneySaved(array){
        return distSaved(array) * 0.58;
    }
    
    function truncateDecimals(number, digits) {
        var multiplier = Math.pow(10, digits),
        adjustedNum = number * multiplier,
        truncatedNum = Math[adjustedNum < 0 ? 'ceil' : 'floor'](adjustedNum);

        return truncatedNum / multiplier;
    }
</script>
</body>
</html>
