<?php
session_start();
include 'db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $productImg = "";  // Initialize the image path
    $targetDir = "uploads/"; // Directory to store images (create this folder)
    $targetFile = $targetDir . basename($_FILES["product_img"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["product_img"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["product_img"]["tmp_name"], $targetFile)) {
            $productImg = $targetFile; // Store the image path
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Data validation (You'll likely want to add more robust validation)
    if (empty($productName) || empty($description) || empty($price) || empty($productImg)) {
        echo "Please fill in all fields.";
    } else {
        // Prepare and execute the insert statement
        $stmt = $conn->prepare("INSERT INTO products (productName, product_img, description, price, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssd", $productName, $productImg, $description, $price);

        if ($stmt->execute()) {
            header("Location: manage_products.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Atari Electronic Store</title>
    <link rel="stylesheet" href="/atari-github/atari-github/style/add-product-style.css">
</head>

<body>
    <header>
        </header>
    
    <main>
        <section>
            <h2>Add Product Details</h2>
            <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" required><br>

                <label for="product_img">Product Image:</label>
                <input type="file" id="product_img" name="product_img" accept="image/*" required><br>

                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" cols="50"></textarea><br>

                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" min="0" required><br>

                <input type="submit" value="Add Product">
            </form>
        </section>
    </main>

    <footer>
    </footer>
</body>
</html>
