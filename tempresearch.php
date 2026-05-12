<?php
// This file is included in Research/index.php
// It displays the pending applications from the temp_research table

$tempData = $research->getTempAll();
?>

<div class="container-fluid px-4 mt-5">
    <h2 class="mb-4 text-secondary">Pending Research Applications</h2>
    
    <div class="table-responsive">
        <table id="pendingTable" class="table table-hover table-bordered w-100 bg-white shadow-sm">
            <thead class="table-warning">
                <tr>
                    <th>Date</th>
                    <th>Research Title</th>
                    <th>Campus</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tempData as $row): ?>
                    <tr>
                        <td><?= date('M d, Y', strtotime($row['research_date'])) ?></td>
                        <td><?= strtoupper($row['research_title']) ?></td>
                        <td><?= strtoupper($row['campus']) ?></td>
                        <td><span class="badge bg-warning text-dark">PENDING</span></td>
                        <td class="text-end">
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="accept_id" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn btn-success btn-sm">Accept</button>
                            </form>
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="decline_id" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Decline</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable('#pendingTable')) {
            $('#pendingTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'excel', className: 'btn btn-success btn-sm', text: 'Export to Excel' },
                    { extend: 'pdf', className: 'btn btn-danger btn-sm', text: 'Export to PDF' }
                ],
                "order": [[0, "desc"]],
                "pageLength": 10
            });
        }
    });
</script>