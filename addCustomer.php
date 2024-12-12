<html>
<head><title>Add Customer</title></head>
<body>
    <h1>Add New Customer</h1>
    <form method="POST" action="index.php?action=addCustomer">
        Customer Name: <input type="text" name="customer_name" required><br>
        Contact Information: <input type="text" name="contact_info" required><br>
        <button type="submit">Add Customer</button>
    </form>
    <a href="index.php">Back to Home</a>
</body>
</html>
