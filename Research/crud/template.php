<?php
$filename = "research_template.csv";
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen('php://output', 'w');
fputcsv($output, ['research_date', 'research_title', 'co_authors', 'email_address', 'campus', 'college', 'date_started', 'target_completion_date', 'research_status', 'description_abstract', 'research_agenda', 'sdg_goals', 'publication_status']);

// Add 10 mock rows
$mockResearches = [
    ['2024-05-14', 'Solar Energy Efficiency in Rural Areas', 'Maria Dela Cruz', 'maria.dc@univ.edu.ph', 'Main Campus', 'College of Engineering', '2024-01-10', '2024-12-20', 'PROPOSAL', 'Study on solar panels.', 'Energy', 'Clean Energy', 'NOT SUBMITTED'],
    ['2024-05-14', 'AI-Driven Crop Monitoring System', 'Juan Ramos', 'juan.ramos@univ.edu.ph', 'San Isidro Campus', 'College of Agriculture', '2024-02-15', '2025-02-15', 'ONGOING', 'Smart farming using AI.', 'Agriculture', 'Zero Hunger', 'NOT SUBMITTED'],
    ['2024-05-14', 'Impact of Online Learning on Mental Health', 'Elena Torres', 'elena.t@univ.edu.ph', 'Main Campus', 'College of Arts', '2023-11-05', '2024-11-05', 'PROPOSAL', 'Mental health study.', 'Health', 'Good Health', 'NOT SUBMITTED'],
    ['2024-05-14', 'Blockchain for Secure Student Records', 'Ricardo Fernandez', 'carding@univ.edu.ph', 'San Isidro Campus', 'College of ICT', '2024-03-01', '2025-03-01', 'PROPOSAL', 'Secure data storage.', 'IT', 'Innovation', 'NOT SUBMITTED'],
    ['2024-05-14', 'Sustainable Urban Architecture', 'Sofia Reyes', 'sofia.reyes@univ.edu.ph', 'Main Campus', 'College of Engineering', '2023-08-10', '2024-08-10', 'ONGOING', 'Green buildings.', 'Environment', 'Sustainable Cities', 'NOT SUBMITTED'],
    ['2024-05-14', 'Linguistic Evolution in Philippine Dialects', 'Antonio Contreras', 'antonio.c@univ.edu.ph', 'San Isidro Campus', 'College of Arts', '2024-01-20', '2024-12-20', 'PROPOSAL', 'Language study.', 'Social Science', 'Quality Education', 'NOT SUBMITTED'],
    ['2024-05-14', 'E-Commerce Trends Post-Pandemic', 'Liza Mendoza', 'liza.m@univ.edu.ph', 'Main Campus', 'College of Business', '2024-04-10', '2025-04-10', 'ONGOING', 'Business trends.', 'Business', 'Decent Work', 'NOT SUBMITTED'],
    ['2024-05-14', 'Climate Change Resilience in Coastal Cities', 'Gabriel Santos', 'gab.santos@univ.edu.ph', 'San Isidro Campus', 'College of Engineering', '2023-12-01', '2024-12-01', 'PROPOSAL', 'Coastal protection.', 'Environment', 'Climate Action', 'NOT SUBMITTED'],
    ['2024-05-14', 'Next-Gen Battery Technology', 'Victoria Bautista', 'vicky.b@univ.edu.ph', 'Main Campus', 'College of Engineering', '2024-05-01', '2025-05-01', 'PROPOSAL', 'Battery innovation.', 'Technology', 'Innovation', 'NOT SUBMITTED'],
    ['2024-05-14', 'Ethical Implications of Gene Editing', 'Manuel Quezon', 'mlq@univ.edu.ph', 'San Isidro Campus', 'College of Arts', '2024-02-14', '2025-02-14', 'ONGOING', 'Ethics of CRISPR.', 'Science', 'Good Health', 'NOT SUBMITTED']
];

foreach ($mockResearches as $row) {
    fputcsv($output, $row);
}

fclose($output);
exit;
