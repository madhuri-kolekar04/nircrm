<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CRM') }} - WhatsApp Style</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            * {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            }

            html {
                scroll-behavior: smooth;
            }

            body {
                background: #fff;
                color: #111b21;
            }

            html.dark body {
                background: #0a0e27;
                color: #e0e0e0;
            }

            /* Scrollbar Styling */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }

            ::-webkit-scrollbar-track {
                background: transparent;
            }

            ::-webkit-scrollbar-thumb {
                background: #ccc;
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #999;
            }

            html.dark ::-webkit-scrollbar-thumb {
                background: #555;
            }

            html.dark ::-webkit-scrollbar-thumb:hover {
                background: #777;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="flex h-screen bg-white dark:bg-wa-dark-bg overflow-hidden">
            <!-- Collapsible Sidebar -->
            <div id="sidebar" class="sidebar-container w-sidebar hover:w-sidebar-expanded transition-all duration-300 ease-out bg-wa-sidebar dark:bg-wa-sidebar-dark border-r border-wa-border dark:border-wa-border-dark flex flex-col h-screen group">
                
                <!-- Logo Section -->
                <div class="flex items-center justify-center h-16 border-b border-wa-border dark:border-wa-border-dark flex-shrink-0">
                    <div class="flex items-center gap-3 px-4 w-full">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-wa-green to-wa-dark-green flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                            <i class="fas fa-robot"></i>
                        </div>
                        <div class="hidden group-hover:block opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <h1 class="font-bold text-wa-text-dark dark:text-white text-sm whitespace-nowrap">CRM System</h1>
                            <p class="text-xs text-wa-text-light dark:text-gray-400">Niranjan</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Items -->
                <nav class="flex-1 overflow-y-auto py-4 space-y-2 px-2">
                    <!-- Profile -->
                    <a href="#" class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark transition-colors duration-200 text-wa-text-dark dark:text-white" title="Profile">
                        <i class="fas fa-user w-6 text-center text-lg"></i>
                        <span class="hidden group-hover:inline text-sm font-medium whitespace-nowrap">Profile</span>
                    </a>

                    <!-- Notifications -->
                    <a href="#" class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark transition-colors duration-200 text-wa-text-dark dark:text-white relative" title="Notifications">
                        <div class="relative">
                            <i class="fas fa-bell w-6 text-center text-lg"></i>
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-wa-green text-white text-xs rounded-full flex items-center justify-center font-bold">3</span>
                        </div>
                        <span class="hidden group-hover:inline text-sm font-medium whitespace-nowrap">Notifications</span>
                    </a>

                    <!-- Chat -->
                    <a href="#" class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark transition-colors duration-200 text-wa-text-dark dark:text-white" title="Chat">
                        <i class="fas fa-comments w-6 text-center text-lg"></i>
                        <span class="hidden group-hover:inline text-sm font-medium whitespace-nowrap">Chat</span>
                    </a>

                    <div class="hidden group-hover:block my-4 border-t border-wa-border dark:border-wa-border-dark"></div>

                    <!-- Menu Items -->
                    <div class="hidden group-hover:block">
                        <p class="px-3 py-2 text-xs font-semibold text-wa-text-light dark:text-gray-400 uppercase tracking-wider">Menu</p>
                    </div>

                    <a href="#" onclick="loadSection('dashboard')" class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark transition-colors duration-200 text-wa-text-dark dark:text-white" title="Dashboard">
                        <i class="fas fa-chart-line w-6 text-center text-lg"></i>
                        <span class="hidden group-hover:inline text-sm font-medium whitespace-nowrap">Dashboard</span>
                    </a>

                    <a href="#" onclick="loadSection('employees')" class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark transition-colors duration-200 text-wa-text-dark dark:text-white" title="Employees">
                        <i class="fas fa-users w-6 text-center text-lg"></i>
                        <span class="hidden group-hover:inline text-sm font-medium whitespace-nowrap">Employees</span>
                    </a>

                    <a href="#" onclick="loadSection('customers')" class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark transition-colors duration-200 text-wa-text-dark dark:text-white" title="Customers">
                        <i class="fas fa-user-tie w-6 text-center text-lg"></i>
                        <span class="hidden group-hover:inline text-sm font-medium whitespace-nowrap">Customers</span>
                    </a>

                    <a href="#" onclick="loadSection('invoices')" class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark transition-colors duration-200 text-wa-text-dark dark:text-white" title="Invoices">
                        <i class="fas fa-file-invoice w-6 text-center text-lg"></i>
                        <span class="hidden group-hover:inline text-sm font-medium whitespace-nowrap">Invoices</span>
                    </a>

                    <a href="#" onclick="loadSection('projects')" class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark transition-colors duration-200 text-wa-text-dark dark:text-white" title="Projects">
                        <i class="fas fa-project-diagram w-6 text-center text-lg"></i>
                        <span class="hidden group-hover:inline text-sm font-medium whitespace-nowrap">Projects</span>
                    </a>

                    <a href="#" onclick="loadSection('leads')" class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark transition-colors duration-200 text-wa-text-dark dark:text-white" title="Leads">
                        <i class="fas fa-star w-6 text-center text-lg"></i>
                        <span class="hidden group-hover:inline text-sm font-medium whitespace-nowrap">Leads</span>
                    </a>

                    <a href="#" onclick="loadSection('tasks')" class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark transition-colors duration-200 text-wa-text-dark dark:text-white" title="Tasks">
                        <i class="fas fa-tasks w-6 text-center text-lg"></i>
                        <span class="hidden group-hover:inline text-sm font-medium whitespace-nowrap">Tasks</span>
                    </a>

                    <a href="#" onclick="loadSection('categories')" class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark transition-colors duration-200 text-wa-text-dark dark:text-white" title="Categories">
                        <i class="fas fa-layer-group w-6 text-center text-lg"></i>
                        <span class="hidden group-hover:inline text-sm font-medium whitespace-nowrap">Categories</span>
                    </a>
                </nav>

                <!-- Bottom Section -->
                <div class="border-t border-wa-border dark:border-wa-border-dark pt-4 pb-4 px-2 space-y-2">
                    <!-- Theme Toggle -->
                    <button id="themeToggle" class="sidebar-item w-full flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark transition-colors duration-200 text-wa-text-dark dark:text-white" title="Toggle Theme">
                        <i class="fas fa-moon w-6 text-center text-lg"></i>
                        <span class="hidden group-hover:inline text-sm font-medium whitespace-nowrap">Dark Mode</span>
                    </button>

                    <!-- Settings -->
                    <a href="#" class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark transition-colors duration-200 text-wa-text-dark dark:text-white" title="Settings">
                        <i class="fas fa-cog w-6 text-center text-lg"></i>
                        <span class="hidden group-hover:inline text-sm font-medium whitespace-nowrap">Settings</span>
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="sidebar-item w-full flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark transition-colors duration-200 text-wa-text-dark dark:text-white" title="Logout">
                            <i class="fas fa-sign-out-alt w-6 text-center text-lg"></i>
                            <span class="hidden group-hover:inline text-sm font-medium whitespace-nowrap">Logout</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Header -->
                <div class="h-16 bg-wa-sidebar dark:bg-wa-sidebar-dark border-b border-wa-border dark:border-wa-border-dark flex items-center justify-between px-6 flex-shrink-0">
                    <div class="flex items-center gap-4">
                        <h2 id="pageTitle" class="text-xl font-bold text-wa-text-dark dark:text-white">Dashboard</h2>
                    </div>
                    <div class="flex items-center gap-4">
                        <button class="p-2 hover:bg-wa-hover dark:hover:bg-wa-hover-dark rounded-lg transition-colors duration-200">
                            <i class="fas fa-search text-wa-text-light dark:text-gray-400 text-lg"></i>
                        </button>
                        <button class="p-2 hover:bg-wa-hover dark:hover:bg-wa-hover-dark rounded-lg transition-colors duration-200">
                            <i class="fas fa-ellipsis-v text-wa-text-light dark:text-gray-400 text-lg"></i>
                        </button>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="flex-1 overflow-hidden flex">
                    <!-- List Panel (25-30%) -->
                    <div id="listPanel" class="w-1/4 border-r border-wa-border dark:border-wa-border-dark bg-wa-sidebar dark:bg-wa-sidebar-dark overflow-y-auto">
                        <!-- Search Bar -->
                        <div class="sticky top-0 p-4 bg-wa-sidebar dark:bg-wa-sidebar-dark border-b border-wa-border dark:border-wa-border-dark z-10">
                            <div class="relative">
                                <i class="fas fa-search absolute left-3 top-3 text-wa-text-light dark:text-gray-400"></i>
                                <input type="text" id="searchInput" placeholder="Search or start new chat" class="w-full pl-10 pr-4 py-2 rounded-full bg-wa-hover dark:bg-wa-hover-dark border border-wa-border dark:border-wa-border-dark text-wa-text-dark dark:text-white placeholder-wa-text-light dark:placeholder-gray-400 focus:outline-none focus:border-wa-green">
                            </div>
                        </div>

                        <!-- List Items Container -->
                        <div id="listContainer" class="divide-y divide-wa-border dark:divide-wa-border-dark">
                            <!-- Items will be loaded here -->
                        </div>
                    </div>

                    <!-- Chat/Detail Panel (70-75%) -->
                    <div id="chatPanel" class="flex-1 flex flex-col bg-wa-light-bg dark:bg-wa-msg-bg-dark overflow-hidden">
                        <!-- Chat Header -->
                        <div id="chatHeader" class="h-16 bg-wa-sidebar dark:bg-wa-sidebar-dark border-b border-wa-border dark:border-wa-border-dark flex items-center justify-between px-6 flex-shrink-0">
                            <div class="flex items-center gap-4">
                                <div id="chatAvatar" class="w-10 h-10 rounded-full bg-gradient-to-br from-wa-green to-wa-dark-green flex items-center justify-center text-white font-bold">
                                    <i class="fas fa-robot"></i>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <button class="p-2 hover:bg-wa-hover dark:hover:bg-wa-hover-dark rounded-lg transition-colors duration-200">
                                    <i class="fas fa-phone text-wa-text-light dark:text-gray-400 text-lg"></i>
                                </button>
                                <button class="p-2 hover:bg-wa-hover dark:hover:bg-wa-hover-dark rounded-lg transition-colors duration-200">
                                    <i class="fas fa-video text-wa-text-light dark:text-gray-400 text-lg"></i>
                                </button>
                                <button class="p-2 hover:bg-wa-hover dark:hover:bg-wa-hover-dark rounded-lg transition-colors duration-200">
                                    <i class="fas fa-info-circle text-wa-text-light dark:text-gray-400 text-lg"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Messages/Content Area -->
                        <div id="messagesContainer" class="flex-1 overflow-y-auto p-6 space-y-4">
                            <div class="text-center py-12">
                                <i class="fas fa-inbox text-6xl text-wa-text-light dark:text-gray-600 mb-4"></i>
                                <p class="text-wa-text-light dark:text-gray-400">Select an item to view details</p>
                            </div>
                        </div>

                        <!-- Input Area -->
                        <div id="inputArea" class="bg-wa-sidebar dark:bg-wa-sidebar-dark border-t border-wa-border dark:border-wa-border-dark p-4 flex-shrink-0">
                            <div class="flex items-end gap-4">
                                <button class="p-2 hover:bg-wa-hover dark:hover:bg-wa-hover-dark rounded-lg transition-colors duration-200">
                                    <i class="fas fa-paperclip text-wa-green text-lg"></i>
                                </button>
                                <input type="text" id="messageInput" placeholder="Type a message..." class="flex-1 px-4 py-2 rounded-lg bg-wa-hover dark:bg-wa-hover-dark border border-wa-border dark:border-wa-border-dark text-wa-text-dark dark:text-white placeholder-wa-text-light dark:placeholder-gray-400 focus:outline-none focus:border-wa-green">
                                <button class="p-2 hover:bg-wa-hover dark:hover:bg-wa-hover-dark rounded-lg transition-colors duration-200">
                                    <i class="fas fa-smile text-wa-green text-lg"></i>
                                </button>
                                <button id="sendBtn" class="p-2 bg-wa-green hover:bg-wa-dark-green text-white rounded-lg transition-colors duration-200">
                                    <i class="fas fa-paper-plane text-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
        <script>
            // Theme Toggle
            const themeToggle = document.getElementById('themeToggle');
            const html = document.documentElement;

            // Check for saved theme preference or default to light mode
            const currentTheme = localStorage.getItem('theme') || 'light';
            if (currentTheme === 'dark') {
                html.classList.add('dark');
            }

            themeToggle.addEventListener('click', () => {
                html.classList.toggle('dark');
                const isDark = html.classList.contains('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
            });

            // Load Section
            function loadSection(section) {
                const pageTitle = document.getElementById('pageTitle');
                const listContainer = document.getElementById('listContainer');
                
                pageTitle.textContent = section.charAt(0).toUpperCase() + section.slice(1);
                
                // Mock data for different sections
                const mockData = {
                    employees: [
                        { id: 1, name: 'John Doe', email: 'john@example.com', status: 'Online', avatar: 'JD' },
                        { id: 2, name: 'Jane Smith', email: 'jane@example.com', status: 'Offline', avatar: 'JS' },
                        { id: 3, name: 'Mike Johnson', email: 'mike@example.com', status: 'Online', avatar: 'MJ' },
                    ],
                    customers: [
                        { id: 1, name: 'Acme Corp', email: 'contact@acme.com', status: 'Active', avatar: 'AC' },
                        { id: 2, name: 'Tech Solutions', email: 'info@tech.com', status: 'Active', avatar: 'TS' },
                        { id: 3, name: 'Global Industries', email: 'hello@global.com', status: 'Inactive', avatar: 'GI' },
                    ],
                    invoices: [
                        { id: 'INV-001', name: 'Invoice #001', email: '$5,000', status: 'Paid', avatar: 'I1' },
                        { id: 'INV-002', name: 'Invoice #002', email: '$3,200', status: 'Pending', avatar: 'I2' },
                        { id: 'INV-003', name: 'Invoice #003', email: '$7,500', status: 'Overdue', avatar: 'I3' },
                    ],
                };

                const data = mockData[section] || [];
                listContainer.innerHTML = data.map(item => `
                    <div onclick="selectItem(${item.id}, '${item.name}', '${item.email}')" class="p-4 hover:bg-wa-hover dark:hover:bg-wa-hover-dark cursor-pointer transition-colors duration-200 border-b border-wa-border dark:border-wa-border-dark">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-wa-green to-wa-dark-green flex items-center justify-center text-white font-bold flex-shrink-0">
                                ${item.avatar}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-wa-text-dark dark:text-white truncate">${item.name}</h4>
                                <p class="text-sm text-wa-text-light dark:text-gray-400 truncate">${item.email}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="text-xs font-medium px-2 py-1 rounded-full ${item.status === 'Online' || item.status === 'Active' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200'}">${item.status}</span>
                            </div>
                        </div>
                    </div>
                `).join('');
            }

            // Select Item
            function selectItem(id, name, email) {
                const chatName = document.getElementById('chatName');
                const chatStatus = document.getElementById('chatStatus');
                const messagesContainer = document.getElementById('messagesContainer');

                chatName.textContent = name;
                chatStatus.textContent = email;

                // Mock message display
                messagesContainer.innerHTML = `
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-wa-green to-wa-dark-green flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                ${name.split(' ').map(n => n[0]).join('')}
                            </div>
                            <div class="flex-1">
                                <div class="bg-wa-bubble-in dark:bg-wa-hover-dark rounded-lg p-3 max-w-msg">
                                    <p class="text-wa-text-dark dark:text-white text-sm">Hello! This is ${name}'s profile information.</p>
                                </div>
                                <p class="text-xs text-wa-text-light dark:text-gray-400 mt-1">10:30 AM</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-3 justify-end">
                            <div class="flex-1"></div>
                            <div class="flex-1 max-w-msg">
                                <div class="bg-wa-bubble-out dark:bg-wa-green rounded-lg p-3">
                                    <p class="text-wa-text-dark dark:text-white text-sm">Email: ${email}</p>
                                </div>
                                <div class="flex justify-end gap-1 mt-1">
                                    <p class="text-xs text-wa-text-light dark:text-gray-400">10:31 AM</p>
                                    <i class="fas fa-check-double text-wa-green text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-wa-border dark:border-wa-border-dark pt-4 mt-4">
                            <h4 class="font-semibold text-wa-text-dark dark:text-white mb-3">Details</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-wa-text-light dark:text-gray-400">ID:</span>
                                    <span class="text-wa-text-dark dark:text-white font-medium">${id}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-wa-text-light dark:text-gray-400">Name:</span>
                                    <span class="text-wa-text-dark dark:text-white font-medium">${name}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-wa-text-light dark:text-gray-400">Email:</span>
                                    <span class="text-wa-text-dark dark:text-white font-medium">${email}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-2 pt-4">
                            <button class="flex-1 px-4 py-2 bg-wa-green hover:bg-wa-dark-green text-white rounded-lg font-medium transition-colors duration-200 text-sm">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </button>
                            <button class="flex-1 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium transition-colors duration-200 text-sm">
                                <i class="fas fa-trash mr-2"></i>Delete
                            </button>
                        </div>
                    </div>
                `;
            }

            // Load initial section
            loadSection('employees');
        </script>
    </body>
</html>
