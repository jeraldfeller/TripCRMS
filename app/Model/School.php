<?php
/**
 * Created by PhpStorm.
 * User: Grabe Grabe
 * Date: 9/7/2016
 * Time: 8:05 AM
 */

class School extends Common {

    public $debug = TRUE;
    protected $db_pdo;

    public function getAllTrips()
    {
        $pdo = $this->getPdo();
        $sql = 'SELECT * FROM `trip` ORDER BY `tid` DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $content[] = $row;
        }
        return $content;
    }

    public function getAllTripsActive()
    {
        $pdo = $this->getPdo();
        $sql = 'SELECT * FROM `trip` WHERE `status` = "Active" ORDER BY `tid` DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $content[] = $row;
        }
        return $content;
    }


    public function getTripsById($tid)
    {
        $pdo = $this->getPdo();
        $sql = 'SELECT * FROM `trip` WHERE `tid` = ' . $tid . '';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $content[] = $row;
        }
        return $content;
    }

    public function getRegisteredTripsById($tid, $uid)
    {
        $pdo = $this->getPdo();
        $sql = 'SELECT * FROM `registeredtrips` WHERE `tid` = ' . $tid . ' AND `uid` = ' . $uid . '';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $content[] = $row;
        }
        return $content;
    }


    public function getRegisteredClients($tid, $type)
    {
        $pdo = $this->getPdo();
        if($type == 'all'){
            $where = 'AND registeredtrips.status != "cancelled"';
        }else{
            $where = 'AND registeredtrips.status = "' . $type . '"';
        }
        $sql = 'SELECT users.firstName,
                       users.lastName,
                       registeredtrips.uid,
                       registeredtrips.tid,
                       registeredtrips.fee,
                       registeredtrips.remaining,
                       registeredtrips.status,
                       registeredtrips.dateAdded,
                       registeredtrips.rtid,
                       registeredtrips.contractImage
                FROM `users`, `registeredtrips`
                WHERE registeredtrips.uid = users.uid
                AND registeredtrips.tid = ' . $tid . ' ' . $where . ' ORDER BY registeredtrips.rtid DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $content[] = $row;
        }
        return $content;
    }

    public function getRegisteredTripsByUid($uid)
    {
        $pdo = $this->getPdo();
        $sql = 'SELECT trip.*, registeredTrips.tid, registeredTrips.uid, registeredTrips.status as registrationStatus, registeredTrips.dateAdded as dateRegistered
                FROM `trip`, `registeredTrips`
                WHERE registeredTrips.uid = ' . $uid . '
                AND registeredTrips.tid = trip.tid
                ';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $content[] = $row;
        }
        return $content;
    }

    public function getRegisteredCount($tid){

        $pdo = $this->getPdo();
        $sql = 'SELECT * FROM `registeredtrips` WHERE `tid` = ' . $tid . ' AND `status` = "approved"';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();
        return $count;
    }

    public function getRegisteredTotalSumFees($tid){

        $pdo = $this->getPdo();
        $sql = 'SELECT SUM(`fee`) AS totalFees FROM `registeredtrips` WHERE `tid` = ' . $tid . ' AND `status` = "approved"';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['totalFees'];
    }

    public function getRegisteredTotalPaidSumFees($tid){
        $pdo = $this->getPdo();
        $sql = 'SELECT SUM(`amount`) AS totalAmountPaid FROM `payments` WHERE `transactionType` = "trip" AND `transactionId` = ' . $tid . '';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['totalAmountPaid'];
    }


    public function getPaymentHistory($uid, $rtid)
    {
        $pdo = $this->getPdo();
        $sql = 'SELECT `amount`, DATE_FORMAT(`dateAdded`, "%M %d, %Y") as dateAdded
                FROM `payments`
                WHERE `uid` = ' . $uid . '
                AND `rtid` = ' . $rtid . '
                ';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $content[] = $row;
        }
        return $content;
    }

    public function addTrip(){
        $title = addslashes($_POST['title']);
        $description = addslashes($_POST['description']);
        $dateNow = date('Y-m-d');
        $fromDate = date('Y-m-d', strtotime($_POST['from']));
        $toDate = date('Y-m-d', strtotime($_POST['to']));
        $fee = str_replace(',','', '' . $_POST['fee'] . '');
        $noPayments = addslashes($_POST['noPayments']);
        $noDaysDue = addslashes($_POST['noDaysDue']);


        try{
            $pdo = $this->getPdo();
            $sql = 'INSERT INTO `trip` (`tripTitle`, `fromDate`, `toDate`,`description`, `fee`, `noPayments`, `noDaysDue`, `status`, `dateAdded`)
                    VALUES ("' . $title . '", "' . $fromDate . '", "' . $toDate . '", "' . $description . '", "' . $fee . '", "' . $noPayments . '", "' . $noDaysDue . '", "Active", "' . $dateNow. '")';
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute();

            $location = $_SERVER['PHP_SELF'] .'?success=true&msg=Trip successfully added.';

        }catch (Exception $e){
            $location = $_SERVER['PHP_SELF'] .'?success=false&msg=Something went wrong, please try again';
        }

        header('Location: ' . $location . '');
    }


    public function editTrip(){
        $title = addslashes($_POST['title']);
        $description = addslashes($_POST['description']);
        $fromDate = date('Y-m-d', strtotime($_POST['from']));
        $toDate = date('Y-m-d', strtotime($_POST['to']));
        $tid = $_POST['tid'];
        $status = $_POST['status'];
        $fee = str_replace(',','', '' . $_POST['fee'] . '');
        $noPayments = addslashes($_POST['noPayments']);
        $noDaysDue = addslashes($_POST['noDaysDue']);


        try{
            $pdo = $this->getPdo();
            $sql = 'UPDATE `trip` SET `tripTitle` = "' . $title . '",
                    `fromDate` = "' . $fromDate . '",
                    `toDate` ="' . $toDate . '",
                    `description` ="' . $description . '",
                    `fee` ="' . $fee . '",
                    `noPayments` ="' . $noPayments . '",
                    `noDaysDue` ="' . $noDaysDue . '",
                    `status` = "' . $status . '"
                    WHERE `tid` = ' . $tid . '
                    ';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $location = $_SERVER['PHP_SELF'] .'?success=true&msg=Trip successfully updated.';

        }catch (Exception $e){
            $location = $_SERVER['PHP_SELF'] .'?success=false&msg=Something went wrong, please try again';
        }

        header('Location: ' . $location . '');
    }


    public function deleteTrip(){
        $tid = $_POST['tid'];
        try{
            $pdo = $this->getPdo();
            $sql = 'DELETE FROM `trip` WHERE `tid` = ' . $tid . '';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $location = $_SERVER['PHP_SELF'] .'?success=true&msg=Trip successfully deleted.';

        }catch (Exception $e){
            $location = $_SERVER['PHP_SELF'] .'?success=false&msg=Something went wrong, please try again';
        }

        header('Location: ' . $location . '');
    }

    public function registerTrip($uid, $email){

        $tid = $_POST['tid'];
        $fee = $_POST['fee'];
        $dateNow = date('Y-m-d');
        $status = 'no contract';
        $email = array($email);

        try{
            $pdo = $this->getPdo();
            $sql = 'INSERT INTO `registeredTrips` (`tid`, `uid`, `fee`,`remaining`, `status`, `dateAdded`)
                    VALUES ("' . $tid . '",
                            "' . $uid . '",
                            "' . $fee . '",
                            "' . $fee . '",
                            "' . $status . '",
                            "' . $dateNow . '")';
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute();

            $this->sendMail($email, 'Registration', 'Congratulations you are registered to this trip', 'jeraldfeller@yahoo.com');

            $location = $_SERVER['PHP_SELF'] .'?success=true&msg=Trip successfully added.';

        }catch (Exception $e){
            $location = $_SERVER['PHP_SELF'] .'?success=false&msg=Something went wrong, please try again';
        }

        header('Location: ' . $location . '');
    }


    public function cancelRegistration($uid){
        $tid = $_POST['tid'];

        try{
            $pdo = $this->getPdo();
            $sql = 'UPDATE `registeredTrips` set `status` = "Cancelled" WHERE `uid` = ' . $uid . ' AND `tid` = ' . $tid . '';
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute();

            $location = $_SERVER['PHP_SELF'] .'?success=true&msg=Trip successfully cancelled.';

        }catch (Exception $e){
            $location = $_SERVER['PHP_SELF'] .'?success=false&msg=Something went wrong, please try again';
        }

        header('Location: ' . $location . '');
    }


    public function approveDeclineRegistration($queryString){
        $rtid = $_POST['rtid'];
        if(isset($_POST['approveContract'])){
            $status = "approved";
        }else{
            $status = "declined";
        }

        try{
            $pdo = $this->getPdo();
            $sql = 'UPDATE `registeredTrips` SET `status` = "' . $status . '"
                    WHERE `rtid` = ' . $rtid . '';
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute();

            $location = $_SERVER['PHP_SELF'] .'?' . $queryString . '&success=true&msg=Student successfully updated.';

        }catch (Exception $e){
            $location = $_SERVER['PHP_SELF'] .'?' . $queryString . '&success=false&msg=Something went wrong, please try again';
        }

        header('Location: ' . $location . '');
    }



    public function uploadContract($uid){
        $dateNow = date('Y-m-d');
        $tid = $_POST['tid'];
        $allowed = array('jpg', 'jpeg', 'png');
        if(isset($_FILES['fileContract']['tmp_name'])){
            $fileName = $_FILES['fileContract']['name'];
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            if(!in_array($ext, $allowed)){
                $location = $_SERVER['PHP_SELF'] .'?success=false&msg=Something went wrong, please upload an image file (jpeg, jpg, png)';
            }else{
                if($_FILES["fileContract"]['tmp_name'] != '' || $_FILES["fileContract"]['tmp_name'] != null){
                    $fileContract = addslashes(file_get_contents($_FILES["fileContract"]['tmp_name']));

                    try{
                        $pdo = $this->getPdo();
                        $sql = 'UPDATE `registeredTrips`
                        SET `contractImage` = "' . $fileContract . '",
                        `dateContractAdded` = "' . $dateNow . '",
                        `status` = "pending"
                        WHERE `uid` = ' . $uid . '
                        AND `tid` = ' . $tid . '';
                        $stmt = $pdo->prepare($sql);
                        $result = $stmt->execute();

                        $location = $_SERVER['PHP_SELF'] .'?success=true&msg=Contract successfully uploaded';

                    }catch (Exception $e){
                        $location = $_SERVER['PHP_SELF'] .'?success=false&msg=Something went wrong, please try again';
                    }

                }else{
                    $location = $_SERVER['PHP_SELF'] .'?success=false&msg=Something went wrong, please try again';
                }
            }

        }else{

           $location = $_SERVER['PHP_SELF'] .'?success=false&msg=Something went wrong, please try again';
        }


       header('Location: ' . $location . '');

    }


    public function takePayment($queryString){

        $rtid = $_POST['rtid'];
        $tid = $_POST['tid'];
        $uid = $_POST['uid'];
        $transactionType = 'trip';
        $dateNow = date('Y-m-d');
        $amount = str_replace(',','', '' . $_POST['amount'] . '');


        try{
            $pdo = $this->getPdo();
            $sql = 'INSERT INTO `payments` (`rtid`, `uid`, `amount`,`transactionType`, `transactionId`, `dateAdded`)
                    VALUES ("' . $rtid . '",
                            "' . $uid . '",
                            "' . $amount . '",
                            "' . $transactionType . '",
                            "' . $tid . '",
                            "' . $dateNow . '")';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $this->updateRemaining($rtid, $amount);

            $location = $_SERVER['PHP_SELF'] .'?' . $queryString . '&success=true&msg=Payment successfully added.';

        }catch (Exception $e){
            $location = $_SERVER['PHP_SELF'] .'?' . $queryString . '&success=false&msg=Something went wrong, please try again';
        }

        header('Location: ' . $location . '');
    }


    private function updateRemaining($rtid, $amount){
        $pdo = $this->getPdo();
        $sql = 'UPDATE `registeredtrips` SET `remaining` = (`remaining` - ' . $amount . ')
                          WHERE `rtid` = ' . $rtid . '';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }



    /*
    * Database functions
    */


    public function pdoQuoteValue($value)
    {
        $pdo = $this->getPdo();
        return $pdo->quote($value);
    }



    public function getPdo()
    {
        if (!$this->db_pdo)
        {
            if ($this->debug)
            {
                $this->db_pdo = new PDO(DB_DSN, DB_USER, DB_PWD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            }
            else
            {
                $this->db_pdo = new PDO(DB_DSN, DB_USER, DB_PWD);
            }
        }
        return $this->db_pdo;
    }


}