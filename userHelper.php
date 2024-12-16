<?php
session_start();

class UserHelper {
    public static function register($db, $firstname, $lastname, $password, $email, $role) {
        if (!self::isAdmin()) {
            echo "Not an Admin";
            return false;
        };
        
        // Check if the user already exists
        $userExistsQuery = 'SELECT * FROM Users WHERE email = :email';
        $userExistsStatement = $db->prepare($userExistsQuery);
    
        $userExistsParams = array(
            ':email' => $email
        );
    
        $userExistsStatement->execute($userExistsParams);
        $existingUser = $userExistsStatement->fetch(PDO::FETCH_ASSOC);
    
        if ($existingUser !== false) {
            return false;
        }
    
        // User does not exist, proceed with registration
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        $insertQuery = 'INSERT INTO Users (firstname, lastname, password, email, role)
                        VALUES (:firstname, :lastname, :password, :email, :role)';
        $insertStatement = $db->prepare($insertQuery);
    
        $params = array(
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':password' => $hashed_password,
            ':email' => $email,
            ':role' => $role
        );
    
        $insertResult = $insertStatement->execute($params);
        return true; 
    }
    

    public static function login($db, $email, $password) {
        $query = 'SELECT * FROM Users WHERE email = :email';
        $statement = $db->prepare($query);

        $params = array(
            ':email' => $email
        );

        $statement->execute($params);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['userfname'] = $user['firstname'];
            $_SESSION['userlname'] = $user['lastname'];
            $_SESSION['user_id'] = $user['id'];

            return true;
        } else {
            return false;
        }
    }

    public static function logout() {
        session_destroy();
        return true;
    }

    public static function getUsers($db) {
        if (!self::isAdmin()){
            echo 'not an admin';
            return;
        }

        $result = $db->prepare('SELECT * FROM Users');

        $result->execute();
        $users = $result->fetchAll(PDO::FETCH_ASSOC);
        return $users;

    }

    public static function getContacts($db) {
        $result = $db->prepare('SELECT * FROM Contacts');

        $result->execute();
        $users = $result->fetchAll(PDO::FETCH_ASSOC);
        return $users;

    }

    public static function getContactById($db, $id) {
        $result = $db->prepare('SELECT * FROM Contacts WHERE id = :id');

        $result->bindParam(':id', $id, PDO::PARAM_INT);
    
       
        $result->execute();
        $contact = $result->fetch(PDO::FETCH_ASSOC);
    
        return $contact;
    }

    public static function getUserById($db, $id) {
        $result = $db->prepare('SELECT * FROM Users WHERE id = :id');

        $result->bindParam(':id', $id, PDO::PARAM_INT);
    
       
        $result->execute();
        $contact = $result->fetch(PDO::FETCH_ASSOC);
    
        return $contact;
    }

    public static function insertNote($db, $comment, $userID, $contactID) {
        $stmt = $db->prepare("INSERT INTO Notes (comment, created_by, contact_id) VALUES (:comment, :userID, :contactID)");
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':contactID', $contactID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt = $db->prepare("UPDATE Contacts SET updated_at = CURRENT_TIMESTAMP WHERE id = :contactID");
            $stmt->bindParam(':contactID', $contactID, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        }
        return false;
    }

    public static function getNotesForContact($db, $contactID) {
        $stmt = $db->prepare("
            SELECT Notes.*, Users.firstname, Users.lastname 
            FROM Notes 
            INNER JOIN Users ON Notes.created_by = Users.id 
            WHERE Notes.contact_id = :contactID
        ");
        $stmt->bindParam(':contactID', $contactID, PDO::PARAM_INT);
        $stmt->execute();

        $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $notes;
    }

    public static function assignToMe($db, $userID, $contactID) {
        $stmt = $db->prepare("UPDATE Contacts SET assigned_to = :userID WHERE id = :contactID");
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':contactID', $contactID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public static function updateRoleForContact($db, $userID, $newRole) {
        $stmt = $db->prepare("UPDATE Contacts SET type = :newRole WHERE id = :userID");
        $stmt->bindParam(':newRole', $newRole);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public static function getSalesLeads($db) {
        $stmt = $db->prepare("SELECT * FROM Contacts WHERE type = :type");
        $type = 'Sales Lead';
        $stmt->bindParam(':type', $type);
        $stmt->execute();

        $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $contacts;
    }

    public static function getSupportContacts($db) {
        $stmt = $db->prepare("SELECT * FROM Contacts WHERE type = :type");
        $type = 'Support';
        $stmt->bindParam(':type', $type);
        $stmt->execute();

        $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $contacts;
    }

    public static function getContactsAssignedToUser($db, $userID) {
        $stmt = $db->prepare("SELECT * FROM Contacts WHERE assigned_to = :userID");
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();

        $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $contacts;
    }
    

    public static function createContact($db, $title, $firstname, $lastname, $email, $telephone, $company, $type, $assigned_to) {
        
        $contactExistsQuery = 'SELECT * FROM Contacts WHERE email = :email';
        $contactExistsStatement = $db->prepare($contactExistsQuery);
    
        $contactExistsParams = array(
            ':email' => $email
        );
    
        $contactExistsStatement->execute($contactExistsParams);
        $existingContact = $contactExistsStatement->fetch(PDO::FETCH_ASSOC);
    
        if ($existingContact !== false) {
            return false;
        }
    
        // Contact does not exist, proceed with creation
        $insertQuery = 'INSERT INTO Contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by)
                        VALUES (:title, :firstname, :lastname, :email, :telephone, :company, :type, :assigned_to, :created_by)';
        $insertStatement = $db->prepare($insertQuery);
    
        $params = array(
            ':title' => $title,
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':email' => $email,
            ':telephone' => $telephone,
            ':company' => $company,
            ':type' => $type,
            ':assigned_to' => $assigned_to,
            ':created_by' => $_SESSION['user_id']
        );
    
        $insertResult = $insertStatement->execute($params);
        return true;
    }
    


    private static function isAdmin() {
        return strcmp($_SESSION['user_role'], 'Admin') == 0;
    }

}