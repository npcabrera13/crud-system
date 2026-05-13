<?php
// ROMIS System Process Flow - Revamped Professional Version
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Revamped System Process Flow - ROMIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/mermaid/dist/mermaid.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        :root {
            --primary-dark: #2c3e50;
            --accent-blue: #3498db;
            --success-green: #27ae60;
            --warning-orange: #f39c12;
            --danger-red: #e74c3c;
            --purple-decision: #9b59b6;

            /* Dashboard Card Colors */
            --db-purple: #9C27B0;
            --db-blue: #2196F3;
            --db-green: #27ae60;
            --db-red: #e74c3c;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .export-container {
            background: white;
            padding: 50px;
            border-radius: 0;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            margin: 40px auto;
            max-width: 1100px;
            border: 1px solid #ddd;
        }

        #capture-area {
            padding: 10px;
            background: white;
        }

        .legend-section {
            margin-top: 50px;
            padding: 25px;
            background: #ffffff;
            border: 1px solid #eee;
            border-radius: 8px;
        }

        .legend-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: center;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #555;
        }

        .shape {
            width: 60px;
            height: 30px;
            border: 1.5px solid #333;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.6rem;
            border-radius: 4px;
        }

        .ent-shape {
            background: #d4edda;
            border-color: #28a745;
        }

        .proc-shape {
            background: #cce5ff;
            border-color: #007bff;
        }

        .db-shape {
            border-radius: 20px;
            background: #fff3cd;
            border-color: #ffc107;
        }

        .dec-shape {
            transform: rotate(45deg);
            width: 25px;
            height: 25px;
            background: #f3e5f5;
            border-color: #9b59b6;
            margin: 5px;
        }

        .email-line {
            border-top: 2px dashed #f39c12;
            width: 40px;
        }

        .btn-download {
            background: #2c3e50;
            color: white;
            border: none;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-download:hover {
            background: #000;
            transform: translateY(-3px);
            color: white;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="container text-center mt-5 no-print">
        <button class="btn btn-download" onclick="exportToWord()">
            <i class="bi bi-file-earmark-word"></i> DOWNLOAD SYSTEM FLOW (.DOCX)
        </button>
        <p class="mt-3 text-muted small">High-resolution landscape export for final documentation</p>
    </div>

    <div class="export-container shadow">
        <div id="capture-area">
            <div class="mermaid">
                graph TD
                %% Define Styles
                classDef external fill:#d4edda,stroke:#28a745,stroke-width:2px;
                classDef process fill:#cce5ff,stroke:#007bff,stroke-width:2px;
                classDef datastore fill:#fff3cd,stroke:#ffc107,stroke-width:2px;
                classDef decision fill:#f3e5f5,stroke:#9b59b6,stroke-width:2px;
                classDef email stroke:#f39c12,stroke-width:2px,stroke-dasharray: 5 5;

                %% Status Card Styles
                classDef sProposal fill:#9C27B0,color:#fff,stroke:none;
                classDef sOngoing fill:#2196F3,color:#fff,stroke:none;
                classDef sCompleted fill:#27ae60,color:#fff,stroke:none;
                classDef sPublished fill:#e74c3c,color:#fff,stroke:none;

                %% External Entity
                ENTITY[<b>External Entity:</b> Researcher]:::external

                %% Submission Process
                ENTITY -- Submits Research --> FORM[<b>Process:</b> Form Submission]:::process
                FORM -- "Selects Status (Proposal/Ongoing/etc)" --> PENDING_DB[(<b>Data Store:</b> Pending
                DB)]:::datastore

                %% Email 1
                FORM -.-> EMAIL1(<b>Email:</b> Submission Confirmation):::email

                %% Admin Action
                PENDING_DB -- Awaits Admin --> REVIEW{<b>Decision:</b> Admin Review}:::decision

                %% Accept Path
                REVIEW -- "Action: Accept" --> ACCEPT_EMAIL[<b>Process:</b> Send Acceptance Email]:::process
                ACCEPT_EMAIL -.-> EMAIL2(<b>Email:</b> Proposal Accepted):::email
                ACCEPT_EMAIL --> MAIN_DB[(<b>Data Store:</b> Main DB)]:::datastore

                %% Decline Path
                REVIEW -- "Action: Decline" --> DECLINE_EMAIL[<b>Process:</b> Send Rejection Email]:::process
                DECLINE_EMAIL -.-> EMAIL3(<b>Email:</b> Proposal Declined):::email
                DECLINE_EMAIL --> DELETE_TEMP[<b>Process:</b> Delete from Pending DB]:::process

                %% Dashboard Dashboard State
                subgraph "DASHBOARD REAL-TIME METRICS"
                D1[<b>PROPOSAL</b>]:::sProposal
                D2[<b>ONGOING</b>]:::sOngoing
                D3[<b>COMPLETED</b>]:::sCompleted
                D4[<b>PUBLISHED</b>]:::sPublished
                end

                MAIN_DB -- "Update Status" --> D1
                D1 -- Progress --> D2
                D2 -- Finalize --> D3
                D3 -- Release --> D4

                %% Faculty subgraph
                subgraph "Faculty Lifecycle"
                FAC_ADD[<b>Process:</b> Admin Adds Faculty]:::process -.-> EMAIL4(<b>Email:</b> Profile Created):::email
                FAC_EDIT[<b>Process:</b> Admin Edits Faculty]:::process -.-> EMAIL5(<b>Email:</b> Profile
                Updated):::email
                FAC_DEL[<b>Process:</b> Admin Deletes Faculty]:::process -.-> EMAIL6(<b>Email:</b> Profile
                Removed):::email
                end

                %% Formatting
                linkStyle 2 stroke:#007bff,stroke-width:2px;
                linkStyle 3 stroke:#f39c12,stroke-width:2px;
            </div>

            <div class="legend-section">
                <h5 class="text-center fw-bold mb-4"
                    style="color:#2c3e50; text-transform:uppercase; letter-spacing:1px;">Documentation Legend</h5>
                <div class="legend-grid">
                    <div class="legend-item">
                        <div class="shape ent-shape">ENTITY</div> External Entity
                    </div>
                    <div class="legend-item">
                        <div class="shape proc-shape">PROCESS</div> System Process
                    </div>
                    <div class="legend-item">
                        <div class="shape db-shape">DATA</div> Data Store (DB)
                    </div>
                    <div class="legend-item">
                        <div class="shape dec-shape"></div> Decision Point
                    </div>
                    <div class="legend-item">
                        <div class="email-line"></div> Notification Trigger
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top text-center">
                    <p class="mb-0 text-muted small"><i>This diagram illustrates the automated workflow, the 8 email
                            triggers, and the dashboard status lifecycle.</i></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        mermaid.initialize({
            startOnLoad: true,
            theme: 'base',
            themeVariables: {
                fontFamily: 'Segoe UI',
                fontSize: '14px',
                primaryColor: '#cce5ff',
                primaryTextColor: '#004085',
                primaryBorderColor: '#007bff',
                lineColor: '#555',
                secondaryColor: '#d4edda',
                tertiaryColor: '#fff3cd'
            }
        });

        async function exportToWord() {
            const area = document.getElementById('capture-area');

            // Capture with scale 3 for ultra-crisp resolution in Word
            const canvas = await html2canvas(area, {
                scale: 3,
                useCORS: true,
                logging: false,
                backgroundColor: '#ffffff'
            });
            const imgData = canvas.toDataURL('image/png');

            const content = `
            <html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
            <head>
                <xml>
                    <w:WordDocument>
                        <w:View>Print</w:View>
                        <w:Zoom>100</w:Zoom>
                        <w:DoNotOptimizeForBrowser/>
                    </w:WordDocument>
                </xml>
                <style>
                    @page Section1 {
                        size: 841.9pt 595.3pt; 
                        mso-page-orientation: landscape;
                        margin: 0.5in 0.5in 0.5in 0.5in;
                    }
                    div.Section1 { page: Section1; }
                    img { width: 100%; max-width: 9.5in; }
                </style>
            </head>
            <body>
                <div class="Section1">
                    <div style="text-align:center;">
                        <img src="${imgData}" />
                    </div>
                </div>
            </body>
            </html>
        `;

            const blob = new Blob(['\ufeff', content], { type: 'application/msword' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'ROMIS_Final_Flow.doc';
            link.click();
        }
    </script>

</body>

</html>