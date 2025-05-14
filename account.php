<?php
session_start();
require 'db_connect.php';
include 'header.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; 


$query = $pdo->prepare("SELECT * FROM accounts WHERE user_id = ?");
$query->execute([$user_id]);
$accounts = $query->fetchAll(PDO::FETCH_ASSOC);

$accountData = [
    'checking' => null,
    'savings' => null,
    'loan' => null
];

foreach ($accounts as $account) {
    $type = strtolower(trim($account['account_type']));
    if (isset($accountData[$type])) {
        $accountData[$type] = $account;
    }
}


?>


<!DOCTYPE html>
<html>
<head>
    <title>Your Accounts - Finance Master</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="mystyle.css">
    <script>
        // Fetch account data from accountAction.php and display on page
        document.addEventListener("DOMContentLoaded", function() {
            fetch("accountAction.php")
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById("accounts-container");
                    data.forEach(account => {
                        const card = document.createElement("div");
                        card.className = "w3-card-4 w3-margin w3-padding w3-white";

                        const title = document.createElement("h3");
                        title.textContent = account.account_type + " Account";

                        const balance = document.createElement("p");
                        balance.innerHTML = "<strong>Balance:</strong> $" + parseFloat(account.balance).toFixed(2);

                        card.appendChild(title);
                        card.appendChild(balance);
                        container.appendChild(card);
                    });
                })
                .catch(error => console.error("Error loading accounts:", error));
        });
    </script>
</head>
<body>

    <div class="w3-container w3-padding-64">
        <h2>Your Accounts</h2>
        <div id="accounts-container"></div>
    </div>

</body>
</html>

