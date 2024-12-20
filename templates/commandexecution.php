<?php
session_start();

// Get the security level
$security_level = isset($_SESSION['security_level']) ? $_SESSION['security_level'] : 'low';

// Function to sanitize input in high-security mode
function sanitize_input($input) {
    return escapeshellcmd($input); // Escapes shell metacharacters to prevent command injection
}

$command_result = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ip_address = $_POST['ip_address'];

    // Process input based on security level
    if ($security_level == 'low') {
        // Low-security mode: No sanitization (Vulnerable to command injection)
        $command = "ping  4 " . $ip_address;
    } elseif ($security_level == 'medium') {
        // Medium-security mode: Basic sanitization (still vulnerable to bypasses)
        $command = "ping -c 4 " . escapeshellarg($ip_address); // Escaping input, but still can be bypassed
    } else {
        // High-security mode: Proper sanitization to prevent command injection
        $command = "ping -c 4 " . sanitize_input($ip_address);
    }

    // Execute the command and store the result
    $command_result = shell_exec($command);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HackLab</title>
    <link rel="stylesheet" href="../assets/css/commandexecution.css"> <!-- Adjusted link -->
    <style>
        /* Nav styling - fixed below the header */
        nav {
            background-image: url('../assets/image/header2.jpg'); /* Add your nav background image here */
            background-color: #333; /* Fallback color */
            background-size: cover;
            background-position: center;
            padding: 20px 0;
            position: fixed; /* Fix the nav bar */
            top: 20px; /* Align it just below the header */
            left: 0;
            right: 0;
            z-index: 999; /* Ensure it stays on top of the content */
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
            margin: 0;
            display: flex; /* Use flex for horizontal layout */
            justify-content: center; /* Center items */
            flex-wrap: wrap; /* Allow wrapping */
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 10px 5px;
            transition: background-color 0.3s;
        }

        nav ul li a:hover {
            background-color: hwb(187 42% 18%);
            text-decoration: underline;
        }

        h2, h3 {
            color: #333;
            margin-bottom: 10px;
            cursor: pointer;
        }

        h2:hover, h3:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

<header>
    <h1 style="font-size: 40px">  𝐇𝐚𝐜𝐤𝐋𝐚𝐛  </h1>
</header>

<nav>
    <ul>
        <li><a href="dashboard.html">Home</a></li>
        <li><a href="instructions.html">Instructions</a></li>
        <li><a href="setup.html">Setup</a></li>
        <li><a href="bruteforce.php">Brute Force</a></li>
        <li><a href="commandexecution.php">Command Execution</a></li>
        <li><a href="csrf.html">CSRF</a></li>
        <li><a href="fileinclusion.html">File Inclusion</a></li>
        <li><a href="sqlinjection.html">SQL Injection</a></li>
        <li><a href="sqlinjection(blind).html">SQL Injection (Blind)</a></li>
        <li><a href="upload.html">Upload</a></li>
        <li><a href="xssreflected.html">XSS Reflected</a></li>
        <li><a href="xssstored.html">XSS Stored</a></li>
        <li><a href="security.php">HackLab security</a></li>
        <li><a href="phpinfo.php">PHP Info</a></li>
    </ul>
</nav>

<div class="content">
    <div class="container">
        <h1>Vulnerability: Command Execution</h1>

        <div class="form-container">
            <h2>Ping for FREE</h2>
            <p>Enter an IP address below:</p>
            <form action="commandexecution.php" method="POST">
                <input type="text" name="ip_address" placeholder="Enter IP address">
                <input type="submit" value="submit">
            </form>

            <!-- Display the result of the command execution -->
            <h3>Command Output:</h3>
            <pre><?php echo htmlspecialchars($command_result); ?></pre>
        </div>

        <div class="more-info">
            <h3>More info</h3>
            <ul>
                <li><a href="http://www.scribd.com/doc/2530476/Php-Endangers-Remote-Code-Execution" target="_blank">http://www.scribd.com/doc/2530476/Php-Endangers-Remote-Code-Execution</a></li>
                <li><a href="http://www.ss64.com/bash/" target="_blank">http://www.ss64.com/bash/</a></li>
                <li><a href="http://www.ss64.com/nt/" target="_blank">http://www.ss64.com/nt/</a></li>
            </ul>
        </div>
    </div>
</div>

<footer style="font-size: 20px"> 🅷🅰🅲🅺🅻🅰🅱 </footer>

</body>
</html>
