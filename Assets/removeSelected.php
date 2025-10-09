<?php

if (isset($_POST['functionSelectedItems']) && $_POST['functionSelectedItems'] === 'RemoveSpec') {
    include '../Database/connection.php'; // or your actual DB connection file

    $doctorId = mysqli_real_escape_string($connMysqli, $_POST['selectedDoctorID']);
    $specName = mysqli_real_escape_string($connMysqli, $_POST['specName']);

    $deleteQuery = "DELETE FROM doctor_specialization 
                    WHERE specialization_doctor_id = '$doctorId' 
                    AND doctor_specialization_name = '$specName'";

    if (mysqli_query($connMysqli, $deleteQuery)) {
        echo "Specialization '$specName' removed successfully.";
    } else {
        echo "Error removing specialization: " . mysqli_error($connMysqli);
    }
    exit;
}

?>