<?php
require_once 'auth_check.php';

// Redirect to index if not POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Check if TCPDF autoloader exists
$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    die("Composer packages not installed. Please run composer install first.");
}
require_once $autoloadPath;

// Retrieve POST parameters
$clientRaw = $_POST['client_data'] ?? '{}';
$firmRaw = $_POST['firm_data'] ?? '{}';
$certType = $_POST['cert_type'] ?? 'Turnover Certificate';
$certDate = $_POST['cert_date'] ?? date('Y-m-d');
$place = $_POST['place'] ?? 'Ahmedabad';
$udin = $_POST['udin'] ?? '';
$templateStyle = $_POST['template_style'] ?? 'Classic Navy';

$client = json_decode($clientRaw, true);
$firm = json_decode($firmRaw, true);

// Utility: Number to Indian Rupees Words
function toIndianWords($num) {
    $num = (int)$num;
    if ($num === 0) return 'Zero';
    
    $words = array(
        0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
        5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
        14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen',
        17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen',
        20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty',
        60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
    );
    
    if ($num < 20) {
        return $words[$num];
    }
    if ($num < 100) {
        return $words[10 * floor($num / 10)] . ($num % 10 ? ' ' . $words[$num % 10] : '');
    }
    if ($num < 1000) {
        return $words[floor($num / 100)] . ' Hundred' . ($num % 100 ? ' and ' . toIndianWords($num % 100) : '');
    }
    if ($num < 100000) { // Under 1 Lakh
        return toIndianWords(floor($num / 1000)) . ' Thousand' . ($num % 1000 ? ' ' . toIndianWords($num % 1000) : '');
    }
    if ($num < 10000000) { // Under 1 Crore
        return toIndianWords(floor($num / 100000)) . ' Lakh' . ($num % 100000 ? ' ' . toIndianWords($num % 100000) : '');
    }
    return toIndianWords(floor($num / 10000000)) . ' Crore' . ($num % 10000000 ? ' ' . toIndianWords($num % 10000000) : '');
}

function amountInWords($value) {
    $amount = (float)$value;
    $integerPart = floor($amount);
    $fractionPart = round(($amount - $integerPart) * 100);
    
    $words = toIndianWords($integerPart) . ' Rupees';
    if ($fractionPart > 0) {
        $words .= ' and ' . toIndianWords($fractionPart) . ' Paise';
    }
    return $words . ' Only';
}

function formatDateDisplay($value) {
    $date = new DateTime($value);
    return $date->format('d-M-Y');
}

// Setup firm default values if missing
$firmName = !empty($firm['firmName']) ? $firm['firmName'] : '[CA Firm Name]';
$firmFrn = !empty($firm['frn']) ? $firm['frn'] : '[FRN]';
$signatory = !empty($firm['signatoryName']) ? $firm['signatoryName'] : '[Signatory Name]';
$signatoryStatus = !empty($firm['signatoryStatus']) ? $firm['signatoryStatus'] : 'Proprietor';
$membership = !empty($firm['membershipNumber']) ? $firm['membershipNumber'] : '[Membership No]';
$udinText = !empty($udin) ? $udin : (!empty($firm['udin']) ? $firm['udin'] : '[UDIN]');

// Template design styling properties
$primaryColor = '#1e3a8a'; // Classic Navy
$borderColor = '#1e3a8a';
$fontFamily = 'times';
$innerHtml = '';

if ($templateStyle === 'Modern Corporate') {
    $primaryColor = '#334155'; // Slate
    $borderColor = '#e2e8f0';
    $fontFamily = 'helvetica';
} elseif ($templateStyle === 'Elegant Gold') {
    $primaryColor = '#92400e'; // Gold/Amber
    $borderColor = '#d97706';
    $fontFamily = 'times';
}

// Generate the specific certificate section HTML
$clientName = !empty($client['name']) ? $client['name'] : '[Client Name]';
$clientStatus = !empty($client['status']) ? $client['status'] : 'Proprietor';
$clientPan = !empty($client['pan']) ? $client['pan'] : '[PAN]';
$clientGst = !empty($client['gst']) ? $client['gst'] : '';
$years = !empty($client['years']) ? $client['years'] : [];

$gstText = !empty($clientGst) ? " and GSTIN <strong>$clientGst</strong>" : "";

$introText = "We, <strong>$firmName</strong>, Chartered Accountants, have examined the books of accounts, financial statements, and other relevant records of <strong>$clientName</strong> ($clientStatus), having holding PAN <strong>$clientPan</strong>$gstText, and certify the following details:";

if ($certType === 'Turnover Certificate') {
    $rowsHtml = '';
    $totalTurnover = 0;
    foreach ($years as $y) {
        $amt = (float)$y['amount'];
        $totalTurnover += $amt;
        $formattedAmt = number_format($amt, 2, '.', ',');
        $inWords = amountInWords($amt);
        $rowsHtml .= "
        <tr>
            <td style=\"border:1px solid #d1d5db;padding:8px;\">{$y['year']}</td>
            <td style=\"border:1px solid #d1d5db;padding:8px;text-align:right;\">INR $formattedAmt</td>
            <td style=\"border:1px solid #d1d5db;padding:8px;\">$inWords</td>
        </tr>";
    }
    $avgTurnover = count($years) > 0 ? $totalTurnover / count($years) : 0;
    $formattedAvg = number_format($avgTurnover, 2, '.', ',');
    $avgWords = amountInWords($avgTurnover);

    $innerHtml = "
    <h3 style=\"text-align:center;color:$primaryColor;margin-bottom:15px;\">TURNOVER CERTIFICATE</h3>
    <p style=\"line-height:1.6;margin-bottom:15px;\">$introText</p>
    <table cellpadding=\"6\" cellspacing=\"0\" style=\"width:100%;margin-top:15px;margin-bottom:15px;\">
        <thead>
            <tr style=\"background-color:$primaryColor;color:#ffffff;font-weight:bold;\">
                <th style=\"border:1px solid #cbd5e1;width:25%;\">Financial Year</th>
                <th style=\"border:1px solid #cbd5e1;width:30%;text-align:right;\">Turnover Value (INR)</th>
                <th style=\"border:1px solid #cbd5e1;width:45%;\">Value in Words</th>
            </tr>
        </thead>
        <tbody>
            $rowsHtml
        </tbody>
    </table>
    <p style=\"line-height:1.6;\"><strong>Average Annual Turnover:</strong> The average annual turnover of the entity for the above-mentioned financial years is <strong>INR $formattedAvg</strong> (Rupees <strong>$avgWords</strong>).</p>
    <p style=\"line-height:1.6;margin-top:15px;\">The figures stated above are verified from the audited financial statements / books of accounts produced before us and are true and correct to the best of our knowledge and belief.</p>";

} elseif ($certType === 'Net Worth Certificate') {
    $paidUp = isset($years[0]['amount']) ? (float)$years[0]['amount'] : 0;
    $reserves = isset($years[1]['amount']) ? (float)$years[1]['amount'] : 0;
    $netWorth = $paidUp + $reserves;
    
    $formattedPaidUp = number_format($paidUp, 2, '.', ',');
    $formattedReserves = number_format($reserves, 2, '.', ',');
    $formattedNetWorth = number_format($netWorth, 2, '.', ',');
    
    $netWorthWords = amountInWords($netWorth);

    $innerHtml = "
    <h3 style=\"text-align:center;color:$primaryColor;margin-bottom:15px;\">NET WORTH CERTIFICATE</h3>
    <p style=\"line-height:1.6;margin-bottom:15px;\">$introText</p>
    <p style=\"line-height:1.6;\">Based on the audited financial statements as on <strong>" . formatDateDisplay($certDate) . "</strong>, the Net Worth of the entity is calculated as under:</p>
    <table cellpadding=\"8\" cellspacing=\"0\" style=\"width:100%;margin-top:15px;margin-bottom:15px;\">
        <thead>
            <tr style=\"background-color:$primaryColor;color:#ffffff;font-weight:bold;\">
                <th style=\"border:1px solid #cbd5e1;width:70%;\">Particulars</th>
                <th style=\"border:1px solid #cbd5e1;width:30%;text-align:right;\">Amount (INR)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style=\"border:1px solid #d1d5db;\">(A) Paid-up Share Capital / Owner's Capital</td>
                <td style=\"border:1px solid #d1d5db;text-align:right;\">INR $formattedPaidUp</td>
            </tr>
            <tr>
                <td style=\"border:1px solid #d1d5db;\">(B) Reserves & Surplus (Excluding Revaluation Reserves)</td>
                <td style=\"border:1px solid #d1d5db;text-align:right;\">INR $formattedReserves</td>
            </tr>
            <tr style=\"background-color:#f8fafc;font-weight:bold;\">
                <td style=\"border:1px solid #cbd5e1;\">Net Worth (A + B)</td>
                <td style=\"border:1px solid #cbd5e1;text-align:right;\">INR $formattedNetWorth</td>
            </tr>
        </tbody>
    </table>
    <p style=\"line-height:1.6;\">The Net Worth of <strong>$clientName</strong> as on <strong>" . formatDateDisplay($certDate) . "</strong> is <strong>INR $formattedNetWorth</strong> (Rupees <strong>$netWorthWords</strong>).</p>";

} elseif ($certType === 'Working Capital Certificate') {
    $currentAssets = isset($years[0]['amount']) ? (float)$years[0]['amount'] : 0;
    $currentLiabilities = isset($years[1]['amount']) ? (float)$years[1]['amount'] : 0;
    $workingCapital = $currentAssets - $currentLiabilities;
    
    $formattedAssets = number_format($currentAssets, 2, '.', ',');
    $formattedLiabilities = number_format($currentLiabilities, 2, '.', ',');
    $formattedCapital = number_format($workingCapital, 2, '.', ',');
    
    $capitalWords = amountInWords($workingCapital);

    $innerHtml = "
    <h3 style=\"text-align:center;color:$primaryColor;margin-bottom:15px;\">WORKING CAPITAL CERTIFICATE</h3>
    <p style=\"line-height:1.6;margin-bottom:15px;\">$introText</p>
    <p style=\"line-height:1.6;\">Based on the books of accounts as on <strong>" . formatDateDisplay($certDate) . "</strong>, the Working Capital position of the entity is certified below:</p>
    <table cellpadding=\"8\" cellspacing=\"0\" style=\"width:100%;margin-top:15px;margin-bottom:15px;\">
        <thead>
            <tr style=\"background-color:$primaryColor;color:#ffffff;font-weight:bold;\">
                <th style=\"border:1px solid #cbd5e1;width:70%;\">Particulars</th>
                <th style=\"border:1px solid #cbd5e1;width:30%;text-align:right;\">Amount (INR)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style=\"border:1px solid #d1d5db;\">(A) Current Assets (including Cash/Bank, Receivables, Stock)</td>
                <td style=\"border:1px solid #d1d5db;text-align:right;\">INR $formattedAssets</td>
            </tr>
            <tr>
                <td style=\"border:1px solid #d1d5db;\">(B) Current Liabilities & Provisions (including Payables, short term loans)</td>
                <td style=\"border:1px solid #d1d5db;text-align:right;\">INR $formattedLiabilities</td>
            </tr>
            <tr style=\"background-color:#f8fafc;font-weight:bold;\">
                <td style=\"border:1px solid #cbd5e1;\">Working Capital (A - B)</td>
                <td style=\"border:1px solid #cbd5e1;text-align:right;\">INR $formattedCapital</td>
            </tr>
        </tbody>
    </table>
    <p style=\"line-height:1.6;\">The Working Capital of <strong>$clientName</strong> as on <strong>" . formatDateDisplay($certDate) . "</strong> is <strong>INR $formattedCapital</strong> (Rupees <strong>$capitalWords</strong>).</p>";

} elseif ($certType === 'Existence Certificate') {
    $innerHtml = "
    <h3 style=\"text-align:center;color:$primaryColor;margin-bottom:15px;\">EXISTENCE & OPERATIONAL CERTIFICATE</h3>
    <p style=\"line-height:1.8;margin-bottom:15px;\">This is to certify that <strong>$clientName</strong>, a <strong>$clientStatus</strong> concern with PAN <strong>$clientPan</strong>$gstText, is active, operational, and in existence as on <strong>" . formatDateDisplay($certDate) . "</strong>.</p>
    <p style=\"line-height:1.8;\">We have verified the operational status based on the business certificates, regulatory filings, registration documents, and recent bank transactions of the entity presented before us.</p>
    <p style=\"line-height:1.8;margin-top:15px;\">This certificate is issued at the request of the client for submission to banks, financial institutions, or government authorities.</p>";

} elseif ($certType === 'Income Declaration Certificate') {
    $rowsHtml = '';
    $totalIncome = 0;
    foreach ($years as $y) {
        $amt = (float)$y['amount'];
        $totalIncome += $amt;
        $formattedAmt = number_format($amt, 2, '.', ',');
        $inWords = amountInWords($amt);
        $rowsHtml .= "
        <tr>
            <td style=\"border:1px solid #d1d5db;padding:8px;\">{$y['year']}</td>
            <td style=\"border:1px solid #d1d5db;padding:8px;text-align:right;\">INR $formattedAmt</td>
            <td style=\"border:1px solid #d1d5db;padding:8px;\">$inWords</td>
        </tr>";
    }
    $avgIncome = count($years) > 0 ? $totalIncome / count($years) : 0;
    $formattedAvg = number_format($avgIncome, 2, '.', ',');
    $avgWords = amountInWords($avgIncome);

    $innerHtml = "
    <h3 style=\"text-align:center;color:$primaryColor;margin-bottom:15px;\">INCOME DECLARATION CERTIFICATE</h3>
    <p style=\"line-height:1.6;margin-bottom:15px;\">$introText</p>
    <table cellpadding=\"6\" cellspacing=\"0\" style=\"width:100%;margin-top:15px;margin-bottom:15px;\">
        <thead>
            <tr style=\"background-color:$primaryColor;color:#ffffff;font-weight:bold;\">
                <th style=\"border:1px solid #cbd5e1;width:25%;\">Assessment Year / FY</th>
                <th style=\"border:1px solid #cbd5e1;width:30%;text-align:right;\">Gross Total Income (INR)</th>
                <th style=\"border:1px solid #cbd5e1;width:45%;\">Income in Words</th>
            </tr>
        </thead>
        <tbody>
            $rowsHtml
        </tbody>
    </table>
    <p style=\"line-height:1.6;\"><strong>Average Annual Income:</strong> The average gross annual income of the entity/individual for the above-mentioned years is <strong>INR $formattedAvg</strong> (Rupees <strong>$avgWords</strong>).</p>
    <p style=\"line-height:1.6;margin-top:15px;\">This income has been verified based on the Income Tax Returns (ITR Acknowledgement Forms) and verified computation sheets submitted to the Income Tax Department.</p>";
}

// HTML Structure wrapper based on Selected Template Style
$borderStyle = "";
if ($templateStyle === 'Classic Navy') {
    $borderStyle = "border: 4px double $primaryColor; padding: 25px;";
} elseif ($templateStyle === 'Elegant Gold') {
    $borderStyle = "border: 2px solid $borderColor; padding: 25px;";
} else {
    $borderStyle = "border: 1px solid $borderColor; padding: 25px;";
}

$html = "
<div style=\"$borderStyle\">
    <!-- CA Firm Letterhead -->
    <div style=\"text-align:center;margin-bottom:20px;border-bottom:1px solid #e2e8f0;padding-bottom:15px;\">
        <span style=\"font-size:16px;font-weight:bold;color:$primaryColor;text-transform:uppercase;\">$firmName</span><br>
        <span style=\"font-size:11px;color:#475569;font-weight:bold;\">CHARTERED ACCOUNTANTS</span><br>
        <span style=\"font-size:10px;color:#64748b;\">FRN: $firmFrn | Membership No: $membership</span>
    </div>

    <!-- Subtitle header -->
    <div style=\"text-align:center;margin-bottom:20px;\">
        <span style=\"font-size:11px;letter-spacing:2px;font-weight:bold;color:#475569;\">TO WHOMSOEVER IT MAY CONCERN</span>
    </div>

    <!-- Certificate Body -->
    <div style=\"font-size:11px;color:#0f172a;text-align:justify;\">
        $innerHtml
    </div>

    <!-- Footer Signing Block -->
    <div style=\"margin-top:35px;font-size:10px;\">
        <table cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%;border:none;\">
            <tr style=\"border:none;\">
                <td style=\"width:50%;border:none;line-height:1.6;\">
                    <strong>Date:</strong> " . formatDateDisplay($certDate) . "<br>
                    <strong>Place:</strong> $place<br>
                    <strong>UDIN:</strong> <span style=\"font-family:courier;\">$udinText</span>
                </td>
                <td style=\"width:50%;border:none;text-align:right;line-height:1.6;\">
                    For <strong>$firmName</strong><br>
                    Chartered Accountants<br><br><br><br>
                    <strong>$signatory</strong><br>
                    $signatoryStatus<br>
                    M. No: $membership
                </td>
            </tr>
        </table>
    </div>
</div>";

// Initialize TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set Document Meta
$pdf->SetCreator('CA Certificate Manager');
$pdf->SetAuthor($firmName);
$pdf->SetTitle($certType . ' - ' . $clientName);
$pdf->SetSubject($certType);

// Remove default headers & footers for custom layout
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Set Margins
$pdf->SetMargins(15, 15, 15);
$pdf->SetAutoPageBreak(true, 15);

// Set Fonts
$pdf->SetFont($fontFamily, '', 11);

// Add a page
$pdf->AddPage();

// Write HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Clean the buffer and output PDF
ob_end_clean();
$pdfName = str_replace(' ', '_', strtolower($certType . '_' . $clientName)) . '.pdf';
$pdf->Output($pdfName, 'I'); // Stream to browser window
exit;