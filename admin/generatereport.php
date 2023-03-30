<?php
require('fpdf.php');

// Connect to the database
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'car_booking_system';
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to fetch yearly report
$query = "SELECT 
            YEAR(pickup_date) AS year, 
            COUNT(id) AS total_bookings, 
            SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) AS completed_bookings,
            SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) AS cancelled_bookings,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending_bookings,
            SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) AS rejected_bookings,
            SUM(CASE WHEN status = 'expired' THEN 1 ELSE 0 END) AS expired_bookings
         FROM bookings
         GROUP BY YEAR(pickup_date)";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Create PDF object
    $pdf = new FPDF();
    $pdf->AddPage();

    // Add table headers
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(30, 10, 'Year', 1);
    $pdf->Cell(40, 10, 'Total Bookings', 1);
    $pdf->Cell(40, 10, 'Completed Bookings', 1);
    $pdf->Cell(40, 10, 'Cancelled Bookings', 1);
    $pdf->Cell(40, 10, 'Pending Bookings', 1);
    $pdf->Cell(40, 10, 'Rejected Bookings', 1);
    $pdf->Cell(40, 10, 'Expired Bookings', 1);
    $pdf->Ln();

    // Add table rows
    $pdf->SetFont('Arial', '', 12);
    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(30, 10, $row['year'], 1);
        $pdf->Cell(40, 10, $row['total_bookings'], 1);
        $pdf->Cell(40, 10, $row['completed_bookings'], 1);
        $pdf->Cell(40, 10, $row['cancelled_bookings'], 1);
        $pdf->Cell(40, 10, $row['pending_bookings'], 1);
        $pdf->Cell(40, 10, $row['rejected_bookings'], 1);
        $pdf->Cell(40, 10, $row['expired_bookings'], 1);
        $pdf->Ln();
    }

    // Output the PDF file
    $pdf->Output('yearly_report.pdf', 'D');
} else {
    echo "No data found";
}

// Close database connection
mysqli_close($conn);
?>
