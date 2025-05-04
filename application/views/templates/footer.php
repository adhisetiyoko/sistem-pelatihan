<!-- footer.php -->
<footer class="bg-light py-4 mt-auto">
    <div class="container">
        <div class="text-center">
            <p class="mb-0 text-muted">&copy; <?= date('Y') ?> Sistem Pelatihan. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script Tambahan -->
<?php if (isset($scripts)): ?>
    <?php foreach ($scripts as $script): ?>
        <script src="<?= base_url('assets/js/' . $script) ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

<script>
    $(document).ready(function() {
        // Auto close alert
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);

        // Inisialisasi tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // TIDAK PERLU inisialisasi dropdown manual karena Bootstrap 5 akan otomatis menginisialisasinya
        // $('.dropdown-toggle').dropdown(); -- hapus baris ini

        <?php if (isset($inline_js)): ?>
            <?= $inline_js ?>
        <?php endif; ?>
    });

    document.querySelectorAll('.user-dropdown').forEach(el => {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdown = new bootstrap.Dropdown(this.nextElementSibling);
            dropdown.toggle();
        });
    });
</script>

<!-- jQuery (sudah ada) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery UI (harus ditambahkan) -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>


</body>

</html>