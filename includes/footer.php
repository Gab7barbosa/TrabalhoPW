        </div>
    </main>

    <!-- Mobile Navigation Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('mobile-menu-btn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (menuBtn && sidebar && overlay) {
                function toggleMenu() {
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                }

                menuBtn.addEventListener('click', toggleMenu);
                overlay.addEventListener('click', toggleMenu);
            }
        });
    </script>
</body>
</html>
