//fix regex pattern checking in a bit

$(document).ready(function() {

    function loadDashboard(component, id) {
        var data = { action: component };
        if (id) {
            data.id = id;
        }
        $.ajax({
            type: "POST",
            url: "requestHandler.php",
            data: data,
            success: function(response) {
                $('.dashboard-area').html(response);
                if (component == 'home') {
                    $('.dashboard-home').css('display', 'grid'); 
                }
                if (component == 'getUsers') {
                    $('.dashboard-user').css('display', 'grid'); 
                }
                if (component == 'newContact') {
                    $('.dashboard-contacts').css('display', 'grid'); 
                }
                if (component == 'newUser') {
                    $('.dashboard-new').css('display', 'grid'); 
                }
                if (component == 'viewContact') {
                    $('.dashboard-view').css('display', 'grid'); 
                }
            }
        });
    }
    
    
    $('#form-btn').on('click', function(e) {
        e.preventDefault();
        var email = $('#email').val();
        var password = $('#pass').val();

        $.ajax({
            type: "POST",
            url: "requestHandler.php",
            data: { action: "login", email: email, password: password },
            success: function(response) {
                if(response.trim() === 'success') {
                    window.location.href = "index.php";
                } else {
                    alert("Login failed. Please try again.");
                }
            }
        });        
    });

    $(document).on('click', '#home-btn', function(event) {
        loadDashboard('newContact');  
    });

    $(document).on('click', '#user-btn', function(event) {
        loadDashboard('newUser');
    });

    $(document).on('submit', '#new-form', function(event) {
        
        if (this.checkValidity()) {
            // If the form is valid, prevent the default form submission
            event.preventDefault();
    
            var formData = {
                fname: $('#fname').val(),
                lname: $('#lname').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                role: $('#dropdown').val()
            };
            

    
            $.ajax({
                type: 'POST',
                url: 'requestHandler.php',
                data: { action: "register", formData: JSON.stringify(formData)},
                success: function(response) {
                    if(response.trim() === 'success') {
                        alert("user Successfully Added")
                        loadDashboard('newUser');
                    } else {
                        alert("Error Creating User");
                    }
                }
            });
        }
    });


    $(document).on('click', '.filter-item .nav-link', function(event) {
        event.preventDefault();
        var filter = $(this).parent().data('filter');
        loadDashboard('home', filter);
    });    

    $(document).on('click', '#table-view-button', function(event) {
        
        event.preventDefault();
        var id = $(this).parent().data('id');
        loadDashboard('viewContact', id);
    });
    

    $(document).on('click', '#contact-btn', function(event) {
        
        event.preventDefault();

        var formData = {
            title: $('#dropdown[name="title-dropdown"]').val(),
            fname: $('#fname').val(),
            lname: $('#lname').val(),
            email: $('#email').val(),
            tele: $('#tele').val(),
            company: $('#company').val(),
            type: $('#dropdown[name="type-dropdown"]').val(),
            assignedTo: $('#dropdown[name="assigned-dropdown"]').val()
        };
        

        $.ajax({
            type: 'POST',
            url: 'requestHandler.php',
            data: { action: "addNewContact", formData: JSON.stringify(formData)},
            success: function(response) {
                if(response.trim() === 'success') {
                    alert("Contact Successfully Added")
                    loadDashboard('newContact');
                } else {
                    alert("Error creating contact");
                }
            }
        });
    });



    $(document).on('click', '#view-btn', function(event) {
        event.preventDefault();
        var comment = $('.comment-area').val();
        var contactId = $(this).data('contact');
        var userId = $(this).data('created'); 

        var formData = {
            comment: comment,
            contactId: contactId,
            userId: userId
            
        };
        $.ajax({
            type: 'POST',
            url: 'requestHandler.php',
            data: { action: "addNote", formData: JSON.stringify(formData)},
            success: function(response) {
                if(response.trim() === 'success') {
                    loadDashboard('viewContact', contactId);
                } else {
                    alert("Error adding new note");
                }
            }
        });
        
    });
    
    

    $('#logoutLink').on('click', function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: "requestHandler.php",
            data: { action: "logout"},
            success: function(response) {
                if(response.trim() === 'success') {
                    alert("User logged out");
                    window.location.href = "log.php";
                } else {
                    alert("Logout failed. Please try again.");
                }
            }
        });
    });


    

    function hideDashboard() {
        $('.dashboard-home').css('display', 'none'); // Change display to none
    }

    function hideUsers() {
        $('.dashboard-user').css('display', 'none'); // Change display to none
    }

    function hideNewContact() {
        $('.dashboard-contacts').css('display', 'none'); // Change display to none
    }

    function hideNew() {
        $('.dashboard-new').css('display', 'none'); // Change display to none
    }

    function hideView() {
        $('.dashboard-view').css('display', 'none'); // Change display to none
    }

    

    // Call loadDashboard when home is clicked
    $('a[href="#home"]').on('click', function(e) {
        e.preventDefault();
        hideUsers();
        hideNewContact();
        hideNew();
        hideView();
        loadDashboard('home');
    });

    $('a[href="#users"]').on('click', function(e) {
        e.preventDefault();
        hideDashboard();
        hideNewContact();
        hideNew();
        hideView();
        loadDashboard('getUsers');
    });

    $('a[href="#contacts"]').on('click', function(e) {
        e.preventDefault();
        hideDashboard();
        hideUsers();
        hideNew();
        hideView();
        loadDashboard('newContact');
    });



    $(document).on('click', '#assign-btn', function(event) {
        event.preventDefault();
        var userId = $(this).data('created'); 
        var contactId = $(this).data('contact');

        var formData = {
            userId: userId,
            contactId: contactId
            
        };
        $.ajax({
            type: 'POST',
            url: 'requestHandler.php',
            data: { action: "assignToMe", formData: JSON.stringify(formData)},
            success: function(response) {
                if(response.trim() === 'success') {
                    loadDashboard('viewContact', contactId);
                } else {
                    alert("Error adding new note");
                }
            }
        });
        
    });

    $(document).on('click', '#switch-btn', function(event) {
        event.preventDefault();
        var contactId = $(this).data('contact');
        var nextRole = $(this).data('next'); 
        var formData = {
            contactId: contactId,
            nextRole: nextRole
        };
        $.ajax({
            type: 'POST',
            url: 'requestHandler.php',
            data: { action: "switchType", formData: JSON.stringify(formData)},
            success: function(response) {
                if(response.trim() === 'success') {
                    loadDashboard('viewContact', contactId);
                } else {
                    alert("Error adding new note");
                }
            }
        });
        
    });
    
    
});