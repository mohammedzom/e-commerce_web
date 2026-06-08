<?php
require_once '../config/config.php';
require_once '../includes/middleware/check-admin.php';

function redirect_edit_product_error(int $product_id, string $message): void
{
    $_SESSION['product_form_error'] = $message;
    header('Location: ' . APPURL . 'admin_product_form.php?id=' . $product_id);
    exit;
}

function upload_product_image_if_selected(int $product_id): ?string
{
    if (!isset($_FILES['prodect_image']) || $_FILES['prodect_image']['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($_FILES['prodect_image']['error'] !== UPLOAD_ERR_OK) {
        redirect_edit_product_error($product_id, 'حدث خطأ أثناء رفع الصورة.');
    }

    $target_dir = dirname(__DIR__) . '/assets/uploads/images/';

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $image_file_type = strtolower(pathinfo($_FILES['prodect_image']['name'], PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($image_file_type, $allowed_types, true)) {
        redirect_edit_product_error($product_id, 'نوع الصورة غير مدعوم.');
    }

    if ($_FILES['prodect_image']['size'] > 1000000) {
        redirect_edit_product_error($product_id, 'حجم الصورة يجب أن لا يتجاوز 1MB.');
    }

    if (getimagesize($_FILES['prodect_image']['tmp_name']) === false) {
        redirect_edit_product_error($product_id, 'الملف المرفوع ليس صورة صالحة.');
    }

    $unique_name = uniqid('product_', true) . '.' . $image_file_type;
    $target_file = $target_dir . $unique_name;

    if (!move_uploaded_file($_FILES['prodect_image']['tmp_name'], $target_file)) {
        redirect_edit_product_error($product_id, 'حدث خطأ أثناء حفظ الصورة.');
    }

    return APPURL . 'assets/uploads/images/' . $unique_name;
}

if (!isset($_POST['updateProductBtn'])) {
    header('Location: ' . APPURL . 'admin_products.php');
    exit;
}

$product_id = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;

if ($product_id <= 0) {
    header('Location: ' . APPURL . 'admin_products.php?status=not_found');
    exit;
}

$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$price = $_POST['price'] ?? '';
$stock = $_POST['stock'] ?? '';
$category_id = isset($_POST['category_id']) ? (int) $_POST['category_id'] : 0;

if ($name === '' || $description === '' || $price === '' || $stock === '' || $category_id <= 0) {
    redirect_edit_product_error($product_id, 'يرجى تعبئة جميع الحقول المطلوبة.');
}

try {
    $product_stmt = $conn->prepare("SELECT product_id FROM products WHERE product_id = :product_id");
    $product_stmt->execute([':product_id' => $product_id]);

    if (!$product_stmt->fetch(PDO::FETCH_OBJ)) {
        header('Location: ' . APPURL . 'admin_products.php?status=not_found');
        exit;
    }

    $image_url = upload_product_image_if_selected($product_id);

    $product = [
        'product_id' => $product_id,
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'stock_quantity' => $stock,
        'category_id' => $category_id,
    ];

    if ($image_url) {
        $product['image_url'] = $image_url;
        $query = "
            UPDATE products
            SET name = :name,
                description = :description,
                price = :price,
                stock_quantity = :stock_quantity,
                category_id = :category_id,
                image_url = :image_url
            WHERE product_id = :product_id
        ";
    } else {
        $query = "
            UPDATE products
            SET name = :name,
                description = :description,
                price = :price,
                stock_quantity = :stock_quantity,
                category_id = :category_id
            WHERE product_id = :product_id
        ";
    }

    $result = $conn->prepare($query)->execute($product);

    header('Location: ' . APPURL . 'admin_products.php?status=' . ($result ? 'updated' : 'update_error'));
    exit;
} catch (Exception $e) {
    redirect_edit_product_error($product_id, 'حدث خطأ أثناء تعديل المنتج.');
}
