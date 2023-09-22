<?php
include_once("./check_admin.php");
include_once("./header.php");
?>
<div class="min-h-screen grid grid-row-1 w-full container-1">
<nav class="main-header flex mt-3">
        <a href="./admin.php" class="ml-3 block">
            <img class="main-logo" src="./assets/icons/white-logo.png" />
        </a>
        <div class="mx-auto mr-6 flex items-center justify-center">
            <!-- <div class="profile mx-auto mr-6">Profile</div> -->
            <a href="./logout.php" class="btn-1">Logout</a>
        </div>
    </nav>
    <main class="mt-table pl-2 z-1">
        <div class="max-height overflow-y-auto">
        <table id="genre_tbl" class="table-1 mx-auto bg-black opacity-60 ">
            <thead>
                <tr>
                    <th class="px-2 py-1">S/N</th>
                    <th class="px-2 py-1">Name</th>
                    <th class="px-2 py-1" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody id="genre_tbl_data" class="">
            
            </tbody>
        </table>
        </div>
    </main>
    <div class="blue-circle"></div>
    <div class="yellow-circle"></div>
    <div class="pink-circle"></div>
</div>
<?php
include_once("./footer.php");
?>