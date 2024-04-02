
<style>
body {
            margin: 0;
            padding: 0;
        }

        .topnav {
            background-color: #333;
            overflow: hidden;
        }

        .topnav a {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        .topnav a.active {
            background-color: #4CAF50;
            color: white;
        }

        .topnav .icon {
            display: none;
        }

        @media screen and (max-width: 600px) {
            .topnav a:not(:first-child) {display: none;}
            .topnav a.icon {
                float: right;
                display: block;
            }
        }

        @media screen and (max-width: 600px) {
            .topnav.responsive {position: relative;}
            .topnav.responsive .icon {
                position: absolute;
                right: 0;
                top: 0;
            }
            .topnav.responsive a {
                float: none;
                display: block;
                text-align: left;
            }
        }
    </style>
        <div class="topnav" id="myTopnav">
    <a href="adminBoard.php" class="active"><i class="fa fa-fw fa-home"></i>Home</a>
    <a href="adminpost.php"><i class="fas fa-fw fa-user"></i>Lost & Found</a>
    <a href="add_lost_item.php"><i class="fa-solid fa-utensils"></i>Add Post</a>
    <a href="manageitems.php"><i class="fa-solid fa-utensils"></i>Manage</a>
    <a href="usersAdmin.php"><i class="fa-solid fa-utensils"></i>Users</a>
    <a href="../login/logout.php"><i class="fas fa-fw fa-sign-out"></i>Logout</a>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
    </a>
</div>
