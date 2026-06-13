<?php
require_once '../config/config.php';
require_once '../includes/middleware/check-admin.php';

function redirect_product_form_error(string $message): void
{
    $_SESSION['product_form_error'] = $message;
    header('Location: ' . APPURL . 'admin_product_form.php');
    exit;
}

function upload_product_image(): string
{
    if (!isset($_FILES['prodect_image']) || $_FILES['prodect_image']['error'] === UPLOAD_ERR_NO_FILE) {
        redirect_product_form_error('يرجى اختيار صورة المنتج.');
    }

    if ($_FILES['prodect_image']['error'] !== UPLOAD_ERR_OK) {
        redirect_product_form_error('حدث خطأ أثناء رفع الصورة.');
    }

    $target_dir = dirname(__DIR__) . '/assets/uploads/images/';

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $image_file_type = strtolower(pathinfo($_FILES['prodect_image']['name'], PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($image_file_type, $allowed_types, true)) {
        redirect_product_form_error('نوع الصورة غير مدعوم.');
    }

    if ($_FILES['prodect_image']['size'] > 1000000) {
        redirect_product_form_error('حجم الصورة يجب أن لا يتجاوز 1MB.');
    }

    if (getimagesize($_FILES['prodect_image']['tmp_name']) === false) {
        redirect_product_form_error('الملف المرفوع ليس صورة صالحة.');
    }

    $unique_name = uniqid('product_', true) . '.' . $image_file_type;
    $target_file = $target_dir . $unique_name;

    if (!move_uploaded_file($_FILES['prodect_image']['tmp_name'], $target_file)) {
        redirect_product_form_error('حدث خطأ أثناء حفظ الصورة.');
    }

    return APPURL . 'assets/uploads/images/' . $unique_name;
}

if (!isset($_POST['saveProductBtn'])) {
    header('Location: ' . APPURL . 'admin_products.php');
    exit;
}

$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$price = $_POST['price'] ?? '';
$stock = $_POST['stock'] ?? '';
$category_id = isset($_POST['category_id']) ? (int) $_POST['category_id'] : 0;

if ($name === '' || $description === '' || $price === '' || $stock === '' || $category_id <= 0) {
    redirect_product_form_error('يرجى تعبئة جميع الحقول المطلوبة.');
}

try {
    $image_url = upload_product_image();

    $product = [
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'stock_quantity' => $stock,
        'category_id' => $category_id,
        'image_url' => $image_url,
    ];

    $result = $conn->prepare("
        INSERT INTO products (name, description, price, stock_quantity, category_id, image_url)
        VALUES (:name, :description, :price, :stock_quantity, :category_id, :image_url)
    ")->execute($product);

    if ($result) {
        setFlash('تم إضافة المنتج بنجاح', 'success');
    } else {
        setFlash('حدث خطأ أثناء إضافة المنتج.', 'error');
    }
    header('Location: ' . APPURL . 'admin_products.php');
    exit;
} catch (Exception $e) {
    redirect_product_form_error('حدث خطأ أثناء إضافة المنتج.');
}
