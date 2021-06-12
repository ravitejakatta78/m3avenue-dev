	<!-- begin:: Aside -->
				<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
				<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

					<!-- begin::Aside Brand -->
					<div class="kt-aside__brand kt-grid__item " id="kt_aside_brand">
						<div class="kt-aside__brand-logo">
							<a href="dashboard.php">
								<img alt="Logo" src="./assets/media/logos/logo-6.png" style="width: 67px;
    margin-left: 30px;
    margin-top: 20px;">
							</a>
						</div>
						<div class="kt-aside__brand-tools">
							<button class="kt-aside__brand-aside-toggler kt-aside__brand-aside-toggler--left" id="kt_aside_toggler"><span></span></button>
						</div>
					</div>

					<!-- end:: Aside Brand -->



					<!-- begin:: Aside Menu -->
					
					<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
   <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
<ul class="kt-menu__nav ">
		 <?php $pagename = basename($_SERVER['PHP_SELF']);?>
		 
	<li class="kt-menu__item  kt-menu__item--submenu  <?php if($pagename=='dashboard.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
            <a href="dashboard.php" class="kt-menu__link kt-menu__toggle">
             <i class="kt-menu__link-icon flaticon-avatar"></i>
            <span class="kt-menu__link-text">Dashboard</span>
            <i class=""></i>
            </a>
    </li>	
<li class="kt-menu__item  kt-menu__item--submenu <?php if($pagename=='loan.php'||$pagename=='investment.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
          	<a href="#" class="kt-menu__link kt-menu__toggle">
            <i class="kt-menu__link-icon flaticon-users"></i>
            <span class="kt-menu__link-text">Enquires</span>
            <i class="kt-menu__ver-arrow la la-angle-right"></i></a>
            
			<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
				<ul class="kt-menu__subnav"> 
					<li class="kt-menu__item   <?php if($pagename=='loan.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true">
					<a href="loan.php" class="kt-menu__link ">
					<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
					<span class="kt-menu__link-text">Loan</span></a>
					</li>
					 <li class="kt-menu__item  <?php if($pagename=='investment.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true">
					<a href="investment.php" class="kt-menu__link ">
					<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
					<span class="kt-menu__link-text">Investment</span></a>
					</li>
					
            <li class="kt-menu__item  <?php if($pagename=='user-data.php'){ echo 'kt-menu__item--active';}?> " aria-haspopup="true">
            <a href="user-data.php" class="kt-menu__link ">
            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
            <span class="kt-menu__link-text">Website users</span></a>
            </li>
            <li class="kt-menu__item  <?php if($pagename=='track-user-investment.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true">
            <a href="track-user-investment.php" class="kt-menu__link ">
            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
            <span class="kt-menu__link-text">Track Investments</span></a>
            </li>
			 <li class="kt-menu__item  <?php if($pagename=='track-user-loans.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true">
            <a href="track-user-loans.php" class="kt-menu__link ">
            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
            <span class="kt-menu__link-text">Track Loans</span></a>
            </li>
				  </ul>
		</div>
	    </li> 
	<li class="kt-menu__item  kt-menu__item--submenu  <?php if($pagename=='employe-list.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
            <a href="employe-list.php" class="kt-menu__link kt-menu__toggle">
             <i class="kt-menu__link-icon flaticon-avatar"></i>
            <span class="kt-menu__link-text">Employee List</span>
            <i class=""></i>
            </a>
    </li>	 
		
	<li class="kt-menu__item  kt-menu__item--submenu  <?php if($pagename=='employee-track-work.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
            <a href="employee-track-work.php" class="kt-menu__link kt-menu__toggle">
             <i class="kt-menu__link-icon flaticon-avatar"></i>
            <span class="kt-menu__link-text">Employee Track work</span>
            <i class=""></i>
            </a>
    </li>					
	<li class="kt-menu__item  <?php if($pagename=='financiar-list.php'){ echo 'kt-menu__item--active';}?> " aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
            <a href="financiar-list.php" class="kt-menu__link kt-menu__toggle">
            <i class="kt-menu__link-icon flaticon-avatar"></i>
            <span class="kt-menu__link-text">
Client List</span>
            <i class=""></i>
            </a>
    </li>	 
	<li class="kt-menu__item  kt-menu__item--submenu  <?php if($pagename=='feedback-options.php'||$pagename=='campaigns-list.php'||$pagename=='employee-report.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
          	<a href="#" class="kt-menu__link kt-menu__toggle">
            <i class="kt-menu__link-icon flaticon-users"></i>
            <span class="kt-menu__link-text">Dialer</span>
            <i class="kt-menu__ver-arrow la la-angle-right"></i></a>
            
			<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
				<ul class="kt-menu__subnav">
			
				
			
            <li class="kt-menu__item  <?php if($pagename=='feedback-options.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true">
            <a href="feedback-options.php" class="kt-menu__link ">
            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
            <span class="kt-menu__link-text">Feedback Options</span></a>
            </li>
			 <li class="kt-menu__item  <?php if($pagename=='campaigns-list.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true">
            <a href="campaigns-list.php" class="kt-menu__link ">
            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
            <span class="kt-menu__link-text">Campaigns List</span></a>
            </li> 
	 
            <li class="kt-menu__item  <?php if($pagename=='executive-list.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true">
            <a href="executive-list.php" class="kt-menu__link ">
            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
            <span class="kt-menu__link-text">Executive list</span></a>
            </li>
            <li class="kt-menu__item  <?php if($pagename=='manager-list.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true">
            <a href="manager-list.php" class="kt-menu__link ">
            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
            <span class="kt-menu__link-text">Manager list</span></a>
            </li>
            
          </ul>
		</div>
	</li> 	 
	<li class="kt-menu__item  kt-menu__item--submenu  <?php if($pagename=='track-client.php'||$pagename=='track-team.php'||$pagename=='employee-report.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
          	<a href="#" class="kt-menu__link kt-menu__toggle">
            <i class="kt-menu__link-icon flaticon-users"></i>
            <span class="kt-menu__link-text">Team Data</span>
            <i class="kt-menu__ver-arrow la la-angle-right"></i></a>
            
			<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
				<ul class="kt-menu__subnav">
			
				
			
            <li class="kt-menu__item  <?php if($pagename=='track-client.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true">
            <a href="track-client.php" class="kt-menu__link ">
            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
            <span class="kt-menu__link-text">Track Client</span></a>
            </li>
			 <li class="kt-menu__item  <?php if($pagename=='track-team.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true">
            <a href="track-team.php" class="kt-menu__link ">
            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
            <span class="kt-menu__link-text">Track Team</span></a>
            </li>
            
            <li class="kt-menu__item  <?php if($pagename=='employee-report.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true">
            <a href="employee-report.php" class="kt-menu__link ">
            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
            <span class="kt-menu__link-text">Employee DSR</span></a>
            </li>
            <li class="kt-menu__item  <?php if($pagename=='points-set.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true">
            <a href="points-set.php" class="kt-menu__link ">
            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
            <span class="kt-menu__link-text">Points set</span></a>
            </li>
            
          </ul>
		</div>
	</li> 
	<li class="kt-menu__item  kt-menu__item--submenu  <?php if($pagename=='points-set.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
          	<a href="#" class="kt-menu__link kt-menu__toggle">
            <i class="kt-menu__link-icon flaticon-users"></i>
            <span class="kt-menu__link-text">Utilities</span>
            <i class="kt-menu__ver-arrow la la-angle-right"></i></a>
            
			<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
				<ul class="kt-menu__subnav"> 
					<li class="kt-menu__item  <?php if($pagename=='points-set.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true">
					<a href="points-set.php" class="kt-menu__link ">
					<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
					<span class="kt-menu__link-text">Points set</span></a>
					</li> 
					<li class="kt-menu__item  <?php if($pagename=='work-source.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true">
					<a href="work-source.php" class="kt-menu__link ">
					<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
					<span class="kt-menu__link-text">Work source</span></a>
					</li>
          </ul>
		</div>
	</li> 
	 
		
	<!--<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
            <a href="track-team.php" class="kt-menu__link kt-menu__toggle">
            <i class="kt-menu__link-icon flaticon-presentation-1"></i>
            <span class="kt-menu__link-text">Track Team</span>
            <i class=""></i>
            </a>
     </li>	-->	
		
	<li class="kt-menu__item  kt-menu__item--submenu  <?php if($pagename=='contact.php'){ echo 'kt-menu__item--active';}?>" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
            <a href="contact.php" class="kt-menu__link kt-menu__toggle">
            <i class="kt-menu__link-icon flaticon-presentation-1"></i>
            <span class="kt-menu__link-text">Contact</span>
            <i class=""></i>
            </a>
    </li>
	<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
            <a href="logout.php" class="kt-menu__link kt-menu__toggle">
            <i class="kt-menu__link-icon flaticon-presentation-1"></i>
            <span class="kt-menu__link-text">Log out</span>
            <i class=""></i>
            </a>
    </li>
  </ul>
	
   </div>
</div>


<!-- end:: Aside Menu -->
				</div>