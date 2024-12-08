<?php
// Assuming you've passed the customer details and preferences to this template
$customer = isset($customer) ? $customer : null;
$preferences = isset($preferences) ? $preferences : null;
?>
<html>
<head><title>Update Customer Preferences</title></head>
<body>
    <h1>Update Customer Preferences</h1>
    <form method="POST" action="index.php?action=updatePreferences">
        Customer ID: <input type="text" name="customer_id" value="<?= htmlspecialchars($customer['customerId'] ?? '') ?>" required><br>
        Preferences: <textarea name="preferences" required><?= htmlspecialchars($preferences ?? '') ?></textarea><br>
        <button type="submit">Update Preferences</button>
    </form>
    <a href="home.php">Back to Home</a>
</body>
</html>