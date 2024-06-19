<?php 
session_start();
ob_start();
require_once __DIR__ . '/..//vendor/autoload.php';

if (isset($_SESSION['names']) && isset($_SESSION['quant']) && isset($_SESSION['totals'])) {
    $names = $_SESSION['names'];
    $quant = $_SESSION['quant'];
    $totals = $_SESSION['totals'];
} else {
    echo "Session data not found. <script>window.location.href = 'dashboard.php';</script>" ;
}
?>

   <!DOCTYPE html>
   <html lang="en">
   <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   </head>
   <body>
    
   </body>
   </html>
   <?php
// Start the session

// Retrieve session data


    // Now you can use $names, $quant, and $totals as arrays containing session data
    // Example usage:
    $dati = date('Y-m-d H:i:s');
    $totalP = 0;
    // Initialize TCPDF
    ob_end_clean();
    $pdf = new TCPDF();
    // Set document information
    $pdf->SetCreator('Roland');
    $pdf->SetAuthor('Lopez');
    $pdf->SetTitle('Transaction Receipt');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Generate receipt content
    $receiptContent = '<h1>Transaction Receipt</h1>';
    $receiptContent .= '<p>Date: ' . date('Y-m-d H:i:s') . '</p>';
    $receiptContent .= '<table border="1">
                        <tr>
                            <th>Medicine Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>';

    for ($i = 0; $i < count($names); $i++) {
        $receiptContent .= '<tr>';
        $receiptContent .= '<td>' . $names[$i] . '</td>';
        $receiptContent .= '<td>' . $quant[$i] . '</td>';
        $receiptContent .= '<td>' . $totals[$i] . '</td>';
        $receiptContent .= '</tr>';

        $totalP += $totals[$i];
    }

    $receiptContent .= '</table>';

    $receiptContent .= ' <br><p>Total Price:'. $totalP .'</p>';

    // Output receipt content to PDF
    $pdf->writeHTML($receiptContent, true, false, true, false, '');

    // Close and output PDF document
    $pdf->Output('receipt '.$dati.'.pdf', 'D');

    // End output buffering and send content to the browser
    // ob_end_flush();
    $_SESSION['names'] = "";
    $_SESSION['quant'] = "";
   $_SESSION['totals'] = "";

?>
   