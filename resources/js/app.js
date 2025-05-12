import 'bootstrap';

document.addEventListener("DOMContentLoaded", function () {
    // Sidebar toggle
    const toggleButton = document.getElementById("sidebarToggle");
    const sidebar = document.querySelector(".sidebar");
    const content = document.querySelector(".col-md-9");

    if (toggleButton) {
        toggleButton.addEventListener("click", function () {
            sidebar.classList.toggle("d-none"); // Sembunyikan atau tampilkan sidebar
            content.classList.toggle("col-md-12"); // Perluas konten jika sidebar disembunyikan
            content.classList.toggle("col-md-9"); // Kembalikan ukuran konten jika sidebar ditampilkan
        });
    }

    // Tab switching
    const tabs = document.querySelectorAll('.tab-link');
    const tabContents = document.querySelectorAll('.tab-content');

    if (tabs.length > 0) {
        function switchTab(event) {
            event.preventDefault();

            // Remove active classes from all tabs and hide all contents
            tabs.forEach(tab => {
                tab.classList.remove('text-blue-600', 'border-blue-600');
                tab.classList.add('text-blue-500', 'border-transparent');
            });
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            // Add active class to the clicked tab and show the corresponding content
            const targetTab = event.target;
            targetTab.classList.add('text-blue-600', 'border-blue-600');
            const contentId = targetTab.id + '-content';
            document.getElementById(contentId).classList.remove('hidden');
        }

        // Add event listeners to all tabs
        tabs.forEach(tab => {
            tab.addEventListener('click', switchTab);
        });

        // Optionally: Set the first tab as active by default
        document.getElementById('tab1').click();
    }
});
