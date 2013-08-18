<?php
/**
 * Configuration file of PHPReport Yii extension.
 * 
 * @author K'iin Balam <kbalam@upnfm.edu.hn>
 */

return array(
    'pdfRenderer' => 'tcpdf',//or 'dompdf', 'tcpdf'
    'pdfRendererPath' => 'application.vendors.tcpdf',
    'templatePath' => 'application.views.reports'
);