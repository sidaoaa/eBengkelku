<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard EbengkelKu</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    #logo-sidebar {
      transition: transform 0.3s ease;
    }

    .sidebar-open {
      transform: translateX(0);
    }

    .sidebar-closed {
      transform: translateX(-100%);
    }

    .content-expanded {
      margin-left: 0 !important;
    }

    #master-data-menu {
      overflow: hidden;
      transition: height 0.5s ease-in-out;
      height: 0;
    }

    #master-data-menu.expanded {
      height: auto;
    }

    @media (max-width: 640px) {
      .sidebar-closed {
        transform: translateX(-100%);
      }

      .content-expanded {
        margin-left: 16rem;
      }
    }
  </style>
</head>

<body style="font-family: Inter" class="bg-[#F9F9F9]">
  <nav class="fixed top-0 z-30 w-full bg-neutral-100 text-black border-b border-gray-200">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-start rtl:justify-end">
          <button id="hamburger-menu" type="button"
            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
              </path>
            </svg>
          </button>
          <div class="text-xl font-semibold text-black flex items-center ml-4">
            <img src="{{ asset('logos/logo_side.png') }}" alt="" class="transition-all duration-300 w-40">
          </div>
        </div>
      </div>
    </div>
  </nav>

  <aside id="logo-sidebar"
    class="fixed top-0 left-0 z-20 w-64 h-screen pt-20 bg-neutral-100 border-r sidebar-open sm:sidebar-closed"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-neutral-100 border-r">
      <ul class="space-y-2 font-medium text-sm">
        <a href="{{ route('profile.dashboard') }}" class="mb-2">
          <li
            class="flex items-center p-4 rounded-md hover:bg-blue-500 hover:text-white {{ request()->routeIs('admin.dashboard') ? ' text-white' : '' }}">
            <i class="fa-solid fa-house-chimney mx-3"></i><span>Dashboard</span>
          </li>
        </a>
        <li class="flex items-center p-4 rounded-md hover:bg-blue-500 hover:text-white justify-between cursor-pointer"
          id="master-data-toggle">
          <div class="flex items-center">
            <i class="fa-solid fa-tools fa-sm mx-4"></i><span>Workshop</span>
          </div>
          <span>
            <i class="fa-solid fa-chevron-right" id="master-data-icon"></i>
          </span>
        </li>

        <ul class="space-y-2 ml-8 hidden" id="master-data-menu">
          <a href="{{ route('workshop_seller.setting') }}" class="block mb-2 items-center">
            <li
              class="submenu-item transform transition-all duration-300 hover:translate-x-2 flex items-center p-2 rounded-md hover:bg-sky-500 hover:text-white {{ request()->routeIs('admin.brand.index') ? ' text-white' : '' }}">
              <i class="fa-solid fa-city mx-4"></i><span>My Workshop</span>
            </li>
          </a>
          <a href="{{ route('service.setting') }}" class="mb-2 block items-center">
            <li
              class="submenu-item transform transition-all duration-300 hover:translate-x-2 flex items-center p-2 rounded-md hover:bg-sky-500 hover:text-white {{ request()->routeIs('admin.brand.index') ? ' text-white' : '' }}">
              <i class="fa-solid fa-wrench mx-4"></i><span>Service</span>
            </li>
          </a>
          <a href="{{ route('spare_part.setting') }}" class="block mb-2 items-center">
            <li
              class="submenu-item transform transition-all duration-300 hover:translate-x-2 flex items-center p-2 rounded-md hover:bg-sky-500 hover:text-white {{ request()->routeIs('admin.brand.index') ? ' text-white' : '' }}">
              <i class="fa-solid fa-boxes-stacked mx-4"></i><span>SpareParts</span>
            </li>
          </a>
          <a href="{{ route('product.setting') }}" class="block mb-2 items-center">
            <li
              class="submenu-item transform transition-all duration-300 hover:translate-x-2 flex items-center p-2 rounded-md hover:bg-sky-500 hover:text-white {{ request()->routeIs('admin.brand.index') ? ' text-white' : '' }}">
              <i class="fa-solid fa-dolly mx-4"></i><span>Product</span>
            </li>
          </a>
          <a href="" class="block mb-2 items-center">
            <li
              class="submenu-item transform transition-all duration-300 hover:translate-x-2 flex items-center p-2 rounded-md hover:bg-sky-500 hover:text-white {{ request()->routeIs('admin.brand.index') ? ' text-white' : '' }}">
              <i class="fa-solid fa-file-pen mx-4"></i><span>Stock Management</span>
            </li>
          </a>
          <a href="{{ route('invoice') }}" class="block mb-2 items-center">
            <li
              class="submenu-item transform transition-all duration-300 hover:translate-x-2 flex items-center p-2 rounded-md hover:bg-sky-500 hover:text-white {{ request()->routeIs('admin.brand.index') ? ' text-white' : '' }}">
              <i class="fas fa-file-invoice-dollar mx-4"></i><span>Invoice</span>
            </li>
          </a>
          <a href="{{ route('my.sale') }}" class="block mb-2 items-center">
            <li
              class="submenu-item transform transition-all duration-300 hover:translate-x-2 flex items-center p-2 rounded-md hover:bg-sky-500 hover:text-white {{ request()->routeIs('admin.brand.index') ? ' text-white' : '' }}">
              <i class="fas fa-tag mx-4"></i><span>My Sale</span>
            </li>
          </a>
        </ul>
        <a href="" class="block mb-2 items-center">
          <li
            class="flex items-center p-4 rounded-md hover:bg-blue-500 hover:text-white {{ request()->routeIs('admin.dashboard') ? ' text-white' : '' }}">
            <i class="fa-solid fa-car-side mx-4"></i><span>Used Car</span>
          </li>
        </a>
        <a href="../profile" class="block mb-2 items-center">
          <li
            class="flex items-center p-4 rounded-md hover:bg-blue-500 hover:text-white {{ request()->routeIs('') ? ' text-white' : '' }}">
            <i class="fa-solid fa-chevron-left mx-4"></i><span>Back</span>
          </li>
        </a>
      </ul>
    </div>
  </aside>

  <div id="main-content" class="p-4 mt-3 transition-all duration-300 sm:ml-64">
    @yield('content')
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('master-data-toggle').addEventListener('click', function() {
        const menu = document.getElementById('master-data-menu');
        const icon = document.getElementById('master-data-icon');
        menu.classList.toggle('hidden');
        icon.classList.toggle('fa-chevron-right');
        icon.classList.toggle('fa-chevron-down');
      });

      var sidebar = document.getElementById('logo-sidebar');
      var hamburgerMenu = document.getElementById('hamburger-menu');
      var mainContent = document.getElementById('main-content');
      hamburgerMenu.addEventListener('click', function() {
        sidebar.classList.toggle('sidebar-open');
        sidebar.classList.toggle('sidebar-closed');
        mainContent.classList.toggle('content-expanded');
      });
      document.getElementById('master-data-toggle').addEventListener('click', function() {
        var submenu = document.getElementById('master-data-menu');
        var icon = document.getElementById('master-data-icon');
        if (submenu.classList.contains('expanded')) {
          submenu.classList.remove('expanded');
          submenu.style.height = '0';
          icon.classList.remove('fa-chevron-down');
          icon.classList.add('fa-chevron-right');
        } else {
          submenu.classList.add('expanded');
          submenu.style.height = submenu.scrollHeight + 'px';
          icon.classList.remove('fa-chevron-right');
          icon.classList.add('fa-chevron-down');
        }
      });

      function checkScreenSize() {
        if (window.innerWidth > 650) {
          sidebar.classList.add('sidebar-closed');
          sidebar.classList.remove('sidebar-closed');
          mainContent.classList.remove('content-expanded');
        } else {
          sidebar.classList.add('sidebar-open');
          sidebar.classList.remove('sidebar-open');
          mainContent.classList.remove('content-expanded');
        }
      }

      checkScreenSize();

      window.addEventListener('resize', checkScreenSize);

    });
  </script>
</body>

</html>
