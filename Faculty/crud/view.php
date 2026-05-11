<?php
include "../config/Faculty.php";

if (isset($_GET['id'])) {
    $row = $faculty->view($_GET['id']);
}

if (!$row) {
    header("Location: ../index.php");
    exit;
}

$fullName = htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $fullName ?> Profile</title>
    <?php include "../config/libraries.php"; ?>
    <style>
        .profile-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .placeholder-img {
            width: 120px;
            height: 120px;
            background-color: #e9ecef;
            color: #adb5bd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-light">
    <!-- Global Nav -->
    <div class="card text-center mb-4 border-0 shadow-sm">
      <div class="card-header bg-white border-bottom">
        <ul class="nav nav-tabs card-header-tabs px-3">
          <li class="nav-item">
            <a class="nav-link text-primary" href="/crud/dashboard.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active fw-bold" href="../index.php">Faculty Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-primary" href="/crud/Research/index.php">Research Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-primary" href="../forms.php">Downloadable Forms</a>
          </li>
        </ul>
      </div>
    </div>

    <!-- Main Container -->
    <div class="container-fluid py-3">
        
        <!-- Profile Header (Centered Name & Email) -->
        <div class="text-center mb-5">
            <div class="mb-3 d-flex justify-content-center">
                <?php if (!empty($row['image'])): ?>
                    <img src="../../pics/<?= htmlspecialchars($row['image']) ?>" alt="Profile" class="profile-img">
                <?php else: ?>
                    <div class="placeholder-img">
                        <?= strtoupper(substr($row['first_name'], 0, 1)) ?>
                    </div>
                <?php endif; ?>
            </div>
            <h2 class="fw-bold mb-1"><?= $fullName ?></h2>
            <p class="text-muted">Email: <?= htmlspecialchars($row['first_name'] . '.' . $row['last_name']) ?>@example.com</p>
        </div>

        <!-- Main Content Card -->
        <div class="container border bg-white rounded shadow-sm p-0">
            <!-- Action Toolbar (Edit/Delete) -->
            <div class="border-bottom p-3 bg-light d-flex gap-2">
                <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm fw-bold px-3">Edit</a>
                <form method="POST" action="delete.php" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                    <input type="hidden" name="delete" value="<?= $row['id'] ?>">
                    <button type="submit" class="btn btn-danger btn-sm fw-bold px-3">Delete</button>
                </form>
            </div>

            <!-- Detailed Information Grid -->
            <div class="p-4 p-md-5">
                <div class="row g-4">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <span class="fw-bold">Employee No:</span> 
                            <span><?= htmlspecialchars($row['employee_no']) ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="fw-bold">Email:</span> 
                            <span class="text-primary text-lowercase"><?= htmlspecialchars($row['first_name'] . '.' . $row['last_name']) ?>@example.com</span>
                        </div>
                        <div class="mb-3">
                            <span class="fw-bold">Gender:</span> 
                            <span><?= htmlspecialchars($row['gender']) ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="fw-bold">Birthday:</span> 
                            <span><?= htmlspecialchars($row['birthday']) ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="fw-bold">Academic Rank:</span> 
                            <span><?= htmlspecialchars($row['academic_rank']) ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="fw-bold">Contact Number:</span> 
                            <span><?= htmlspecialchars($row['contact_number']) ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="fw-bold">City/Municipality:</span> 
                            <span><?= htmlspecialchars($row['city_municipality']) ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="fw-bold">Province:</span> 
                            <span><?= htmlspecialchars($row['province']) ?></span>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <span class="fw-bold">Discipline:</span> 
                            <span><?= htmlspecialchars($row['discipline']) ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="fw-bold">Campus:</span> 
                            <span><?= htmlspecialchars($row['campus']) ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="fw-bold">College:</span> 
                            <span><?= htmlspecialchars($row['college']) ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="fw-bold">Google Scholar ID:</span> 
                            <span class="text-muted"><?= $row['google_scholar_id'] ?: '' ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="fw-bold">Research Gate ID:</span> 
                            <span class="text-muted"><?= $row['research_gate_id'] ?: '' ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="fw-bold">Scopus ID:</span> 
                            <span class="text-muted"><?= $row['scopus_id'] ?: '' ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="fw-bold">Web of Science ID:</span> 
                            <span class="text-muted"><?= $row['web_of_science_id'] ?: '' ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="fw-bold">Date Created:</span> 
                            <span><?= htmlspecialchars($row['date_created']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>