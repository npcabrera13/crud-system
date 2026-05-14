<?php
$filename = "faculty_template.csv";
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen('php://output', 'w');
fputcsv($output, ['first_name', 'middle_name', 'last_name', 'email_address', 'employee_no', 'academic_rank', 'date_created', 'gender', 'birthday', 'contact_number', 'city_municipality', 'province', 'discipline', 'campus', 'college', 'google_scholar_id', 'research_gate_id', 'scopus_id', 'web_of_science_id']);

// Add 10 mock rows
$mockFaculties = [
    ['Maria', 'Santos', 'Dela Cruz', 'maria.dc@univ.edu.ph', 'EMP-2024-001', 'Professor', '2024-05-14', 'Female', '1975-03-12', '09123456789', 'Main City', 'Province Name', 'Computer Science', 'Main Campus', 'College of Engineering', 'GS-123', 'RG-456', 'SC-789', 'WS-012'],
    ['Juan', 'Luna', 'Ramos', 'juan.ramos@univ.edu.ph', 'EMP-2024-002', 'Associate Professor', '2024-05-14', 'Male', '1982-07-25', '09223334455', 'East City', 'Province Name', 'Mechanical Eng', 'San Isidro Campus', 'College of Engineering', 'GS-124', 'RG-457', 'SC-790', 'WS-013'],
    ['Elena', 'Grace', 'Torres', 'elena.t@univ.edu.ph', 'EMP-2024-003', 'Assistant Professor', '2024-05-14', 'Female', '1990-11-05', '09334445566', 'West City', 'Province Name', 'Business Admin', 'Main Campus', 'College of Business', 'GS-125', 'RG-458', 'SC-791', 'WS-014'],
    ['Ricardo', 'Dalisay', 'Fernandez', 'carding@univ.edu.ph', 'EMP-2024-004', 'Instructor', '2024-05-14', 'Male', '1995-01-30', '09445556677', 'South City', 'Province Name', 'Information Tech', 'San Isidro Campus', 'College of ICT', 'GS-126', 'RG-459', 'SC-792', 'WS-015'],
    ['Sofia', 'Isabelle', 'Reyes', 'sofia.reyes@univ.edu.ph', 'EMP-2024-005', 'Professor', '2024-05-14', 'Female', '1970-05-15', '09556667788', 'North City', 'Province Name', 'Architecture', 'Main Campus', 'College of Engineering', 'GS-127', 'RG-460', 'SC-793', 'WS-016'],
    ['Antonio', 'P.', 'Contreras', 'antonio.c@univ.edu.ph', 'EMP-2024-006', 'Assistant Professor', '2024-05-14', 'Male', '1988-09-20', '09667778899', 'Main City', 'Province Name', 'Political Science', 'San Isidro Campus', 'College of Arts', 'GS-128', 'RG-461', 'SC-794', 'WS-017'],
    ['Liza', 'S.', 'Mendoza', 'liza.m@univ.edu.ph', 'EMP-2024-007', 'Instructor', '2024-05-14', 'Female', '1992-04-10', '09778889900', 'West City', 'Province Name', 'Cyber Security', 'Main Campus', 'College of ICT', 'GS-129', 'RG-462', 'SC-795', 'WS-018'],
    ['Gabriel', 'M.', 'Santos', 'gab.santos@univ.edu.ph', 'EMP-2024-008', 'Associate Professor', '2024-05-14', 'Male', '1980-12-01', '09889990011', 'East City', 'Province Name', 'Finance', 'San Isidro Campus', 'College of Business', 'GS-130', 'RG-463', 'SC-796', 'WS-019'],
    ['Victoria', 'A.', 'Bautista', 'vicky.b@univ.edu.ph', 'EMP-2024-009', 'Professor', '2024-05-14', 'Female', '1972-08-18', '09990001122', 'North City', 'Province Name', 'Civil Eng', 'Main Campus', 'College of Engineering', 'GS-131', 'RG-464', 'SC-797', 'WS-020'],
    ['Manuel', 'L.', 'Quezon', 'mlq@univ.edu.ph', 'EMP-2024-010', 'Instructor', '2024-05-14', 'Male', '1994-02-14', '09112223344', 'South City', 'Province Name', 'History', 'San Isidro Campus', 'College of Arts', 'GS-132', 'RG-465', 'SC-798', 'WS-021']
];

foreach ($mockFaculties as $row) {
    fputcsv($output, $row);
}
fclose($output);
exit;
