<?php
require 'database.php';
require_once 'userhelper.php';

session_start();



$db = Database::getInstance()->getConnection();

$action = $_POST['action'];

switch($action) {
    case 'login':
        $email = $_POST['email'];
        $password = $_POST['password'];
        if (UserHelper::login($db, $email, $password)) {
            $_SESSION['just_logged_in'] = true;
            echo 'success';
        } else {
            echo 'failure';
        }
        break;
    case 'register':
        $formData = json_decode($_POST['formData'], true);
        $fname = $formData['fname'];
        $lname = $formData['lname'];
        $password = $formData['password'];
        $email = $formData['email'];
        $role = $formData['role'];

       if (UserHelper::register($db, $fname, $lname, $password, $email, $role)) {
            echo 'success';
        } else {
            echo 'failure';
        }
        break;

    case 'logout':
        if (UserHelper::logout()) {
            echo 'success';
        } else {
            echo 'failure';
        }
        break;
    case 'getUsers':
        $users = UserHelper::getUsers($db);

        echo '<section class="dashboard-user" id="user">
                <div class="user-dashboard-contents">
                    <h1 class="user-title">Users</h1>
                    <button class="btn" id="user-btn"> Add User </button>
                </div>
                <div class="user-area-contents">    
                    <table id="user-table">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created</th>
                        </tr>';
    
        foreach ($users as $user) {
            $fullName = $user['firstname'] . ' ' . $user['lastname'];
            echo '<tr>
                    <td>' . $fullName . '</td>
                    <td>' . $user['email'] . '</td>
                    <td>' . $user['role'] . '</td>
                    <td>' . $user['created_at'] . '</td>
                    </tr>';
        }
    
        echo '</table>
                </div>    
            </section>';
        break;
    case 'home':
        $filter = $_POST['id'];
        $contacts = UserHelper::getContacts($db);
        if ($filter == 'Sales Lead') {
            $contacts = UserHelper::getSalesLeads($db);
        } elseif ($filter == 'Support') {
            $contacts = UserHelper::getSupportContacts($db);
        } elseif ($filter == 'Assigned to me') {
            $contacts = UserHelper::getContactsAssignedToUser($db, $_SESSION['user_id']);
        }
        
        echo '<section class="dashboard-home" id="home">

        <div class="home-dashboard-contents">
            <h1 class="home-title">Dashboard</h1>
            <button class="btn"id="home-btn" onclick=""> Add Contact </button>
        </div>

        <div class="home-area-contents">

            <div class="home-filter">
                
                <div class="filter">
                    <i class="fa-solid fa-filter"></i> 
                    <h6 class="filter-title"> Filter By: </h6>
                </div>

                <nav class = "nav">                  
                    <ul class = "nav-list">
                        <li class = "nav-item filter-item" data-filter="all">
                            <a href = "#" class = "nav-link"> All </a>
                        </li>

                        <li class = "nav-item filter-item" data-filter="Sales Lead">
                            <a href = "#" class = "nav-link"> Sales Leads </a>
                        </li>

                        <li class = "nav-item filter-item" data-filter="Support">
                            <a href = "#" class = "nav-link"> Support </a>
                        </li>

                        <li class = "nav-item filter-item" data-filter="Assigned to me">
                            <a href = "#" class = "nav-link"> Assigned to me </a>
                        </li>
                    </ul> 
                </nav>

            </div>

            <table id="home-table">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Type</th>
                    <th> </th>
                </tr>';
                foreach ($contacts as $contact) {
                    $fullName = $contact['title'] . '. ' . $contact['firstname'] . ' ' . $contact['lastname'];
                    echo '<tr>
                            <td>' . $fullName . '</td>
                            <td>' . $contact['email'] . '</td>
                            <td>' . $contact['company'] . '</td>
                            <td>' . $contact['type'] . '</td>';
                            echo '<td data-id="'.$contact['id'].'"><button class="table-btn" id="table-view-button"> View </button></td></tr>
                            </tr>';
                }

            echo '<table>  
        </div>                   
        </section>';
        break;
    case 'newContact':
        echo '<section class="dashboard-contacts" id="contacts">
    
            <div class="contact-dashboard-contents">
                <h1 class="contacts-title">New Contact</h1>
            </div>
            
            <div class="contact-form-wrapper">
                <form action="" class="form" id="contact-form">        
                    <div class="contact-form-content">
                        <div class="contact-form-box">
                            <div class="contact-form-box-input"> 
                                <label for="dropdown" class="contact-form-label">
                                    Title
                                </label>
            
                                <select class="contact-form-input" id="dropdown" name="title-dropdown">
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Dr">Dr</option>
                                    <option value="Prof">Prof</option>
                                </select>
                            </div>
                        </div>    
            
                        <div class="contact-form-box">       
                            <div class="contact-form-box-input">
                                <label for="fname" class="contact-form-label">
                                    First Name
                                </label>
            
                                <input type="text" class="contact-form-input" placeholder="Jane" id="fname">
                            </div>   
                            
                            <div class="contact-form-box-input">
                                <label for="lname" class="contact-form-label">
                                    Last Name
                                </label>
            
                                <input type="text" class="contact-form-input" placeholder="Doe" id="lname">
                            </div>    
                        </div> 
                        
                        <div class="contact-form-box">       
                            <div class="contact-form-box-input">
                                <label for="email" class="contact-form-label">
                                    Email
                                </label>
            
                                <input type="email" class="contact-form-input" placeholder="someone@example.com" id="email">
                            </div>    
                            
                            <div class="contact-form-box-input">
                                <label for="telephone" class="contact-form-label">
                                    Telephone
                                </label>
            
                                <input type="tel" class="contact-form-input" placeholder=" " id="tele">
                            </div>        
                        </div> 
                        
                        <div class="contact-form-box">       
                            <div class="contact-form-box-input">
                                <label for="company" class="contact-form-label">
                                    Company
                                </label>
            
                                <input type="text" class="contact-form-input" placeholder=" " id="company">
                            </div>    
                            
                            <div class="contact-form-box-input">
                                <label for="dropdown" class="contact-form-label">
                                    Type
                                </label>
            
                                <select class="contact-form-input" id="dropdown" name="type-dropdown">
                                    <option value="Sales Lead">Sales Lead</option>
                                    <option value="Support">Support</option>
                                </select>
                            </div>        
                        </div>
                        
                        <div class="contact-form-box"> 
                            <div class="contact-form-box-input"> 
                                <label for="dropdown" class="contact-form-label">
                                    Assigned To
                                </label>
                                <select class="contact-form-input" id="dropdown" name="assigned-dropdown">';
        $users = UserHelper::getUsers($db);
        foreach ($users as $user) {
            $fullName = $user['firstname'] . ' ' . $user['lastname'];
            echo '<option value="' . $user['id'] .'">' . $fullName . '</option>';
        }
        echo '</select>
                            </div>    
                        </div>
                    </div>
                    <button type="button" class="btn" id="contact-btn">Save</button>
                </form>
            </div>  
        </section>';
        break;
    case 'addNewContact':
        $formData = json_decode($_POST['formData'], true);
        $title = $formData['title'];
        $fname = $formData['fname'];
        $lname = $formData['lname'];
        $email = $formData['email'];
        $tele = $formData['tele'];
        $company = $formData['company'];
        $type = $formData['type'];
        $assignedTo = $formData['assignedTo'];
        if (UserHelper::createContact($db, $title, $fname, $lname, $email, $tele, $company, $type, $assignedTo)) {
            echo 'success';
        } else {
            echo 'failure';
        }
        break;

    case 'newUser':
        echo '<section class="dashboard-new" id="new">

        <div class="view-dashboard-contents">
            <h1 class="contacts-title">New User</h1>
        </div>

        <div class="new-form-wrapper">
            <form action="" class="form" id="new-form">                        
                <div class="new-form-content">
                    <div class="new-form-box">       
                        <div class="new-form-box-input">
                            <label for = "fname" class = "new-form-label">
                                First Name
                            </label>

                            <input type = "text" 
                                class = "new-form-input" 
                                placeholder = "Jane"
                                id="fname">
                        </div>   
                        
                        <div class="new-form-box-input">
                            <label for = "new-lname" class = "new-form-label">
                                Last Name
                            </label>

                            <input type = "text" 
                                class = "new-form-input" 
                                placeholder = "Doe"
                                id="lname">   
                        </div>    
                    </div> 
                    
                    <div class="new-form-box">       
                        <div class="new-form-box-input">
                            <label for="email" class="new-form-label">
                                Email
                            </label>

                            <input type = "email" 
                                class = "new-form-input" 
                                placeholder = "something@example.com" 
                                id = "email">
                        </div>    
                        
                        <div class="new-form-box-input">
                            <label for="password" class="new-form-label">
                                Password
                            </label>

                            <input type = "password" 
                                class = "new-form-input" 
                                placeholder = " " 
                                id = "password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number, one uppercase and lowercase letter, and at least 8 or more characters" required>
                        </div>        
                    </div> 
                    
                    <div class="new-form-box"> 
                        <div class="new-form-box-input">
                            <label for="dropdown" class = "new-form-label">
                                Role
                            </label>

                            <select class="new-form-input" id="dropdown" name="assigned-dropdown">
                                <option value="Member">Member</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type ="submit" class="btn" id="new-btn">Save</button>
            </form>
        </div>  
    </section>';
    break;
    case 'viewContact':
        $id = $_POST['id'];
        $contactFetched = UserHelper::getContactById($db, $id);
        $userAssignedTo = UserHelper::getUserById($db, $contactFetched['assigned_to']);
        $notes = UserHelper::getNotesForContact($db, $id);
        $currentRole = $contactFetched['type'];
        $nextRole = "";
        if ($currentRole == "Sales Lead") {
            $nextRole = "Support";
        } else {
            $nextRole = "Sales Lead";
        }

        echo '<section class="dashboard-view" id="view">

        <div class="view-dashboard-contents">    
            
            <div class="view-image">
                <img src="user.png" alt="View Image" class="view-img">
            </div>

            <div class="view-details"> <!-- Note: JS Needed -->
                <h1 class="view-title">' . $contactFetched['title'] . ". ". $contactFetched['firstname']. " " . $contactFetched['lastname'] .'</h1>
                <p class="view-created">Created on ' . $contactFetched['created_at'] .'</p>
                <p class="view-updated">Updated on ' . $contactFetched['updated_at'] .'</p>
            </div>                        

            <div class="button-view">';
                echo "<button class='btn' id='assign-btn' data-contact='{$contactFetched['id']}' data-created='{$_SESSION['user_id']}'> <i class='fa-solid fa-hand'></i> Assign to me </button>";
                echo "<button class='btn' id='switch-btn' data-contact='{$contactFetched['id']}' data-next='{$nextRole}'> <i class='fa-solid fa-arrows-left-right'></i> Switch to " . $nextRole . "</button>";   
            echo '</div>
        </div>

        <div class="view-description"> <!-- Note: JS Needed -->
            
            <div class="view-description-content">
                <h6 class="view-content-label" id="view-email">Email</h6>
                <p class="view-content" id="view-email-address">' . $contactFetched['email'] .'</p>
            </div>

            <div class="view-description-content">
                <h6 class="view-content-label" id="view-tele">Telephone</h6>
                <p class="view-content" id="view-tele-no">' . $contactFetched['telephone'] .'</p>
            </div>

            <div class="view-description-content">
                <h6 class="view-content-label" id="view-company">Company</h6>
                <p class="view-content" id="view-company-name">' . $contactFetched['company'] .'</p>
            </div>

            <div class="view-description-content">
                <h6 class="view-content-label" id="view-assigned">Assigned To</h6>
                <p class="view-content" id="view-role">' .$userAssignedTo['firstname'] ." ". $userAssignedTo['lastname'] . '</p>
            </div>                 
            
        </div>

        <div class="view-notes">   
            
            <h6 class="view-note-title"><i class=""></i> Notes</h6>

            <hr class="view-notes-line">

            <div class="comment-section">';
            foreach ($notes as $note) {
                echo "<h6 class='comment-name'>". $note['firstname'] . " " . $note['lastname'] ."</h6>";
                echo "<p class='comment'>" . $note['comment'] . "</p>";
                echo "<p class='comment-date'>" . $note['created_at'] . "</p>";
            }
            echo '</div>
            <div class="comment-form-wrapper">
                <form action="" class="form" id="comment-form">
                    <h6 class="comment-form-title">Add a note about ' .$contactFetched['firstname']. " " . $contactFetched['lastname']. '</h6> 

                    <textarea name="comment-area" placeholder="Enter details here" id="" cols="30" rows="10" class="comment-area"></textarea>';

                    echo "<button class='btn' id='view-btn' data-contact='{$contactFetched['id']}' data-created='{$_SESSION['user_id']}'> Add Note </button>";

                echo'</form>
            </div>
        </div>
    </section>';
    break;
    case 'addNote':
        $formData = json_decode($_POST['formData'], true);
        $comment = $formData['comment'];
        $userID = $formData['userId'];
        $contactID = $formData['contactId'];

        if (UserHelper::insertNote($db, $comment, $userID, $contactID)) {
            echo 'success';
        } else {
            echo 'failure';
        }
        break;

    case 'assignToMe':
        $formData = json_decode($_POST['formData'], true);
        $userID = $formData['userId'];
        $contactID = $formData['contactId'];

        if (UserHelper::assignToMe($db, $userID, $contactID)) {
            echo 'success';
        } else {
            echo 'failure';
        }
        break;


    case 'switchType':
        $formData = json_decode($_POST['formData'], true);
        $contactID = $formData['contactId'];
        $nextRole = $formData['nextRole'];

        if (UserHelper::updateRoleForContact($db, $contactID, $nextRole)) {
            echo 'success';
        } else {
            echo 'failure';
        }
        break;


}


?>