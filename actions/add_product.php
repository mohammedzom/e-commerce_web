<?php

require_once '../config/config.php';
require_once '../includes/middleware/check-admin.php';


if (isset($_POST['saveProductBtn'])) {
    try {
        $target_dir = __DIR__ . "/assets/uploads/images/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $imageFileType = strtolower(pathinfo($_FILES["prodect_image"]["name"], PATHINFO_EXTENSION));

        $unique_name = uniqid('product_', true) . '.' . $imageFileType;
        $target_file = $target_dir . $unique_name;

        $uploadOk = 1;

        $check = getimagesize($_FILES["prodect_image"]["tmp_name"]);
        if ($check === false) {
            $uploadOk = 0;
        }

        // 1mb max
        if ($_FILES["prodect_image"]["size"] > 1000000) {
            $uploadOk = 0;
        }

        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            $statuts = "فشل رفع الصورة — تأكد من نوع الملف وحجمه";
        } else {
            if (move_uploaded_file($_FILES["prodect_image"]["tmp_name"], $target_file)) {
                $image_url = APPURL . "assets/uploads/images/" . $unique_name;

                $product = [
                    'name' => $_POST['name'],
                    'description' => $_POST['description'],
                    'price' => $_POST['price'],
                    'stock_quantity' => $_POST['stock'],
                    'category_id' => $_POST['category_id'],
                    'image_url' => $image_url,
                ];

                $result = $conn->prepare("INSERT INTO products (name, description, price, stock_quantity, category_id, image_url) VALUES (:name, :description, :price, :stock_quantity, :category_id, :image_url)")
                    ->execute($product);
                $statuts = $result ? "تم إضافة المنتج بنجاح" : "فشل إضافة المنتج";
            } else {
                $statuts = "حدث خطأ أثناء رفع الملف";
            }
        }
    } catch (Exception $e) {
        $statuts = "حدث خطأ: " . $e->getMessage();
    }
    echo "<script>alert('$statuts')</script>";
}
