<?php
    include_once("db_configs.php");

    $id = $_GET['id']; // Assuming the 'id' is passed as a parameter in the request

    $sql_get_contacts = "SELECT * FROM user_conversations WHERE sender_id = '$id' OR reciever_id = '$id' GROUP BY conversation_id";
    $result_get_contacts = $conn->query($sql_get_contacts);

    $contacts = array();

    if ($result_get_contacts) {
        if ($result_get_contacts->num_rows > 0) {
            while ($row = $result_get_contacts->fetch_assoc()) {
                $contact_infos = array();
                if ($row['sender_id'] == $id) {
                    $contact_id = $row['reciever_id'];
                } else {
                    $contact_id = $row['sender_id'];
                }

                $sql_get_contact_name = "SELECT * FROM users WHERE user_id = '$contact_id'";
                $result_get_contact_name = $conn->query($sql_get_contact_name);

                if ($result_get_contact_name && $result_get_contact_name->num_rows > 0) {
                    $contact_name_row = $result_get_contact_name->fetch_assoc();
                    $contact_infos['user_id'] = $contact_id;
                    $contact_infos['username'] = $contact_name_row['username'];
                    $contact_infos['status'] = $contact_name_row['status'];
                    $contact_infos['email'] = $contact_name_row['email'];
                    $contact_infos['phone'] = $contact_name_row['phone'];
                    $contact_infos['work'] = $contact_name_row['work'];
                    $contact_infos['quot'] = $contact_name_row['quot'];
                    $contact_infos['location'] = $contact_name_row['location'];
                    $contacts[] = $contact_infos;
                }
            }
        } else {
            // No contacts found
            $contacts = array(); // Empty array
        }
    } else {
        // Query failed
        $contacts = array(); // Empty array
    }

    $conn->close();

    // Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($contacts);
