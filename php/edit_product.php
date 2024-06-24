<?php
session_start();
include 'db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit();
}

// Check if product_id is provided
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Fetch existing product details
    $stmt = $conn->prepare("SELECT product_name, product_img, description, price FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $stmt->bind_result($productName, $existingImgPath, $description, $price);
    $stmt->fetch();
    $stmt->close();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process the form submission
        $newProductName = $_POST['product_name'];
        $newDescription = $_POST['description'];
        $newPrice = $_POST['price'];

        $newImgPath = $existingImgPath; // Keep the existing image by default

        // Handle image upload if a new image is selected
        if ($_FILES["product_img"]["name"]) {
            $targetDir = "uploads/"; 
            $targetFile = $targetDir . basename($_FILES["product_img"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

            // Image validation (add more as needed)
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
            } else {
                if (move_uploaded_file($_FILES["product_img"]["tmp_name"], $targetFile)) {
                    $newImgPath = $targetFile; // Update the image path if the upload is successful
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }

        // Prepare and execute the update statement
        $stmt = $conn->prepare("UPDATE products SET productName = ?, product_img = ?, description = ?, price = ? WHERE product_id = ?");
        $stmt->bind_param("sssii", $newProductName, $newImgPath, $newDescription, $newPrice, $productId);

        if ($stmt->execute()) {
            header("Location: manage_products.php"); // Redirect back to the product list
            exit();
        } else {
            echo "Error updating product: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    // Handle missing product_id
    echo "Product ID not provided.";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>
    <header>
        </header>
    
    <main>
        <section>
            <h2>Edit Product Details</h2>
            <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?product_id=".$productId; ?>">
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($productName); ?>" required><br>

                <label for="product_img">Product Image:</label>
                <input type="file" id="product_img" name="product_img" accept="image/*"><br>
                <small>(Leave blank to keep existing image)</small><br>

                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" cols="50"><?php echo htmlspecialchars($description); ?></textarea><br>

                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" min="0" value="<?php echo htmlspecialchars($price); ?>" required><br>

                <input type="submit" value="Save Changes">
            </form>
        </section>
    </main>

    <footer>
    </footer>
</body>
</html>
