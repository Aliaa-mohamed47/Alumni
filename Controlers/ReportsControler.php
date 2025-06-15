<?php
require_once '../../Controlers/DBControler.php';
require_once 'D:/xampp/htdocs/Alumni/Views/assets/vendor/TCPDF-main/tcpdf.php';

class ReportsControler {
    protected $dbController;

    public function __construct() {
        $this->dbController = new DBControler();
        $this->dbController->openConnection();
    }

    public function generateReports($reportType, $format) {
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('dejavusans', '', 10);
        $html = '';

        switch ($reportType) {
            case 'alumni':
                $html .= '<h2>Alumni Report</h2><table border="1" cellpadding="5">
                <tr><th>ID</th><th>Name</th><th>Email</th><th>Graduation Year</th><th>Department</th><th>Job Title</th><th>Company</th></tr>';
                $query = "SELECT id, name, email, graduation_year, department, job_title, company FROM alumnis";
                $result = $this->dbController->connection->query($query);
                while ($row = $result->fetch_assoc()) {
                    $html .= '<tr>
                                <td>' . $row['id'] . '</td>
                                <td>' . $row['name'] . '</td>
                                <td>' . $row['email'] . '</td>
                                <td>' . $row['graduation_year'] . '</td>
                                <td>' . $row['department'] . '</td>
                                <td>' . $row['job_title'] . '</td>
                                <td>' . $row['company'] . '</td>
                            </tr>';
                }
                $html .= '</table>';

                break;

            case 'events':
                $html .= '<h2>Events Report</h2><table border="1" cellpadding="5">
                        <tr><th>ID</th><th>Title</th><th>Description</th><th>Date</th><th>Location</th></tr>';
                $query = "SELECT * FROM events";
                $result = $this->dbController->connection->query($query);
                while ($row = $result->fetch_assoc()) {
                    $html .= '<tr>
                                <td>' . $row['id'] . '</td>
                                <td>' . $row['title'] . '</td>
                                <td>' . $row['description'] . '</td>
                                <td>' . $row['date'] . '</td>
                                <td>' . $row['location'] . '</td>
                            </tr>';
                }
                $html .= '</table>';
                break;

            case 'students':
                $html .= '<h2>Students Report</h2><table border="1" cellpadding="5">
                        <tr><th>ID</th><th>Name</th><th>Email</th><th>Sex</th><th>Level</th></tr>';
                $query = "SELECT * FROM students";
                $result = $this->dbController->connection->query($query);
                while ($row = $result->fetch_assoc()) {
                    $html .= '<tr>
                                <td>' . $row['id'] . '</td>
                                <td>' . $row['name'] . '</td>
                                <td>' . $row['email'] . '</td>
                                <td>' . $row['sex'] . '</td>
                                <td>' . $row['level'] . '</td>
                            </tr>';
                }
                $html .= '</table>';
                break;

            default:
                return false;
        }

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('report.pdf', 'D');
        return true;
    }
}
?>
