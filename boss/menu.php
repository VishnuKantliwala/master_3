<!-- ========== Left Sidebar Start ========== -->
<link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<div class="left-side-menu">
    <div class="slimscroll-menu">
        <!-- User box -->
        <div class="user-box text-center">
            <img src="assets/images/logo.jpg" alt="user-img" title="<?php echo $_SESSION['user']; ?>" class="img-thumbnail avatar-lg">
            <div class="dropdown">
                <a class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"><?php echo $_SESSION['user'] . " (" . $_SESSION['control'] . ")"; ?></a>
            </div>
            <p class="text-gray totalElapseTime mt-10">Loading...</p>            
            
        </div>

        
        <div class="col-md-12 clockDiv text-center">
            <?
            $timeOver = false;
            $user_login_id = 0;
            $sqlIsClockIn = $cn->selectdb("SELECT user_login_id FROM tbl_user_login WHERE DATEDIFF(user_login_date, CURDATE()) = 0 AND user_id = ".$_SESSION['user_id']." ");
            if( $cn->numRows($sqlIsClockIn) == 0 )
            {
                $style = "display:none";
            ?>
                <button style="width:100%" class="btn btn-success btnClockIn" title="View" onClick="clockIn()"><i class="mdi mdi-clock"></i> Clock-in</button>

            <?
            }
            else
            {
                $rowIsClockIn = $cn->fetchAssoc($sqlIsClockIn);
                $user_login_id = $rowIsClockIn['user_login_id'];
                
                $sqlIsClockOut = $cn->selectdb("SELECT user_login_id FROM tbl_user_login WHERE DATEDIFF(user_login_date, CURDATE()) = 0 AND user_id = ".$_SESSION['user_id']." AND  user_login_status = 1");
                if( $cn->numRows($sqlIsClockOut) > 0 )
                {

                    $rowIsClockOut = $cn->fetchAssoc($sqlIsClockOut);
                    $user_login_id = $rowIsClockOut['user_login_id'];
                    
                    $style = "display:none";
                    $timeOver = true;
                    
            ?>
            <h5>[Today's time over.]</h5>
            <?
                }
                else
                {
                    $style = "";
                    
                }
            }

            ?>
            <button style="margin-bottom:10px;width:100%;<?echo $style?>" class="btn btn-blue btnClockOut" title="View" onClick="clockOut()"><i class="mdi mdi-clock-alert"></i> Clock-out</button>



            <?
            // $user_login_id = 0;
            if(!$timeOver)
            {
                // echo $user_login_id;
                $sqlISClockedIn = $cn->selectdb("SELECT user_login_log_id, user_login_log_status FROM tbl_user_login_log WHERE user_login_id = ".$user_login_id. " ORDER BY user_login_log_id DESC");
                if( $cn->numRows($sqlISClockedIn) > 0 )
                {
                    $rowISClockedIn = $cn->fetchAssoc($sqlISClockedIn);
                    $user_login_log_status = $rowISClockedIn['user_login_log_status'];
                    if($user_login_log_status == 1)
                    {
                        
                        $stylePlay = "display:none";
                        $stylePause = "";
                    }
                    else
                    {
                        $stylePlay = "";
                        $stylePause = "display:none";
                    }
                    
                
                }
                else
                {
                    $stylePlay = $style;
                    $stylePause = "display:none ";
                }
            }
            else
            {
                $stylePlay = "display:none";
                $stylePause = "display:none";
            }
            ?>
                <button class="btn btn-blue btnStartTime" style="width:100%;<?echo $stylePlay?>" title="Start Session" onClick="startTimeIn()"><i class="mdi mdi-play"></i> </button>

                <button class="btn btn-danger btnPauseTime" style="width:100%;<?echo $stylePause?>" title="Pause Session" onClick="startTimeOut()"><i class="mdi mdi-pause"></i> </button>
            
            

            
            
            <div style="width:100%;display:block;text-align:center; display:none"
                class="clockLoader">

                <img src="./assets/images/loading.gif" />
                <br />
            </div>
            
        </div>
        

        <div class="col-md-12 text-center">
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
                    
                <?php
                }
                ?>
                
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
