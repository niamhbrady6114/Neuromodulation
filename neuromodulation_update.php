<?php 

    require_once __DIR__ . '/db.php';  
    
    $neuromodulation = "";
    $messasge = "";
    $messageType = "";

    $id = (isset($_GET['id']) ? $_GET['id']: NULL);

    $tsql = "{call sp_select_neuromodulation (?)}"; 
    $params = array(
        array($id, SQLSRV_PARAM_IN)
    );

    $stmt = sqlsrv_prepare($conn, $tsql, $params); 
    if ($stmt && sqlsrv_execute($stmt)) {

        $neuromodulation = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        if ($neuromodulation && $neuromodulation['birth_date'] instanceof DateTime) {
            $today = new DateTime();
            $neuromodulation['age'] = $today->diff($neuromodulation['birth_date'])->y;
            $neuromodulation['birth_date'] = $neuromodulation['birth_date']->format('Y-m-d');
        }
    } else {
        $message = "Error Submitting Form: " . print_r(sqlsrv_errors(), true);
        $messageType = "danger";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action === 'update') {
            $id = trim($_POST['id'] ?? '');
            $first_name = trim($_POST['first_name'] ?? '');
            $surname = trim($_POST['surname'] ?? '');
            $birth_date = trim($_POST['birth_date'] ?? '');
            $age = trim($_POST['age'] ?? '');
            $q1 = trim($_POST['q1'] ?? '');
            $q2 = trim($_POST['q2'] ?? '');
            $q3 = trim($_POST['q3'] ?? '');
            $q4 = trim($_POST['q4'] ?? '');
            $q5 = trim($_POST['q5'] ?? '');
            $q6 = trim($_POST['q6'] ?? '');
            $q7 = trim($_POST['q7'] ?? '');
            $q8 = trim($_POST['q8'] ?? '');
            $q9 = trim($_POST['q9'] ?? '');
            $q10 = trim($_POST['q10'] ?? '');
            $q11 = trim($_POST['q11'] ?? '');
            $q12 = trim($_POST['q12'] ?? '');
            $total_score = trim($_POST['total_score'] ?? '');

           // Parameters to send to store procedure
            $tsql = "{call sp_update_neuromodulation (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
            $params = array(
                array($first_name, SQLSRV_PARAM_IN),
                array($surname, SQLSRV_PARAM_IN),
                array($birth_date, SQLSRV_PARAM_IN),
                array((int)$age, SQLSRV_PARAM_IN),
                array((int)$q1, SQLSRV_PARAM_IN),
                array((int)$q2, SQLSRV_PARAM_IN),
                array((int)$q3, SQLSRV_PARAM_IN),
                array((int)$q4, SQLSRV_PARAM_IN),
                array((int)$q5, SQLSRV_PARAM_IN),
                array((int)$q6, SQLSRV_PARAM_IN),
                array((int)$q7, SQLSRV_PARAM_IN),
                array((int)$q8, SQLSRV_PARAM_IN),
                array((int)$q9, SQLSRV_PARAM_IN),
                array((int)$q10, SQLSRV_PARAM_IN),
                array((int)$q11, SQLSRV_PARAM_IN),
                array((int)$q12, SQLSRV_PARAM_IN),
                array((int)$total_score, SQLSRV_PARAM_IN),
                array((int)$id, SQLSRV_PARAM_IN)
            );

            $stmt = sqlsrv_prepare($conn, $tsql, $params);
            if ($stmt && sqlsrv_execute($stmt)) {
                header("Location: /neuromodulation_select.php");
                $message = "Form Successfully Updated.";
                $messageType = "success";
            } else {
                $message = "Error Updating Form: " . print_r(sqlsrv_errors(), true);
                $messageType = "danger";
            }
            
        }
    } else {
        
    }
?>

<html>
     <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Neuromodulation</title>
        <!-- BOOTSTRAP 5 CSS (CDN) -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .sticky-sidebar {
                position: sticky;
                /* Keeps original position at rest, but stops 2rem (approx 32px) below viewport top when scrolling */
                top: 2rem;
            }

            input[type="range"] {
                /* removing default appearance */
                -webkit-appearance: none;
                appearance: none; 
                /* creating a custom design */
                width: 100%;
                cursor: pointer;
                outline: none;
                /*  slider progress trick  */
                overflow: hidden;
                border-radius: 16px;
            }

                /* Track: webkit browsers */
            input[type="range"]::-webkit-slider-runnable-track {
                height: 15px;
                background: #ccc;
                border-radius: 16px;
            }

                /* Track: Mozilla Firefox */
            input[type="range"]::-moz-range-track {
                height: 15px;
                background: #ccc;
                border-radius: 16px;
            }

                /* Thumb: webkit */
            input[type="range"]::-webkit-slider-thumb {
                /* removing default appearance */
                -webkit-appearance: none;
                appearance: none; 
                /* creating a custom design */
                height: 15px;
                width: 15px;
                background-color: #fff;
                border-radius: 50%;
                border: 2px solid #198754;
                /*  slider progress trick  */
                box-shadow: -407px 0 0 400px #198754;
            }

                /* Thumb: Firefox */
            input[type="range"]::-moz-range-thumb {
                height: 15px;
                width: 15px;
                background-color: #fff;
                border-radius: 50%;
                border: 1px solid #198754;
                /*  slider progress trick  */
                box-shadow: -407px 0 0 400px #198754;
            }

        </style>
    </head>

    <body>
        <?php include_once "header.php" ?>
        <div class="container-fluid">
            <div class="row align-items-start pt-3">
                <div class="col">
                    <?php if(!empty($message)) { ?>
                        <div class="alert alert-<?= $messageType; ?>" role="alert"><?= $message; ?></div>
                    <?php } ?>
                </div>
            </div>
            <form action="neuromodulation_update.php" method="POST">
                <div class="row justify-content-start">
                    <div class="col-md-8">
                        <div class="card">
                             <!-- PATIENT DETAILS -->
                            <div class="card-header">Patient Details</div>
                            <div class="card-body">
            
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="id" value="<?= $neuromodulation["id"] ?>">

                                <div class="row align-items-start">
                                    <div class="col-6">
                                        <label class="form-label" for="first_name">First Name:</label>
                                        <input class="form-control" type="text" name="first_name" id="first_name" maxlength="50" required value="<?= $neuromodulation["first_name"] ?>">
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label" for="surname">Surname:</label>
                                        <input class="form-control" type="text" name="surname" id="surname" maxlength="50" required value="<?= $neuromodulation["surname"] ?>">
                                    </div>
                                </div>
                                
                                <div class="row align-items-start pt-3">
                                    <div class="col-6">
                                        <label class="form-label" for="birth_date">Date of Birth:</label>
                                        <input class="form-control" type="date" name="birth_date" id="birth_date" required value="<?= $neuromodulation["birth_date"] ?? '' ?>">
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label" for="age">Age:</label>
                                        <input class="form-control" type="text" name="age" id="age" readonly value="<?= $neuromodulation["age"] ?? '' ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <!-- BRIEF PAIN INVENTORY -->
                            <div class="card-header">Brief Pain Inventory (BPI)</div>
                            <div class="card-body">

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <label class="form-label" for="q1"><span class="badge bg-secondary me-2">1</span>How much relief have pain treatments or medications <span class="fw-bold text-decoration-underline">FROM THIS CLINIC</span> provided? </label>
                                            <span id="q1_slider" class="fw-bold fs-5 ms-2"></span>
                                        </div>
                                        <div class="slidecontainer mt-3 mb-3">
                                            <input type="range" min="0" max="100" value="<?= $neuromodulation["q1"] ?>" class="slider" id="q1" name="q1" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <label class="form-label" for="q2"><span class="badge bg-secondary me-2">2</span>Please rate your pain based on the number that best describes your pain at it's <span class="fw-bold text-decoration-underline">WORST</span> in the past week. </label>
                                            <span id="q2_slider" class="fw-bold fs-5 ms-2"></span>
                                        </div>
                                        <div class="slidecontainer mt-3 mb-3">
                                            <input type="range" min="0" max="10" value="<?= $neuromodulation["q2"] ?>" class="slider" id="q2" name="q2" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <label class="form-label" for="q3"><span class="badge bg-secondary me-2">3</span>Please rate your pain based on the number that best describes your pain at it's <span class="fw-bold text-decoration-underline">LEAST</span> in the past week. </label>
                                            <span id="q3_slider" class="fw-bold fs-5 ms-2"></span>
                                        </div>
                                        <div class="slidecontainer mt-3 mb-3">
                                            <input type="range" min="0" max="10" value="<?= $neuromodulation["q3"] ?>" class="slider" id="q3" name="q3" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <label class="form-label" for="q4"><span class="badge bg-secondary me-2">4</span>Please rate your pain based on the number that best describes your pain on the <span class="fw-bold text-decoration-underline">AVERAGE</span>. </label>
                                            <span id="q4_slider" class="fw-bold fs-5 ms-2"></span>
                                        </div>
                                        <div class="slidecontainer mt-3 mb-3">
                                            <input type="range" min="0" max="10" value="<?= $neuromodulation["q4"] ?>" class="slider" id="q4" name="q4" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <label class="form-label" for="q5"><span class="badge bg-secondary me-2">5</span>Please rate your pain based on the number that best describes your pain that tells how much pain you have <span class="fw-bold text-decoration-underline">RIGHT NOW</span>. </label>
                                            <span id="q5_slider" class="fw-bold fs-5 ms-2"></span>
                                        </div>
                                        <div class="slidecontainer mt-3 mb-3">
                                            <input type="range" min="0" max="10" value="<?= $neuromodulation["q5"] ?>" class="slider" id="q5" name="q5" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <label class="form-label" for="q6"><span class="badge bg-secondary me-2">6</span>Based on the number that best describes how during the past week pain has <span class="fw-bold text-decoration-underline">INTERFERED</span> with your: General activity. </label>
                                            <span id="q6_slider" class="fw-bold fs-5 ms-2"></span>
                                        </div>
                                        <div class="slidecontainer mt-3 mb-3">
                                            <input type="range" min="0" max="10" value="<?= $neuromodulation["q6"] ?>" class="slider" id="q6" name="q6" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <label class="form-label" for="q7"><span class="badge bg-secondary me-2">7</span>Based on the number that best describes how during the past week pain has <span class="fw-bold text-decoration-underline">INTERFERED</span> with your: Mood. </label>
                                            <span id="q7_slider" class="fw-bold fs-5 ms-2"></span>
                                        </div>
                                        <div class="slidecontainer mt-3 mb-3">
                                            <input type="range" min="0" max="10" value="<?= $neuromodulation["q7"] ?>" class="slider" id="q7" name="q7" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <label class="form-label" for="q8"><span class="badge bg-secondary me-2">8</span>Based on the number that best describes how during the past week pain has <span class="fw-bold text-decoration-underline">INTERFERED</span> with your: Walking ability. </label>
                                            <span id="q8_slider" class="fw-bold fs-5 ms-2"></span>
                                        </div>
                                        <div class="slidecontainer mt-3 mb-3">
                                            <input type="range" min="0" max="10" value="<?= $neuromodulation["q8"] ?>" class="slider" id="q8" name="q8" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <label class="form-label" for="q9"><span class="badge bg-secondary me-2">9</span>Based on the number that best describes how during the past week pain has <span class="fw-bold text-decoration-underline">INTERFERED</span> with your: Normal work (includes work both outside the home and housework). </label>
                                            <span id="q9_slider" class="fw-bold fs-5 ms-2"></span>
                                        </div>
                                        <div class="slidecontainer mt-3 mb-3">
                                            <input type="range" min="0" max="10" value="<?= $neuromodulation["q9"] ?>" class="slider" id="q9" name="q9" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <label class="form-label" for="q10"><span class="badge bg-secondary me-2">10</span>Based on the number that best describes how during the past week pain has <span class="fw-bold text-decoration-underline">INTERFERED</span> with your: Relationships with other people. </label>
                                            <span id="q10_slider" class="fw-bold fs-5 ms-2"></span>
                                        </div>
                                        <div class="slidecontainer mt-3 mb-3">
                                            <input type="range" min="0" max="10" value="<?= $neuromodulation["q10"] ?>" class="slider" id="q10" name="q10" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <label class="form-label" for="q11"><span class="badge bg-secondary me-2">11</span>Based on the number that best describes how during the past week pain has <span class="fw-bold text-decoration-underline">INTERFERED</span> with your: Sleep. </label>
                                            <span id="q11_slider" class="fw-bold fs-5 ms-2"></span>
                                        </div>
                                        <div class="slidecontainer mt-3 mb-3">
                                            <input type="range" min="0" max="10" value="<?= $neuromodulation["q11"] ?>" class="slider" id="q11" name="q11" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <label class="form-label" for="q12"><span class="badge bg-secondary me-2">12</span>Based on the number that best describes how during the past week pain has <span class="fw-bold text-decoration-underline">INTERFERED</span> with your: Enjoyment of life. </label>
                                            <span id="q12_slider" class="fw-bold fs-5 ms-2"></span>
                                        </div>
                                        <div class="slidecontainer mt-3 mb-3">
                                            <input type="range" min="0" max="10" value="<?= $neuromodulation["q12"] ?>" class="slider" id="q12" name="q12" required>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sticky-sidebar">
                            <div class="card">
                                <div class="card-header">Total Score</div>
                                <div class="card-body">
                                    <label class="form-label fs-4 fw-bold" for="total_score">Total Score: <span id="total_score">0</span> / 110</label>
                                    <input type="hidden" name="total_score" id="total_score_input" value="0">
                                    <div class="col-12 pt-3">
                                        <button class="btn btn-success" type="submit" style="width:100%">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
    <script>
        var sliders = document.querySelectorAll('.slider');
        var totalOutput = document.getElementById('total_score');

        function updateTotal() {
            var total = 0;
            sliders.forEach(function(slider) {
                if  (slider.id === 'q1') return;
                total += Number(slider.value);
            });
            totalOutput.innerHTML = total;
            document.getElementById('total_score_input').value = total;
        }

        sliders.forEach(function(slider) {
            var output = document.getElementById(slider.id + '_slider');
            if (output) {
                output.innerHTML = slider.value;
            }
            slider.oninput = function() {
                if (output) {
                    output.innerHTML = this.value;
                }
                updateTotal();
            };
        });

        updateTotal();

        document.getElementById('birth_date').addEventListener('change', function() {
            var birthDate = new Date(this.value);
            var today = new Date();

            var age = today.getFullYear() - birthDate.getFullYear();
            var monthDiff = today.getMonth() - birthDate.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            document.getElementById('age').value = age;
        });
    </script>
</html>

