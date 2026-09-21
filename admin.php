<?php 

    // Report all PHP errors
    error_reporting(E_ALL);
    
    // Display errors on the screen
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
 
    require_once __DIR__ . '/db.php';  
    

    $messasge = "";
    $messageType = "";
    $results = array();


    $id = (isset($_GET['id']) ? $_GET['id']: NULL);
    
    // SELECT/GET RECORDS
    $tsql = "{call sp_select_neuromodulation (?)}"; 
    $params = array(
        array(NULL, SQLSRV_PARAM_IN)
    );

    $stmt = sqlsrv_prepare($conn, $tsql, $params);
    if ($stmt && sqlsrv_execute($stmt)) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            if ($row['submission_date'] instanceof DateTime) {
                $row['submission_date'] = $row['submission_date']->format('d/m/Y');
            }
            if ($row['birth_date'] instanceof DateTime) {
                $row['birth_date'] = $row['birth_date']->format('d/m/Y');
            }
            $results[] = $row;
        }
    } else {
        $message = "Error Submitting Form: " . print_r(sqlsrv_errors(), true);
        $messageType = "danger";
    }

    // DELETE RECORD
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $action = $_GET['action'] ?? '';

        if ($action === 'delete') {

            $tsql = "{call sp_delete_neuromodulation (?)}";
            $params = array(
                array($id, SQLSRV_PARAM_IN)
            );

            $stmt = sqlsrv_prepare($conn, $tsql, $params);
            if ($stmt && sqlsrv_execute($stmt)) {
                $message = "Form Successfully Deleted.";
                $messageType = "success";
            } else {
                $message = "Error Deleting Form: " . print_r(sqlsrv_errors(), true);
                $messageType = "danger";
            }
            
        }
    } else {
        echo $_SERVER['REQUEST_METHOD'];
    }
?>


<html>
     <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Neuromodulation</title>

        <script src="https://code.jquery.com/jquery-4.0.0.slim.js" integrity="sha256-M+GjhMBfXikM1izMplICCTscIj5hzPCp6uDzaypxtgg=" crossorigin="anonymous"></script>
        <link href="https://cdn.datatables.net/v/dt/dt-3.0.4/datatables.min.css" rel="stylesheet">
        <script src="https://cdn.datatables.net/v/dt/dt-3.0.4/datatables.min.js" ></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/7ffc81d928.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <?php include_once "header.php" ?>
        <div class="container-fluid">
            <?php if(!empty($message)) { ?>
                <div class="row align-items-start pt-3">
                    <div class="col">
                            <div class="alert alert-<?= $messageType; ?>" role="alert"><?= $message; ?></div>
                    </div>
                </div>
            <?php } ?>
            <div class="row pt-3">
                    <div class="col-12">   
                        <div class="card">
                            <div class="card-header">Admin</div>
                            <div class="card-body"> 
                                <input type="hidden" name="action" value="delete">
                                <table class="table table-striped" id="results">
                                    <thead>
                                        <tr>
                                            <td>Submission Date</td>
                                            <td>First Name</td>
                                            <td>Surname</td>
                                            <td class="text-center">Age</td>
                                            <td>Date of Birth</td>
                                            <td class="text-center">Total Score</td>
                                            <td style="width:80px;"></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Looping the results -->
                                        <?php foreach($results as $result){ ?> 
                                            <tr>
                                                <td data-order="<?=  DateTime::createFromFormat('d/m/Y', $result["submission_date"])->Format('Y-m-d') ?>"><?=  $result["submission_date"] ?></td>
                                                <td><?=  $result["first_name"] ?></td>
                                                <td><?=  $result["surname"] ?></td>
                                                <td class="text-center"><?=  $result["age"] ?></td>
                                                <td data-order="<<?=  DateTime::createFromFormat('d/m/Y', $result["birth_date"])->Format('Y-m-d') ?>"><?=  $result["birth_date"] ?></td>
                                                <td class="text-center"><?=  $result["total_score"] ?></td>
                                                <td>
                                                    <a href="/admin.php?action=delete&id=<?=  $result["id"] ?>"><i class="fa-solid fa-trash-can"></i></a>
                                                    <a href="/update.php?id=<?=  $result["id"] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>  
                    
                            </div>
                        </div>  
                    </div> 
            </div>
        </div>
    </body>

    <script>
        new DataTable('#results');
    </script>
</html>