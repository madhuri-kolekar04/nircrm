<header class="main-header">

<style>

.rotate {
	
    -moz-transition: all .5s linear;
    -webkit-transition: all .5s linear;
    transition: all .5s linear;

    -moz-transform:rotate(180deg);
    -webkit-transform:rotate(180deg);
    transform:rotate(180deg);
}
</style>


    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top pl-30">
      <!-- Sidebar toggle button-->
	  <div>
		  <ul class="nav">
		  <li class="btn-group nav-item">
				<a href="#" class="waves-effect waves-light nav-link rounded svg-bt-icon rotatebtn" data-toggle="push-menu" role="button">
				<i class=" fa fa-chevron-right  "></i>
			    </a>
			</li>
			<li class="btn-group nav-item">
				<a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link rounded svg-bt-icon" title="Full Screen">
					<i class="nav-link-icon mdi mdi-crop-free"></i>
			    </a>
			</li>			
			<!-- <li class="btn-group nav-item d-none d-xl-inline-block">
				<a href="#" class="waves-effect waves-light nav-link rounded svg-bt-icon" title="">
					<i class="ti-check-box"></i>
			    </a>
			</li>
			<li class="btn-group nav-item d-none d-xl-inline-block">
				<a href="calendar.html" class="waves-effect waves-light nav-link rounded svg-bt-icon" title="">
					<i class="ti-calendar"></i>
			    </a>
			</li> -->
		  </ul>
	  </div>
		


      <div class="navbar-custom-menu r-side">
        <ul class="nav navbar-nav">
		  <!-- full Screen -->
	      <!-- <li class="search-bar">		  
			  <div class="lookup lookup-circle lookup-right">
			     <input type="text" name="s">
			  </div>
		  </li>			 -->


		
		
		  <!-- Notifications -->
	 <li class="dropdown notifications-menu">
			<a href="#" class="waves-effect waves-light rounded dropdown-toggle" data-toggle="dropdown" title="Notifications" id="notification-bell">
			  <i class="fa fa-bell" style="color:#000 !important;"></i>
			  <span id="notification-count" class="badge badge-danger" style="display: none; position: absolute; top: -5px; right: -5px; font-size: 10px;">0</span>
			</a>
			<ul class="dropdown-menu animated bounceIn" id="notification-dropdown">

			  <li class="header">
				<div class="p-20">
					<div class="flexbox">
						<div>
							<h4 class="mb-0 mt-0">Notifications</h4>
						</div>
						<div>
							<a href="#" class="text-danger" onclick="clearNotifications()">Clear All</a>
						</div>
					</div>
				</div>
			  </li>

			  <li>
				
		 <ul class="menu sm-scrol" id="notification-list">
				  <!-- Notifications will be loaded here dynamically -->
				  <li class="text-center text-muted p-3">
					  <i class="fa fa-bell-slash fa-2x mb-2 d-block"></i>
					  No new notifications
				  </li>
				</ul>
			  </li>
			  <li class="footer">
				  <a href="{{ route('project-updates.index') }}">View all</a>
			  </li>
			</ul>
		  </li>
		  
		  <!-- Attainance Logo -->
		  <li class="nav-item" style="margin-left: 10px;">
				<a href="#" class="waves-effect waves-light nav-link rounded" title="Attainance" style="background: #007bff; color: white; padding: 8px 12px; font-weight: bold; font-size: 12px;">
					ATTAINANCE
				</a>
		  </li>	
		   
		 
	      <!-- User Account - Show only for admin, employee, and customer roles -->
		  @if(auth()->check() && in_array(auth()->user()->role, [1, 2, 3]))
          <li style="margin-left:20px;" class="dropdown user user-menu">	
			  <button type="button" class="waves-effect waves-light rounded dropdown-toggle p-0" title="" id="userDropdownToggle" style="background: none; border: none; cursor: pointer;">
				<span style="display: flex; align-items: center; color: #333; text-decoration: none;">
					<div style="width: 32px; height: 32px; border-radius: 50%; background: #007bff; color: white; display: flex; align-items: center; justify-content: center; margin-right: 10px; font-weight: bold;">
						{{ substr(auth()->user()->name, 0, 1) }}
					</div>
					<div>
						<div style="font-weight: bold; color: #007bff;">{{ auth()->user()->name }}</div>
						<div style="font-size: 12px; color: #666;">{{ auth()->user()->role == 1 ? 'Admin' : (auth()->user()->role == 2 ? 'Employee' : 'Customer') }}</div>
					</div>
					<i class="fas fa-chevron-down ml-2" style="font-size: 12px;"></i>
				</span>
			</button>
			<ul class="dropdown-menu dropdown-menu-end animated flipInX" style="min-width: 200px;" aria-labelledby="userDropdownToggle">
			  <li>
				<a class="dropdown-item" href="{{ route('admin.profile') }}">
					<i class="ti-user text-muted mr-2"></i> Profile
				</a>
			  </li>
			  <li>
				<a class="dropdown-item" href="{{ route('logs') }}">
					<i class="ti-book text-muted mr-2"></i> Logs
				</a>
			  </li>
			  <li>
				<a class="dropdown-item" href="#">
					<i class="ti-settings text-muted mr-2"></i> Settings
				</a>
			  </li>
			  <li>
				<a class="dropdown-item" href="#">
					<i class="ti-help text-muted mr-2"></i> Help
				</a>
			  </li>
			</ul>
          </li>
		  @endif
		  
			
        </ul>
      </div>
    </nav>
  </header>

<script>
// Real-time Notification System
let notificationPollingInterval;
let lastNotificationCheck = Math.floor(Date.now() / 1000) - 1800; // 30 minutes ago

document.addEventListener('DOMContentLoaded', function() {
    // Start polling for notifications
    startNotificationPolling();
    
    // Initial notification load
    loadNotifications();
    
    // Simple dropdown show/hide functionality
    const userDropdownToggle = document.getElementById('userDropdownToggle');
    const userMenu = document.querySelector('.user-menu');
    const dropdownMenu = document.querySelector('.user-menu .dropdown-menu');
    
    if (userDropdownToggle && userMenu && dropdownMenu) {
        console.log('Setting up simple dropdown functionality');
        
        userDropdownToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            e.returnValue = false;
            
            console.log('Dropdown button clicked - preventing all navigation');
            
            // Simple toggle show/hide
            if (dropdownMenu.style.display === 'block') {
                dropdownMenu.style.display = 'none';
                userMenu.classList.remove('show');
                console.log('Dropdown hidden');
            } else {
                dropdownMenu.style.display = 'block';
                userMenu.classList.add('show');
                console.log('Dropdown shown');
            }
            
            return false;
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userMenu.contains(e.target)) {
                dropdownMenu.style.display = 'none';
                userMenu.classList.remove('show');
                console.log('Dropdown closed by outside click');
            }
        });

        // Prevent dropdown from closing when clicking inside it
        dropdownMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});

function startNotificationPolling() {
    // Poll every 30 seconds
    notificationPollingInterval = setInterval(loadNotifications, 30000);
}

function loadNotifications() {
    fetch('{{ route("notifications.index") }}?last_check=' + lastNotificationCheck, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        updateNotificationUI(data);
        if (data.timestamp) {
            lastNotificationCheck = data.timestamp;
        }
    })
    .catch(error => {
        console.error('Error loading notifications:', error);
    });
}

function updateNotificationUI(data) {
    const notificationList = document.getElementById('notification-list');
    const notificationCount = document.getElementById('notification-count');
    const notificationBell = document.getElementById('notification-bell');
    
    // Update notification count with unread count
    const unreadCount = data.unread_count || 0;
    notificationCount.textContent = unreadCount;
    notificationCount.style.display = unreadCount > 0 ? 'inline-block' : 'none';
    
    if (data.notifications && data.notifications.length > 0) {
        // Clear existing notifications
        notificationList.innerHTML = '';
        
        // Add new notifications
        data.notifications.forEach(notification => {
            const notificationItem = createNotificationItem(notification);
            notificationList.appendChild(notificationItem);
        });
        
        // Add animation to bell if there are new unread notifications
        if (unreadCount > 0) {
            notificationBell.classList.add('notification-bell-ring');
            setTimeout(() => {
                notificationBell.classList.remove('notification-bell-ring');
            }, 1000);
        }
        
    } else {
        // Show "no notifications" message
        notificationList.innerHTML = `
            <li class="text-center text-muted p-3">
                <i class="fa fa-bell-slash fa-2x mb-2 d-block"></i>
                No new notifications
            </li>
        `;
    }
}

function createNotificationItem(notification) {
    const li = document.createElement('li');
    li.className = 'notification-item';
    
    // Add read/unread class
    if (!notification.is_read) {
        li.classList.add('notification-unread');
    }
    
    // Determine icon based on type
    let iconClass = 'fa-info-circle text-info';
    if (notification.type === 'client_request') {
        iconClass = 'fa-comment-dots text-warning';
    } else if (notification.type === 'work_update') {
        iconClass = 'fa-tools text-success';
    }
    
    li.innerHTML = `
        <a href="#" onclick="handleNotificationClick('${notification.redirect_url}', ${notification.id}, event)" class="notification-link">
            <i class="fa ${iconClass}"></i>
            <div class="notification-content">
                <div class="notification-title">${notification.title}</div>
                <div class="notification-message">${notification.message}</div>
                <div class="notification-details">${notification.details}</div>
                <div class="notification-time">${notification.created_at}</div>
            </div>
            ${!notification.is_read ? '<div class="notification-indicator"></div>' : ''}
        </a>
    `;
    
    return li;
}

function handleNotificationClick(url, notificationId, event) {
    event.preventDefault();
    
    // Mark notification as read
    fetch(`{{ route('notifications.read', ':id') }}`.replace(':id', notificationId), {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update unread count
            const notificationCount = document.getElementById('notification-count');
            const newCount = data.unread_count || 0;
            notificationCount.textContent = newCount;
            notificationCount.style.display = newCount > 0 ? 'inline-block' : 'none';
            
            // Redirect to the URL
            window.location.href = url;
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
        // Still redirect even if marking as read fails
        window.location.href = url;
    });
}

function clearNotifications() {
    const notificationList = document.getElementById('notification-list');
    const notificationCount = document.getElementById('notification-count');
    
    // Mark all notifications as read
    fetch('{{ route("notifications.read-all") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Clear the UI
            notificationList.innerHTML = `
                <li class="text-center text-muted p-3">
                    <i class="fa fa-bell-slash fa-2x mb-2 d-block"></i>
                    No new notifications
                </li>
            `;
            
            // Hide count
            notificationCount.style.display = 'none';
            notificationCount.textContent = '0';
        }
    })
    .catch(error => {
        console.error('Error clearing notifications:', error);
    });
    
    // Prevent dropdown from closing
    event.preventDefault();
    return false;
}

// Clean up polling when page is unloaded
window.addEventListener('beforeunload', function() {
    if (notificationPollingInterval) {
        clearInterval(notificationPollingInterval);
    }
});
</script>


<style>
/* Simple User Dropdown Styles */
.user-menu .dropdown-menu {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    min-width: 200px;
    z-index: 9999;
}

.user-menu .dropdown-menu.show {
    display: block;
}

/* Notification Styles */
.notification-bell-ring {
    animation: ring 1s ease-in-out;
}

@keyframes ring {
    0%, 100% { transform: rotate(0deg); }
    10%, 30%, 50%, 70%, 90% { transform: rotate(-10deg); }
    20%, 40%, 60%, 80% { transform: rotate(10deg); }
}

.notification-content {
    margin-left: 10px;
    display: inline-block;
    vertical-align: top;
    width: calc(100% - 30px);
}

.notification-title {
    font-weight: 600;
    color: #333;
    margin-bottom: 2px;
}

.notification-message {
    font-size: 13px;
    color: #555;
    margin-bottom: 2px;
}

.notification-details {
    font-size: 12px;
    color: #777;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.notification-time {
    font-size: 11px;
    color: #999;
}

.notification-link {
    display: block;
    padding: 10px 15px;
    text-decoration: none;
    transition: background-color 0.2s;
}

.notification-link:hover {
    background-color: #f8f9fa;
    text-decoration: none;
}

.notification-item {
    border-bottom: 1px solid #eee;
}

.notification-item:last-child {
    border-bottom: none;
}

#notification-count {
    min-width: 18px;
    height: 18px;
    line-height: 18px;
    text-align: center;
    border-radius: 50%;
    font-weight: bold;
}

/* Unread notification styles */
.notification-unread {
    background-color: #f8f9fa;
    border-left: 3px solid #007bff;
}

.notification-unread .notification-title {
    font-weight: 700;
    color: #007bff;
}

.notification-indicator {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 8px;
    height: 8px;
    background-color: #007bff;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(0, 123, 255, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(0, 123, 255, 0);
    }
}

/* Ensure notification bell is visible */
#notification-bell {
    position: relative;
    display: inline-block;
    font-size: 18px;
    padding: 8px;
    color: #000 !important;
    text-decoration: none;
}

#notification-bell:hover {
    color: #007bff !important;
}

.notifications-menu {
    position: relative;
}

.notifications-menu .dropdown-menu {
    min-width: 300px;
    max-height: 400px;
    overflow-y: auto;
}
</style>


