<?php
// Get data from URL or set defaults
$patient = htmlspecialchars($_GET['patient'] ?? 'N/A');
$doctor = htmlspecialchars($_GET['doctor'] ?? 'N/A');
$medication = htmlspecialchars($_GET['medication'] ?? 'N/A');
$status = htmlspecialchars($_GET['status'] ?? 'N/A');
$date = htmlspecialchars($_GET['date'] ?? 'N/A');
$image = htmlspecialchars($_GET['image'] ?? 'default1.png');

// Prepare QR text (not a URL)
$qr_data = "Patient: $patient\nDoctor: $doctor\nMedication: $medication\nStatus: $status\nDate: $date";
$qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qr_data);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Patient Report - <?= $patient ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 40px;
        }

        .report-container {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .report-heading {
            text-align: center;
            margin-bottom: 40px;
            font-weight: bold;
            font-size: 28px;
        }

        .patient-img {
            width: 100%;
            max-width: 300px;
            height: auto;
            border-radius: 10px;
            border: 2px solid #6c757d;
        }

        .label {
            font-weight: bold;
            display: inline-block;
            width: 180px;
            color: #495057;
        }

        .print-btn {
            margin-top: 30px;
            text-align: center;
        }

        @media print {
            body {
                background-color: white;
                margin: 0;
                padding: 0;
                zoom: 125%;
            }

            .report-container {
                box-shadow: none;
                border: none;
                padding: 60px;
            }

            .report-heading {
                font-size: 34px;
            }

            .label {
                font-size: 20px;
                width: 220px;
            }

            .print-btn {
                display: none;
            }

            .patient-img {
                max-width: 350px;
            }

            body::before {
                content: "HealthyCare Clinic";
                position: fixed;
                top: 40%;
                left: 20%;
                font-size: 80px;
                color: rgba(200, 200, 200, 0.1);
                transform: rotate(-30deg);
                z-index: -1;
                white-space: nowrap;
            }
        }
    </style>
</head>

<body onload="window.print();">
    <div class="container">
        <div class="report-container mx-auto">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="text-primary mb-0">HealthyCare Clinic</h4>
                    <small class="text-muted">123 Health Street, Lahore — +92 300 1234567</small>
                </div>
                <div>
                    <img src="uploads/clinic-logo.png" alt="Clinic Logo" style="height: 70px;">
                </div>
            </div>

            <!-- Title -->
            <h2 class="report-heading">Patient Medication Report</h2>

            <!-- Patient Info -->
            <div class="row align-items-center">
                <div class="col-md-6 text-center mb-4 mb-md-0">
                    <img src="uploads/<?= $image ?>" alt="Patient Image" class="patient-img">
                </div>
                <div class="col-md-6">
                    <p><span class="label">Patient Name:</span> <?= $patient ?></p>
                    <p><span class="label">Doctor:</span> <?= $doctor ?></p>
                    <p><span class="label">Medication:</span> <?= $medication ?></p>
                    <p><span class="label">Status:</span>
                        <span class="badge bg-<?= strtolower($status) == 'active' ? 'success' : 'danger' ?>">
                            <?= ucfirst($status) ?>
                        </span>
                    </p>
                    <p><span class="label">Created Date:</span> <?= date("d M Y", strtotime($date)) ?></p>
                </div>
            </div>

            <!-- QR Code -->
            <div class="text-center mt-4">
                <img src="<?= $qr_url ?>" alt="QR Code">
                <p class="text-muted small">Scan to view this report summary</p>
            </div>

            <!-- Buttons -->
            <div class="print-btn">
                <a href="#" onclick="window.print()" class="btn btn-primary">Print Again</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>