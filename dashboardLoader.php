<?php
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
                <li class = "nav-item">
                    <a href = "" class = "nav-link"> All </a>
                </li>

                <li class = "nav-item">
                    <a href = "" class = "nav-link"> Sales Leads </a>
                </li>

                <li class = "nav-item">
                    <a href = "" class = "nav-link"> Support </a>
                </li>

                <li class = "nav-item">
                    <a href = "" class = "nav-link"> Assigned to me </a>
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
        </tr>

        <tr>
            <td value="">Mr. Josiah-John Green </td>
            <td value="">josiahjohngreen@gmail.com</td>
            <td value="">StackGROW Ltd</td>
            <td value="">Sales Lead</td>
            <td value=""><button class="table-btn" id="table-view-button"> View </button></td>
        </tr>
    <table>  
</div>                   
</section>';
?>