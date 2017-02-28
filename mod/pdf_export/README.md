= PDF Export

Generates a PDF from Elgg content or arbitrary HTML


== Installation

Settings
 * Elgg content types that are eligible for PDF export : adds a PDF export button
 * Add generic header to PDF document (page URL, title, etc.)



== Web API
 * Endpoint URL : {SITE_URL}/pdfexport/pdf
 * HTML content mode : 
    * POST request to: {SITE_URL}/pdfexport/pdf
    * Parameter: export_html => URL of HTML content to be rendered
 * GUID mode :
    * GET or POST request to POST request to: {SITE_URL}/pdfexport/pdf/{GUID} (or {SITE_URL}/pdfexport/pdf + guid parameter)
    * Parameters :
      - guid : Elgg entity that should be exported as PDF
      - generator: used library is 'mpdf' ; options = mpdf|dompdf|html2fpdf|cpdf|tcpdf ; fallback to tcpdf if non-existing option
      - debug: if set, will display debugging information (blocks PDF export and displays text debug info instead)
      - embed: not used yet


