<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">
    <div class="slimscroll-menu">
        <!-- User box -->
        <div class="user-box text-center">
            <img src="assets/images/logo.jpg" alt="user-img" title="<?php echo $_SESSION['user']; ?>" class="img-thumbnail avatar-lg">
            <div class="dropdown">
                <a class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"><?php echo $_SESSION['user'] . " (" . $_SESSION['control'] . ")"; ?></a>
            </div>
            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="logout.php" class="text-custom">
                        <i class="mdi mdi-power"></i>
                    </a>
                </li>
            </ul>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">

                <li class="menu-title">Navigation</li>

                <li>
                    <a href="index.php" <?php if($page_id==1) echo 'class="active"';?>>
                        <i class="mdi mdi-view-dashboard"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                <?php
                if ($_SESSION['control'] == "admin") {
                ?>
                    <li <?php if($page_id==2 OR $page_id==3 OR $page_id==4 OR $page_id==5 OR $page_id==6 OR $page_id==7 OR $page_id==8 OR $page_id==9) echo 'class="active"';?>>
                        <a href="#" <?php if($page_id==2 OR $page_id==3 OR $page_id==4 OR $page_id==5 OR $page_id==6 OR $page_id==7 OR $page_id==8 OR $page_id==9) echo 'class="active"';?>>
                            <i class="mdi mdi-texture"></i>
                            <span> Master </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li <?php if($page_id==2) echo 'class="active"';?>><a href="serverview.php">Server</a></li>
                            <li <?php if($page_id==3) echo 'class="active"';?>><a href="serviceview.php">Service</a></li>
                            <li <?php if($page_id==4) echo 'class="active"';?>><a href="userview.php">Employee</a></li>
                            <li <?php if($page_id==5) echo 'class="active"';?>><a href="attendantview.php">Attendant</a></li>
                            <li <?php if($page_id==6) echo 'class="active"';?>><a href="customerview.php">Customer</a></li>
                            <li <?php if($page_id==7) echo 'class="active"';?>><a href="logoview.php">Logo</a></li>
                            <li <?php if($page_id==8) echo 'class="active"';?>><a href="expenseview.php">Expense</a></li>
                            <li <?php if($page_id==9) echo 'class="active"';?>><a href="tcview.php">Term & Condition</a></li>
                        </ul>

                    </li>
                    <li <?php if($page_id==29 OR $page_id==30 ) echo 'class="active"';?>>
                        <a href="#" <?php if($page_id==2 OR $page_id==30) echo 'class="active"';?>>
                            <i class="mdi fas fa-tasks"></i>
                            <span> Tasks </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="assignedTaskView.php" <?php if($page_id==29) echo 'class="active"';?>>Assigned Tasks</a></li>
                            <li><a href="notAssignedTaskView.php" <?php if($page_id==30) echo 'class="active"';?>>Non Assigned Tasks</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="purchaseView.php" <?php if($page_id==27) echo 'class="active"';?>>
                            <i class="fas fa-file-alt"></i>
                            <span> Purchase </span>
                        </a>
                    </li>
                    <li>
                        <a href="bookingview.php" <?php if($page_id==10) echo 'class="active"';?>>
                            <i class="fas fa-file-alt"></i>
                            <span> Invoice </span>
                        </a>
                    </li>
                    <li>
                        <a href="cashview.php" <?php if($page_id==26) echo 'class="active"';?>>
                            <i class="fas fa-file-alt"></i>
                            <span>Cash Invoice </span>
                        </a>
                    </li>
                    <li>
                        <a href="proformaview.php" <?php if($page_id==11) echo 'class="active"';?>>
                            <i class="far fa-file-alt"></i>
                            <span> Proforma & Quotation </span>
                        </a>
                    </li>
                    <li>
                        <a href="serviceConfirmationView.php" <?php if($page_id==25) echo 'class="active"';?>>
                            <i class="far fa-file-alt"></i>
                            <span> Service Confirmation </span>
                        </a>
                    </li>
                    <li>
                        <a href="renewalReminderView.php" <?php if($page_id==28) echo 'class="active"';?>>
                            <i class="far fa-file-alt"></i>
                            <span> Renewal</span>
                        </a>
                    </li>
                <?php
                }
                ?>
                
                <?php
                if ($_SESSION['control'] == "admin") {
                ?>
                    <li <?php if($page_id==16 OR $page_id==17 OR $page_id==19 OR $page_id==20 OR $page_id==21 OR $page_id==24) echo 'class="active"';?>>
                        <a href="#" <?php if($page_id==16 OR $page_id==17 OR $page_id==19 OR $page_id==20 OR $page_id==21 OR $page_id==24) echo 'class="active"';?>>
                            <i class="fas fa-chart-pie"></i>
                            <span> Reports </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li <?php if($page_id==16) echo 'class="active"';?>><a href="report-project-work.php">Project Work</a></li>
                            <li <?php if($page_id==17) echo 'class="active"';?>><a href="report-attendant.php">Attendant</a></li>
                            <li <?php if($page_id==19) echo 'class="active"';?>><a href="report-sales.php">Sales</a></li>
                            <li <?php if($page_id==20) echo 'class="active"';?>><a href="report-inquiry.php">Inquiry</a></li>
                            <!-- <li <?php if($page_id==21) echo 'class="active"';?>><a href="report-renew.php">Renewal</a></li> -->
                            <li <?php if($page_id==24) echo 'class="active"';?>><a href="report-task.php">Task</a></li>
                        </ul>
                    </li>
                <?php
                }
                ?>
                <?php
                if ($_SESSION['control'] == 'admin') {
                ?>
                    <li>
                        <a href="companyview.php" <?php if($page_id==12) echo 'class="active"';?>>
                            <i class="mdi mdi-account-card-details-outline"></i>
                            <span> Company Name </span>
                        </a>
                    </li>
                    <li>
                        <a href="domain_renew_view.php" <?php if($page_id==13) echo 'class="active"';?>>
                            <i class="fas fa-sync-alt"></i>
                            <span> Upcoming Renewal </span>
                        </a>
                    </li>
                    <li>
                        <a href="taskview.php" <?php if($page_id==22) echo 'class="active"';?>>
                            <i class="fas fa-tasks"></i>
                            <span> Task </span>
                        </a>
                    </li>
                <?php
                }
                ?>
                <li>
                    <a href="taskemp.php" <?php if($page_id==23) echo 'class="active"';?>>
                        <i class="fas fa-tasks"></i>
                        <span> Allocate Task </span>
                    </a>
                </li>
                <?php
                if ($_SESSION['control'] == 'Employee') {
                ?>
                <li>
                    <a href="pro_achknow_view.php" <?php if($page_id==15) echo 'class="active"';?>>
                        <i class="mdi mdi-account-key-outline"></i>
                        <span> Project Work </span>
                    </a>
                </li>
                <?php
                }
                ?>
                <li>
                    <a href="inquiry.php" <?php if($page_id==14) echo 'class="active"';?>>
                        <i class="fas fa-plus"></i>
                        <span> Inquiry </span>
                    </a>
                </li>
                <li>
                    <a href="changepassword.php" <?php if($page_id==18) echo 'class="active"';?>>
                        <i class="mdi mdi-account-key-outline"></i>
                        <span> Change Password </span>
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <i class="mdi mdi-power"></i>
                        <span> Logout </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
<!-- Left Sidebar End -->
