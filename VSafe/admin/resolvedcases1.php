<?php 
    require_once 'connection.php';

?>
<?php

//Quary to get all resolved cases
    $sql = "SELECT * FROM tbl_case WHERE status = '1'";
//Execute quary
    $res = mysqli_query($conn, $sql);
//check whether the qry executed or not

    if ($res == true) {
    //Count rows to check we have data on the db or not
        $count = mysqli_num_rows($res); // function to get all availble data in the db
    //check the num of rows
        if ($count > 0) {
        //we have data in the db
            while ($rows = mysqli_fetch_assoc($res)) {
            //using while loop to get all the dta in the db and display all of them
                $id = $rows['id'];
                $datetimeValue = $rows['date_time'];
                $datetime = new DateTime($datetimeValue);
                $date = $datetime->format('Y-m-d');
                $time = $datetime->format('H:i:s');
                $location = $rows['location'];
                list($longitude, $latitude) = explode(",",$location);
                $status = $rows['status'];
                if ($status) {
                    $statusRes = "Resolved";
                } else {
                    $statusRes = "Unresolved";
                }

            //Display the Details
?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $date; ?></td>
                    <td><?php echo $time; ?></td>
                    <td><a href="https://www.google.com/maps/search/?api=1&query=<?php echo $longitude,$latitude ?>"><?php echo $longitude,$latitude ?> </a></td>
                    <td><?php echo $statusRes; ?></td>
                    <td><a class="btn btn-sm btn-primary" href="view-case.php?caseid=<?php echo $id ?>">Details</a></td>
                </tr>
<?php
        }
    }
}

?>