<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="dashboard.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Interface</div>
                <div class="nav-link collapsed" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    <span>Users</span>
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </div>
                <div class="collapse" id="collapseUsers" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <?php
                            if (!(!getPermission($_SESSION['acc_permission'],'addUser') && !getPermission($_SESSION['acc_permission'],'deleteUser')  && !getPermission($_SESSION['acc_permission'],'editUser')  && !getPermission($_SESSION['acc_permission'],'inspectUser') && !getPermission($_SESSION['acc_permission'],'updateUserStatus')))  {
                                echo '<a class="nav-link collapsed" href="../main-view/manage-users.php">
                                        Manage Users
                                    </a>';
                            } 
                        ?>
                    </nav>
                </div>
                <div class="nav-link collapsed" data-toggle="collapse" data-target="#collapseProducts" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-atom"></i></div>
                    <span>Products</span>
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </div>
                <div class="collapse" id="collapseProducts" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <?php
                            if (!(!getPermission($_SESSION['acc_permission'],'addProduct') && !getPermission($_SESSION['acc_permission'],'deleteProduct')  && !getPermission($_SESSION['acc_permission'],'editProduct')  && !getPermission($_SESSION['acc_permission'],'inspectProduct')))  {
                                echo '<a class="nav-link collapsed" href="../main-view/manage-products.php">
                                        Manage Products
                                    </a>';
                            } 
                        ?>
                        <?php
                            if (!(!getPermission($_SESSION['acc_permission'],'addProductCategory') && !getPermission($_SESSION['acc_permission'],'deleteProductCategory')  && !getPermission($_SESSION['acc_permission'],'editProductCategory')  && !getPermission($_SESSION['acc_permission'],'inspectProductCategory')))  {
                                echo '<a class="nav-link collapsed" href="../main-view/manage-products_categories.php">
                                        Manage Product Categories 
                                    </a>';
                            } 
                        ?>
                        <?php
                            if (!(!getPermission($_SESSION['acc_permission'],'addProductTag') && !getPermission($_SESSION['acc_permission'],'deleteProductTag')  && !getPermission($_SESSION['acc_permission'],'editProductTag')  && !getPermission($_SESSION['acc_permission'],'inspectProductTag')))  {
                                echo '<a class="nav-link collapsed" href="../main-view/manage-products_tags.php">
                                        Manage Product Tags
                                    </a>';
                            } 
                        ?>
                    </nav>
                </div>
                <div class="nav-link collapsed" data-toggle="collapse" data-target="#collapseNews" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-newspaper"></i></div>
                    <span>News</span>
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </div>
                <div class="collapse" id="collapseNews" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <?php
                            if (!(!getPermission($_SESSION['acc_permission'],'addNews') && !getPermission($_SESSION['acc_permission'],'deleteNews')  && !getPermission($_SESSION['acc_permission'],'editNews')  && !getPermission($_SESSION['acc_permission'],'inspectNews')))  {
                                echo '<a class="nav-link collapsed" href="../main-view/manage-news.php">
                                        Manage News
                                    </a>';
                            } 
                        ?>
                        <?php
                            if (!(!getPermission($_SESSION['acc_permission'],'addNewsCategory') && !getPermission($_SESSION['acc_permission'],'deleteNewsCategory')  && !getPermission($_SESSION['acc_permission'],'editNewsCategory')  && !getPermission($_SESSION['acc_permission'],'inspectNewsCategory')))  {
                                echo '<a class="nav-link collapsed" href="../main-view/manage-news_categories.php">
                                        Manage News Categories
                                    </a>';
                            } 
                        ?>
                        <?php
                            if (!(!getPermission($_SESSION['acc_permission'],'addNewsTag') && !getPermission($_SESSION['acc_permission'],'deleteNewsTag')  && !getPermission($_SESSION['acc_permission'],'editNewsTag')  && !getPermission($_SESSION['acc_permission'],'inspectNewsTag')))  {
                                echo '<a class="nav-link collapsed" href="../main-view/manage-news_tags.php">
                                        Manage News Tags
                                    </a>';
                            } 
                        ?>
                    </nav>
                </div>
                <div class="nav-link collapsed" data-toggle="collapse" data-target="#collapseSettings" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                    <span>Setting</span>
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </div>
                <div class="collapse" id="collapseSettings" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <?php
                            if (!(!getPermission($_SESSION['acc_permission'],'addRole') && !getPermission($_SESSION['acc_permission'],'deleteRole')  && !getPermission($_SESSION['acc_permission'],'editRole')  && !getPermission($_SESSION['acc_permission'],'inspectRole')))  {
                                echo '<a class="nav-link collapsed" href="../main-view/manage-user_roles.php">
                                        Manage User Roles
                                    </a>';
                            } 
                        ?>
                        <?php
                            if (!(!getPermission($_SESSION['acc_permission'],'addRole') && !getPermission($_SESSION['acc_permission'],'deleteRole')  && !getPermission($_SESSION['acc_permission'],'editRole')  && !getPermission($_SESSION['acc_permission'],'inspectRole')))  {
                                echo '<a class="nav-link collapsed" href="../main-view/manage-rss_links.php">
                                        Manage Rss News
                                    </a>';
                            } 
                        ?>
                    </nav>
                </div>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?php 
                echo $user["$user__username"];
            ?>
        </div>
    </nav>
</div>