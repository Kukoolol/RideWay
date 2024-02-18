<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Text File</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to bottom, #8e2de2, #4a00e0);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        nav {
            background-color: transparent;
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

        .content-wrapper {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin-top: 90px;
            transition: transform 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .content-wrapper:hover {
            transform: translateY(-5px);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s ease;
        }

        input:focus {
            border-color: #4caf50;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
        
        img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <form action="modify.php" method="post" onsubmit="return validateForm()">
            <label for="newContent">Input your name, work address, and home address</label>
            <input type="text" id="newContent" name="newContent" placeholder="Your Name">
            <input type="text" id="homeAddress" name="homeAddress" placeholder="Home Address">
            <input type="text" id="workAddress" name="workAddress" placeholder="Work Address">
            <input type="tel" id="phoneNumber" name="phoneNumber" placeholder="Phone Number">
            <input type="text" id="Insta" name="Insta" placeholder="Instagram (Optional)">
            <input type="submit" value="Submit">
        </form>
    </div>
    <img src="https://images5.alphacoders.com/102/thumbbig-1026346.webp" alt="Background Image">
    <script>
        function validateForm() {
            var name = document.getElementById("newContent").value;
            var homeAddress = document.getElementById("homeAddress").value;
            var workAddress = document.getElementById("workAddress").value;
            var phoneNumber = document.getElementById("phoneNumber").value;
            var insta = document.getElementById("Insta").value;
            var phoneRegex = /^\d{3}\d{3}\d{4}$/; // USA phone number format

            if (!/^[a-zA-Z\s]+$/.test(name)) {
                alert("Please enter a valid name.");
                return false;
            }
            const regex = /^(?=.*\b(?:Terrace|Parkway|Street|Avenue|Road|Lane|Boulevard|Drive|Court|Place|Ave|Ct|St|Ln|Rd|Dr|Way)\b)(?!.*\b(?:\1)\b).*$/;
            if (!regex.test(homeAddress)) {
                 alert("Please enter a valid home address.");
                return false;
            }

            if (!regex.test(workAddress)) {
                alert("Please enter a valid work address.");
                return false;
            }

            if (workAddress.toLowerCase() === homeAddress.toLowerCase()) {
                alert("Work address cannot be the same as the home address.");
                return false;
            }

            if (!phoneRegex.test(phoneNumber)) {
                alert("Please enter a valid USA phone number (e.g., 123-456-7890).");
                return false;
            }

            return true;
        }

        function isValidAddress(address) {
            // You can implement additional validation for addresses if needed
            return address.trim() !== "";
        }
    </script>
</body>
</html>
